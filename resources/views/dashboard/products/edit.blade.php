@extends('layouts.dashboard.app')

@section('content')


<div class="card card-primary">
    <div class="card-header">
        @lang('site.edit')
    </div>
    @include('includes.errors')
 
    <div class="card-body">

        <form action="{{ route('dashboard.products.update', $product->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put') 
            
            <div class="form-group">
                <label>@lang('site.categories')</label>
                <select name="category_id" class="form-control">
                    <option value="">@lang('site.all_category')</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            

            @foreach (config('translatable.locales') as $locale)
                <div class="form-group">
                    <label>@lang('site.' . $locale . '.name')</label>
                    <input type="text" name="{{ $locale }}[name]" class="form-control" value="{{$product->translate($locale)->name}}">
                </div>

                <div class="form-group">
                    <label>@lang('site.' . $locale . '.description')</label>
                    <textarea name="{{ $locale }}[description]" class="form-control ">{{ $product->translate($locale)->description}}</textarea>
                </div>

            @endforeach

            <div class="form-group">
                <label>@lang('site.image')</label>
                <input type="file" name="image" class="form-control image">
            </div>

           

            <div class="form-group">
                <label>@lang('site.price')</label>
                <input type="number" name="price"  class="form-control" value="{{ $product->price }}">
            </div>

            <div class="form-group">
                <label>@lang('site.sale_price')</label>
                <input type="number" name="sale_price"  class="form-control" value="{{$product->sale_price}}">
            </div>

            <div class="form-group">
                <label>@lang('site.stock')</label>
                <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.edit')</button>
            </div>
        </div>
        
    </div>
</div>

</form>

@endsection