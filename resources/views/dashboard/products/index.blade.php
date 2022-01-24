@extends('layouts.dashboard.app')

@section('content')


<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">@lang('site.products') <small>{{ $products->total() }}</small></h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      {{--  <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.products.index') }}">@lang('site.products') </a></li>
        <li class="breadcrumb-item active"><a href="{{ route('dashboard.index') }}">@lang('site.dashboard')</a></li>
      </ol>  --}}
    </div><!-- /.col -->
  </div><!-- /.row -->

<div class="card card-primary">
    <div class="card-header with-border">
        {{--  <h3 class="card-title">
            @lang('site.products')
        </h3>  --}}
    </div>
    <form action="{{ route('dashboard.products.index') }}" class="my-4" method="get" >
      <div class="input-group">
        <div id="search-autocomplete" class="form-outline">
          <input type="search" id="form1" name="search" class="form-control" value="{{ request()->search }}" style="{{ app()->getLocale() == 'ar' ? 'margin-right: 20px' : 'margin-left: 20px' }}"/>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">
          @lang('site.search') <i class="fas fa-search"></i> 
        </button>
        <select name="category_id" style="margin: 0 10px; outline:none;" >
          <option value="">@lang('site.all_category')</option>
          @foreach($categories as $category)
           <option value="{{ $category->id }}">{{ $category->name }}</option>
            
          @endforeach
      </select>

        @if(auth()->user()->hasPermission('create-products'))
        <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary"  style="margin: 0 10px">@lang('site.add')</a>
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
                <th>@lang('site.description')</th>
                <th>@lang('site.price')</th>
                <th>@lang('site.sale_price')</th>
                <th>@lang('site.stock')</th>
                <th>@lang('site.image')</th>
                <th>@lang('site.win_per') %</th>
                <th>@lang('site.action')</th>
              </thead>
              <tbody>
                @forelse($products as $index=>$product)
          
                      <tr>
                          <td>{{ $index + 1 }}</td>
                          <td>{{ $product->name }}</td>
                          <td>{{ $product->description }}</td>
                          <td>{{ $product->price }}</td>
                          <td>{{ $product->sale_price }}</td>
                          <td>{{ $product->stock }}</td>
                          <td><img src="{{ asset("storage/$product->image") }}" height="100" alt=""></td>
                          <td>{{ $product->win }} %</td>
                          <td>
                            @if(auth()->user()->hasPermission('update-products'))
                            <a href="{{ route('dashboard.products.edit', $product->id) }}" class="btn btn-info btn-sm">@lang('site.edit')</a>
                              @else 
                               <button disabled class="bnt btn-sm btn-info">@lang('site.edit')</button>

                            @endif
                              @if(auth()->user()->hasPermission('delete-products'))

                              
                                    <button onclick="deleteproduct({{ $product->id }})" class="btn btn-danger btn-sm">@lang('site.delete')</button>
                            
                                
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
    {{ $products->appends(request()->query())->links() }}
</div>




<!-- Modal -->
<form  method="post" id="formDelete">
    @csrf
    @method('Delete')
<div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">@lang('site.products')</h5>
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

   function deleteproduct(id)
   {
    var form = document.getElementById('formDelete')
    form.action = '/dashboard/products/' + id
    $('#DeleteModal').modal('show')
    console.log(form)
   }
</script>

@stop
