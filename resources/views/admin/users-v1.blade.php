@extends('admin.master', ['title' => '用户管理v1'])
@section('content')
  <div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
          用户管理v1
        </h3>
      </div>
      <div class="kt-portlet__head-toolbar">
        <div class="kt-portlet__head-wrapper">
          <a href="#" class="btn btn-clean kt-hidden">
            Back to dashboard
          </a>
          <a href="#" class="btn btn-clean btn-bold btn-upper btn-font-sm kt-hidden">
            <i class="la la-long-arrow-left"></i>
            Back
          </a>
          <a href="#" class="btn btn-default btn-bold btn-upper btn-font-sm">
            <i class="flaticon2-add-1"></i>
            New Record
          </a>
          &nbsp;
          <div class="dropdown dropdown-inline">
            <button type="button" class="btn btn-default btn-bold btn-upper btn-font-sm" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
              <i class="flaticon2-soft-icons"></i> Actions
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <ul class="kt-nav">
                <li class="kt-nav__section kt-nav__section--first">
                  <span class="kt-nav__section-text">Quick Actions</span>
                </li>
                <li class="kt-nav__item">
                  <a href="#" class="kt-nav__link">
                    <i class="kt-nav__link-icon flaticon2-graph-1"></i>
                    <span class="kt-nav__link-text">Statistics</span>
                  </a>
                </li>
                <li class="kt-nav__item">
                  <a href="#" class="kt-nav__link">
                    <i class="kt-nav__link-icon flaticon2-calendar-4"></i>
                    <span class="kt-nav__link-text">Events</span>
                  </a>
                </li>
                <li class="kt-nav__item">
                  <a href="#" class="kt-nav__link">
                    <i class="kt-nav__link-icon flaticon2-layers-1"></i>
                    <span class="kt-nav__link-text">Reports</span>
                  </a>
                </li>
                <li class="kt-nav__item">
                  <a href="#" class="kt-nav__link">
                    <i class="kt-nav__link-icon flaticon2-graph"></i>
                    <span class="kt-nav__link-text">Notifications</span>
                  </a>
                </li>
                <li class="kt-nav__item">
                  <a href="#" class="kt-nav__link">
                    <i class="kt-nav__link-icon flaticon2-file-1"></i>
                    <span class="kt-nav__link-text">Files</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
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
                  <input type="text" class="form-control" placeholder="Search..." id="generalSearch">
                  <span class="kt-input-icon__icon kt-input-icon__icon--left">
																<span><i class="la la-search"></i></span>
															</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 order-1 order-xl-2 kt-align-right">
            <a href="#" class="btn btn-default kt-hidden">
              <i class="la la-cart-plus"></i> New Order
            </a>
            <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg d-xl-none"></div>
          </div>
        </div>
      </div>

      <!--end: Search Form -->
    </div>
    <div class="kt-portlet__body kt-portlet__body--fit">

      <!--begin: Datatable -->
      <div class="kt_datatable" id="ajax_data"></div>

      <!--end: Datatable -->
    </div>
  </div>
@endsection
@section('script')
  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  </script>
  <script src="{{assets('js/admin/users-v1.js')}}" type="text/javascript"></script>
@endsection
