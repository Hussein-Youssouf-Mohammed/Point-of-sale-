  @extends('layouts.dashboard.app')

@section('content')

<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">@lang('site.users')</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.users.index') }}">@lang('site.users')</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('dashboard.index') }}">@lang('site.dashboard')</a></li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
@include('includes.aside')


@endsection