@include('common.keen.partials._header-mobile')
<!-- begin:: Root -->
<div class="kt-grid kt-grid--hor kt-grid--root">
    <!-- begin:: Page -->
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
    @include('common.keen.partials._aside')
        <!-- begin:: Wrapper -->
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
          @include('common.keen.partials._header')
            <div class="kt-content kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
              @include('common.keen.partials._subheader')
              @include('common.keen.partials._content')
            </div>
          @include('common.keen.partials._footer')
        </div>
        <!-- end:: Wrapper -->
    </div>
    <!-- end:: Page -->
</div>
<!-- end:: Root -->
@include('common.keen.partials._layout-scrolltop')
