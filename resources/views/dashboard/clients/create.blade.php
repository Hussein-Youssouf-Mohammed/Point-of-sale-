@extends('layouts.dashboard.app')

@section('content')


<div class="card card-primary">
    <div class="card-header">
        @lang('site.add')
    </div>
    @include('includes.errors')
 
    <div class="card-body">

        <form action="{{ route('dashboard.clients.store') }}" method="post">
            @csrf
            @method('post') 

               <div class="form-group">
                    <label>@lang('site.name')</label>
                   <input type="text" name="name"  class="form-control">
               </div>

               @for($i = 0; $i < 2; $i++)
                    <div class="form-group">
                        <label>@lang('site.phone')</label>
                        <input type="text" name="phone[]"  class="form-control">
                    </div>
               @endfor

               <div class="form-group">
                  <label>@lang('site.address')</label>
                 <textarea rows="5" name="address"  class="form-control"></textarea>
               </div> 


                <div class="form-group">
                    <button type="submit" class="btn btn-primary">@lang('site.add')</button>
                </div>
        </div>
        
    </div>
</div>

</form>

@endsection