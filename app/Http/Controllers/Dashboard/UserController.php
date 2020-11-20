<?php

namespace App\Http\Controllers\Dashboard;

use  App\Http\Requests\CreateUsersRequest;
use App\Http\Controllers\Controller;

use Storage;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{


    public function __construct(){

        $this->middleware(['permission:users_read'])->only('index');
        $this->middleware(['permission:users_create'])->only('create');
        $this->middleware(['permission:users_update'])->only('edit');
        $this->middleware(['permission:users_delete'])->only('destroy');

    }// end of construct

    public function index(Request $request)
    {

        $users = User::whereRoleIs('admin')->where(function($q) use($request){

            return $q->when($request->search , function($query) use($request){

                return $query->where('first_name' , 'like' , '%' .$request->search. '%')
                 ->orWhere('last_name' , 'like' , '%' .$request->search. '%');

            });

        })->latest()->paginate(PAGINATION_COUNT);;

        
        return view('dashboard.users.index',compact('users'));
        
    }// end of index




    public function create()
    {
        return view('dashboard.users.create');

    }// end of create




    public function store(CreateUsersRequest $request)
    {
// dd($request);
        $request_data = $request->except(['password' , 'password_confirmation' , 'permissions','image']);

        $request_data['password'] = bcrypt($request->password);

        if ($request->image) {
            
            SaveImage('images/user_images/' , $request->image);

            $request_data['image'] = $request->image->hashName();

        }// end of if


        $user = User::create($request_data);

        $user->attachRole('admin');

        $user->syncPermissions($request->permissions);

        session()->flash('success' , __('site.added_successfully'));
        return redirect()->route('dashboard.users.index');
    }


    

    public function edit(User $user)
    {

        return view('dashboard.users.edit',compact('user'));

    }// end of edit


    

    public function update(Request $request, User $user)
    {


        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => ['required' ,Rule::unique('users')->ignore($user->id)],
            'image' => 'image',
            'permissions' => 'required|min:1'
        ]);

        $request_data = $request->except(['permissions' , 'image']);

        if ($request->image) {
            
            if ($user->image != 'user.png') {

                Storage::disk('public_images')->delete('/user_images/' .$user->image);

            }// end of inner if

            SaveImage('images/user_images/' , $request->image);

                $request_data['image'] = $request->image->hashName();

        }// end of external if
        
        $user->update($request_data);

        $user->syncPermissions($request->permissions);

        session()->flash('success' , __('site.updated_successfully'));
        return redirect()->route('dashboard.users.index');

    }// end ofr update




    public function destroy(User $user)
    {

        if ($user->image != 'user.png') {
            
            Storage::disk('public_images')->delete('/user_images/' .$user->image);

        }// end if
         
        $user->delete();

        session()->flash('success' , __('site.deleted_successfully'));
        return redirect()->route('dashboard.users.index');

    }// end of destroy
}
