@extends('layouts.dashboard.app')

@section('content')


<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">@lang('site.categories') <small>{{ $categories->total() }}</small></h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">@lang('site.categories') </a></li>
        <li class="breadcrumb-item active"><a href="{{ route('dashboard.index') }}">@lang('site.dashboard')</a></li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->

<div class="card card-primary">
    <div class="card-header with-border">
        {{--  <h3 class="card-title">
            @lang('site.categories')
        </h3>  --}}
    </div>
    <form action="{{ route('dashboard.categories.index') }}" class="my-4" method="get" >
      <div class="input-group">
        <div id="search-autocomplete" class="form-outline">
          <input type="search" id="form1" name="search" class="form-control" value="{{ request()->search }}" style="{{ app()->getLocale() == 'ar' ? 'margin-right: 20px' : 'margin-left: 20px' }}"/>
          
        </div>
        <button type="button" class="btn btn-primary btn-sm">
          @lang('site.search') <i class="fas fa-search"></i> 
        </button>

        @if(auth()->user()->hasPermission('create-categories'))
        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary"  style="margin: 0 10px">@lang('site.add')</a>
          @else 
        <button disabled class="btn btn-primary"  style="margin: 0 10px">@lang('site.add')</button>

        @endif
      </div>
    </form>
   
    <div class="card-body">
          <table class="table table-bordered algin-items-center">
              <thead>
                  <th> # </th>
                <th>@lang('site.name')</th>
                <th>@lang('site.product_count')</th>
                <th>@lang('site.action')</th>
              </thead>
              <tbody>
                @forelse($categories as $index=>$category)
          
                      <tr>
                          <td>{{ $index + 1 }}</td>
                          <td>{{ $category->name }}</td>
                          <td>{{ $category->products->count() }}</td>
                          <td>
                            @if(auth()->user()->hasPermission('update-categories'))
                            <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="btn btn-info btn-sm">@lang('site.edit')</a>
                              @else 
                               <button disabled class="bnt btn-sm btn-info">@lang('site.edit')</button>

                            @endif
                              @if(auth()->user()->hasPermission('delete-categories'))

                              
                                    <button onclick="deleteUser({{ $category->id }})" class="btn btn-danger btn-sm">@lang('site.delete')</button>
                            
                                
                              @else 
                                <button disabled class="btn btn-danger btn-sm"> Delete</button>  
                                
                              @endif
                          </td>
                      </tr>
                    
                  @empty
                  <tr>
                    <td class="text-center">
                      
                  <div class="text-center text-danger my-4">
                    <strong>   @lang('site.data_not_fount')</strong>
                 </div>
                    </td>
                  </tr>
                  
                  @endforelse
              </tbody>
          </table>
          
          
    </div>
    {{ $categories->appends(request()->query())->links() }}
</div>




<!-- Modal -->
<form  method="post" id="formDelete">
    @csrf
    @method('Delete')
<div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">@lang('site.categories')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <strong> @lang('site.are_you_suer') </strong>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('site.colse')</button>
        <button type="submit" class="btn btn-danger">@lang('site.yes')</button>
      </div>
    </form>
    </div>
  </div>
</div>


@endsection

@section('scripts')

<script>

   function deleteUser(id)
   {
    var form = document.getElementById('formDelete')
    form.action = '/dashboard/categories/' + id
    $('#DeleteModal').modal('show')
    console.log(form)
   }

</script>

@stop
