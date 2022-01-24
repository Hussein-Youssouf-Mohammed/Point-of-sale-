@extends('layouts.dashboard.app')

@section('content')


<div class="card card-primary">
    <div class="card-header">
        @lang('site.add')
    </div>
    @include('includes.errors')
 
    <div class="card-body">

        <form action="{{ route('dashboard.categories.store') }}" method="post">
            @csrf
            @method('post') 
            
            @foreach(config('translatable.locales') as $locale)        
                <div class="form-group">
                    <label>@lang('site.' . $locale . '.name')</label>
                    <input type="text" name="{{ $locale }}[name]"  class="form-control">
                </div>
            @endforeach

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">@lang('site.add')</button>
                </div>
        </div>
        
    </div>
</div>

</form>

@endsection