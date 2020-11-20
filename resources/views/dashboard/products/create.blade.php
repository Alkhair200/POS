@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class='content-header'>
            <h1>@lang('site.products')</h1>
            <ol class="breadcrumb">
            <li><a href="{{--route('dashboard.welcome')--}}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li><a href="{{route('dashboard.products.index')}}">@lang('site.products')</a></li>
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

                    <form action="{{route('dashboard.products.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{method_field('post')}}

                        <div class="form-group">
                            <label>@lang('site.categories')</label>
                            <select name="category_id" class="form-control">

                                <option value="">@lang('site.all.categories')</option>

                                    @foreach ($categories as $category)

                                        <option value="{{$category->id}}" {{old('category_id') == $category->id ? 'selected' : ''}}>{{$category->name}}</option>

                                    @endforeach

                            </select>
                        </div>


                            @foreach (config('translatable.locales') as $locale)
                            
                                <div class="form-group">
                                    <label>@lang('site.' .$locale. '.name')</label>
                                    <input type="text" name="{{$locale}}[name]" class="form-control" value="{{old($locale. '.name')}}">
                                </div>

                                <div class="form-group">
                                    <label>@lang('site.' .$locale. '.description')</label>
                                    <textarea type="text" name="{{$locale}}[description]" class="form-control ckeditor" rows="6">
                                        {{old($locale. '.name')}}
                                    </textarea>
                                </div>

                            @endforeach

                            <div class="form-group">
                                <label>@lang('site.purchase_price')</label>
                                <input type="number" name="purchase_price" class="form-control" value="{{old('purchase_price')}}">
                            </div>

                            <div class="form-group">
                                <label>@lang('site.sale_price')</label>
                                <input type="number" name="sale_price" class="form-control" value="{{old('sale_price')}}">
                            </div>

                            <div class="form-group">
                                <label>@lang('site.stock')</label>
                                <input type="number" name="stock" class="form-control" value="{{old('stock')}}">
                            </div>


                            <div class="form-group">
                                <label>@lang('site.photo')</label>
                                <input type="file" name="image" class="form-control image">
                            </div>
    
                            <div class="form-group">
                            <img src="{{asset('images/product_images/product.png')}}" style="width: 100px;" class="thumbnail image-preview"  alt="">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class=" fa fa-plus">@lang('site.add')</i></button>
                            </div>
                    </form>    

            </div><!-- end of box body -->
        </section>
    </div>
@endsection