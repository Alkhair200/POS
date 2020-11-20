@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class='content-header'>
            <h1>@lang('site.clients')</h1>
            <ol class="breadcrumb">
                <li><a href="{{--route('dashboard.welcome')--}}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li class="active">@lang('site.clients')</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header">
                <h3 class="box-title" style="margin-bottom: 15px">@lang('site.clients')<small>{{--' ( ' .$clients->total(). ' )'--}}</small></h3>
                   
                   
                <form action="{{route('dashboard.clients.index')}}" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{request()->search}}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>@lang('site.search')</button>
                               
                                @if (auth()->user()->hasPermission('clients_create'))
                                <a href="{{route('dashboard.clients.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.add')</a>
                               @else
                                <a href="#" class="btn btn-primary disabled"><i class="fa fa-search"></i>@lang('site.add')</a>
                                @endif
                           
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-body">
                    @if (isset($clients) && $clients->count() > 0)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.phone')</th>
                                <th>@lang('site.address')</th>
                                <th>@lang('site.add_order')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $index=>$client)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$client -> name}}</td>
                            <td>{{is_array($client->phone) ? implode('-' , $client-> phone) : $client-> phone}}</td>
                            <td>{{$client-> address}}</td>

                            @if (auth()->user()->hasPermission('orders_update'))
                                <td><a href="{{route('dashboard.clients.orders.create',$client->id)}}" class="btn btn-primary btn-sm">@lang('site.add_order')</a></td>
                            @else
                                <td><button class="btn btn-primary btn-sm disabled"><i class="fa fa-create"></i>@lang('site.add_order')</button></td>
                            @endif 
                            
                            <td>
                                @if (auth()->user()->hasPermission('clients_update'))
                                <a href="{{route('dashboard.clients.edit',$client->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i>@lang('site.edit')</a>
                                @else
                                  <button class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i>@lang('site.update')</button>
                                @endif 
                                
                                
                            @if (auth()->user()->hasPermission('clients_delete'))
                                <form method="post" action="{{route('dashboard.clients.destroy',$client->id)}}" style="display: inline-block">
                                    @csrf
                                    {{method_field('delete')}}
                                    <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i>@lang('site.delete')</button>
                                </form>
                            @else
                                <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i>@lang('site.delete')</button>
                                @endif
                            </td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="content-center">

                        {{$clients->appends(request()->query())->links()}}
                        
                    </div>
                    @else
                       <h2> @lang('site.no_data_found')</h2>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection