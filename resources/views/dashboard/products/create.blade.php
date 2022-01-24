@extends('layouts.dashboard.app')

@section('content')


<div class="card card-primary">
    <div class="card-header">
        @lang('site.add')
    </div>
    @include('includes.errors')
 
    <div class="card-body">

        <form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('post') 
            
            <div class="form-group">
                <label>@lang('site.categories')</label>
                <select name="category_id" class="form-control">
                    <option value="">@lang('site.all_category')</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            

            @foreach (config('translatable.locales') as $locale)
                <div class="form-group">
                    <label>@lang('site.' . $locale . '.name')</label>
                    <input type="text" name="{{ $locale }}[name]" class="form-control" value="{{ old($locale . '.name') }}">
                </div>

                <div class="form-group">
                    <label>@lang('site.' . $locale . '.description')</label>
                    <textarea name="{{ $locale }}[description]" class="form-control ">{{ old($locale . '.description') }}</textarea>
                </div>

            @endforeach

            <div class="form-group">
                <label>@lang('site.image')</label>
                <input type="file" name="image" class="form-control image">
            </div>

           

            <div class="form-group">
                <label>@lang('site.price')</label>
                <input type="number" name="price"  class="form-control" value="{{ old('purchase_price') }}">
            </div>

            <div class="form-group">
                <label>@lang('site.sale_price')</label>
                <input type="number" name="sale_price"  class="form-control" value="{{ old('sale_price') }}">
            </div>

            <div class="form-group">
                <label>@lang('site.stock')</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock') }}">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
            </div>
        </div>
        
    </div>
</div>

</form>

@endsection