@extends('admin.master', ['title' => '系统设置'])
@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--begin::Portlet-->
    {!! $forms['general']->render() !!}
    <!--end::Portlet-->
    </div>
  </div>
@endsection
@section('script')

@endsection
