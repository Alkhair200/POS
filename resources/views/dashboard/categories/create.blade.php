@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class='content-header'>
            <h1>@lang('site.categories')</h1>
            <ol class="breadcrumb">
            <li><a href="{{--route('dashboard.welcome')--}}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li><a href="{{route('dashboard.categories.index')}}">@lang('site.categories')</a></li>
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

                    <form action="{{route('dashboard.categories.store')}}" method="POST">
                        @csrf
                        {{method_field('post')}}


                            @foreach (config('translatable.locales') as $locale)
                            
                                <div class="form-group">
                                    <label>@lang('site.' .$locale. '.name')</label>
                                    <input type="text" name="{{$locale}}[name]" class="form-control" value="{{old($locale. '.name')}}">
                                </div>

                            @endforeach

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class=" fa fa-plus">@lang('site.add')</i></button>
                            </div>
                    </form>    

            </div><!-- end of box body -->
        </section>
    </div>
@endsection