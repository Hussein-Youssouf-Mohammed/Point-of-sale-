@extends('layouts.dashboard.app')

@section('content')


<div class="card card-primary">
    <div class="card-header">
        @lang('site.edit') :  {{ $user->name }}
    </div>
    @include('includes.errors')
 
    <div class="card-body">

        <form action="{{ route('dashboard.users.update', $user->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put') 
            
                <div class="form-group">
                    <label>@lang('site.name')</label>
                    <input value ="{{ $user->name }} " type="text" name="name"  class="form-control">
                </div>
                <div class="form-group">
                    <label>@lang('site.email')</label>
                    <input value ="{{ $user->email }} " type="email" name="email"  class="form-control">
                </div>
                <div class="form-group">
                    <label>@lang('site.image')</label>
                    <input type="file" name="image"  class="form-control">
                </div>

                <div class="card">
                    <div class="card-header d-flex p-0">
                      <h3 class="card-title p-3">@lang('site.permissions')</h3>
                      
                    </div><!-- /.card-header -->
                    <div class="card-body">

                        @php
                          $models = ['users', 'products', 'categories'];
                          $maps   = ['create', 'read', 'update', 'delete'];
                      @endphp
                      <ul class="nav nav-pills ml-auto p-2">

                        @foreach ($models as $index=>$model)
                        <li class="nav-item"><a class="nav-link {{ $index == 0 ? 'active' : '' }}" href="#{{ $model }}" data-toggle="tab">@lang('site.' .  $model )</a></li>
                            
                        @endforeach
                        
                      </ul>
                      
                      <div class="tab-content">
                          @foreach ($models as $index=>$model )
                          <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="{{ $model }}">
                              @foreach($maps as $map)
                              <label>
                                  <input {{ $user->hasPermission($map . '-' . $model) ? 'checked': '' }} type="checkbox" name="permissions[]" value="{{ $map . '-' . $model }}"> @lang('site.' . $map)
                                </label>
                                @endforeach
                            </div>
                            @endforeach
                            <!-- /.tab-pane -->
                            
                        </div>
                        <!-- /.tab-content -->
                        
                    </div><!-- /.card-body -->
                </div>     
        
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">@lang('site.edit')</button>
                </div>
        </div>
        
    </div>
</div>

</form>

@endsection