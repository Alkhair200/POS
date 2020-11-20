@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class='content-header'>
            <h1>@lang('site.users')</h1>
            <ol class="breadcrumb">
            <li><a href="{{--route('dashboard.welcome')--}}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li><a href="{{--route('dashboard.users.index')--}}">@lang('site.users')</a></li>
                <li class="active">@lang('site.add')</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.add') {{--<small>Quick Exapm</small>--}}</h3>
                </div> <!----End box of header----->
                <div class="box-body">
                    
                    @include('partials._errors')

                    <form action="{{route('dashboard.users.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{method_field('post')}}
                            <div class="form-group">
                                <label>@lang('site.first_name')</label>
                                <input type="text" name="first_name" class="form-control" value="{{old('first_name')}}">
                            </div>
    
    
                            <div class="form-group">
                                <label>@lang('site.last_name')</label>
                                <input type="text" name="last_name" class="form-control" value="{{old('last_name')}}">
                            </div>
    
                            <div class="form-group">
                                <label>@lang('site.email')</label>
                                <input type="email" name="email" class="form-control" value="{{old('email')}}">
                            </div>
    
                            <div class="form-group">
                                <label>@lang('site.password')</label>
                                <input type="password" name="password" class="form-control">
                            </div>
    
                            <div class="form-group">
                                <label>@lang('site.password.confirmation')</label>
                                <input type="password" name="password.confirmation" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>@lang('site.photo')</label>
                                <input type="file" name="image" class="form-control image">
                            </div>
    
                            <div class="form-group">
                            <img src="{{asset('images/user_images/user.png')}}" style="width: 100px;" class="thumbnail image-preview"  alt="">
                            </div>
                            
                            <div class="form-group">
                                <!-- Custom Tabs -->
                                <div class="card">
                                <div class="card-header d-flex p-0">
                                    <h3 class="card-title p-3">@lang('site.permissions')</h3>

                                    @php
                                        $models = ['users' , 'categories' , 'products' , 'clients' , 'orders'];
                                        $maps = ['create' , 'read' , 'update' , 'delete'];
                                    @endphp

                                    <ul class="nav nav-pills ml-auto p-2">

                                        @foreach ($models as $index=> $model)
                                        
                                            <li class="nav-item"><a class="nav-link {{$index == 0 ? 'active' : ''}}" href="#{{$model}}" data-toggle="tab">@lang('site.' .$model)</a></li>

                                        @endforeach
                                    </ul>
                                </div><!-- /.card-header -->

                                <div class="card-body">
                                    <div class="tab-content">

                                        @foreach ($models as $index=> $model)
                                        
                                        <div class="tab-pane {{$index == 0 ? 'active' : ''}}" id="{{$model}}">

                                            @foreach ($maps as $map)
                                            <label><input type="checkbox" name="permissions[]" value="{{$model. '_' .$map}}">@lang('site.' .$map)</label>
                                            @endforeach
                                            
                                        </div>

                                        @endforeach

                                    <!-- /.tab-pane -->
                                    </div>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                                </div>
                                <!-- ./card -->
                            </div>
                              <!-- END CUSTOM TABS -->

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class=" fa fa-plus">@lang('site.add')</i></button>
                            </div>
                    </form>    

            </div><!-- end of box body -->
        </section>
    </div>
@endsection