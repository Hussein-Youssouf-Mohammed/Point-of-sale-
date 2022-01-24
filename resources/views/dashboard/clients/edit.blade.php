@extends('layouts.dashboard.app')

@section('content')


<div class="card card-primary">
    <div class="card-header">
        @lang('site.edit')
    </div>
    @include('includes.errors')
 
    <div class="card-body">

        <form action="{{ route('dashboard.clients.update', $client->id) }}" method="post">
            @csrf
            @method('put') 

               <div class="form-group">
                    <label>@lang('site.name')</label>
                   <input type="text" name="name" value="{{ $client->name }}" class="form-control">
               </div>

               @for($i = 0; $i < 2; $i++)
                    <div class="form-group">
                        <label>@lang('site.phone')</label>
                        <input type="text" name="phone[]" value="{{ $client->phone[$i] ?? '' }}" class="form-control">
                    </div>
               @endfor

               <div class="form-group">
                  <label>@lang('site.address')</label>
                 <textarea rows="10" name="address"  class="form-control">{{ $client->address }}</textarea>
               </div> 


                <div class="form-group">
                    <button type="submit" class="btn btn-primary">@lang('site.edit')</button>
                </div>
        </div>
        
    </div>
</div>

</form>

@endsection