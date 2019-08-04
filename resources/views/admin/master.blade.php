@extends('common.master')
@section('menu')
  <li class="kt-menu__section ">
    <h4 class="kt-menu__section-text">
      管理面板
    </h4>
    <i class="kt-menu__section-icon flaticon-more-v2"></i>
  </li>
  {!! panel_menu('admin') !!}
  <li class="kt-menu__section ">
    <h4 class="kt-menu__section-text">
      返回
    </h4>
    <i class="kt-menu__section-icon flaticon-more-v2"></i>
  </li>
  <li class="kt-menu__item " aria-haspopup="true">
    <a href="{{url('user')}}" class="kt-menu__link ">
      <i class="kt-menu__link-icon fa fa-user"></i>
      <span class="kt-menu__link-text">
        用户中心
      </span>
    </a>
  </li>
@endsection
