@extends('layouts.dashboard.app')

@section('content')


<div class="card card-primary">
    <div class="card-header">
        @lang('site.edit') :  {{ $category->name }}
    </div>
    @include('includes.errors')
 
    <div class="card-body">

        <form action="{{ route('dashboard.categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put') 
            
            @foreach(config('translatable.locales') as $locale)        
            <div class="form-group">
                <label>@lang('site.' . $locale . '.name')</label>
                <input type="text" name="{{ $locale }}[name]" value="{{ $category->translate($locale)->name}}"  class="form-control">
            </div>
        @endforeach
                    
        
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">@lang('site.edit')</button>
                </div>
        </div>
        
    </div>
</div>

</form>

@endsection