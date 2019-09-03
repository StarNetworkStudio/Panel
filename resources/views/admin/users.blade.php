@extends('admin.master', ['title' => '用户管理'])
@section('content')
  <div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
          用户管理
        </h3>
      </div>
      <div class="kt-portlet__head-toolbar">
        <div class="kt-portlet__head-wrapper">
            <a href="#" class="btn btn-default btn-bold btn-upper btn-font-sm">
              <i class="la la-download"></i>
              导出用户
            </a>
          &nbsp;
          <a href="#" class="btn btn-brand btn-bold btn-upper btn-font-sm">
            <i class="la la-plus"></i>
            添加用户
          </a>
        </div>
      </div>
    </div>
    <div class="kt-portlet__body">

      <!--begin: Search Form -->
      <div class="kt-form kt-fork--label-right kt-margin-t-20 kt-margin-b-10">
        <div class="row align-items-center">
          <div class="col-xl-8 order-2 order-xl-1">
            <div class="row align-items-center">
              <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                <div class="kt-input-icon kt-input-icon--left">
                  <input type="text" class="form-control" placeholder="搜索" id="generalSearch">
                  <span class="kt-input-icon__icon kt-input-icon__icon--left">
                    <span><i class="la la-search"></i></span>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 order-1 order-xl-2 kt-align-right">
            <a href="#" class="btn btn-default kt-hidden">
              <i class="la la-cart-plus"></i>
              New Order
            </a>
            <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg d-xl-none"></div>
          </div>
        </div>
      </div>

      <!--end: Search Form -->
    </div>
    <div class="kt-portlet__body kt-portlet__body--fit">

      <!--begin: Datatable -->
      <div class="kt_datatable" id="json_data"></div>

      <!--end: Datatable -->
    </div>
  </div>
@endsection
@section('script')
  <script src="{{assets('js/admin/users.js')}}" type="text/javascript"></script>
@endsection
