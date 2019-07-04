<!--begin: User Bar -->
<div class="kt-header__topbar-item kt-header__topbar-item--user">
  <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px, 0px">
    <div class="kt-header__topbar-user">
      <span class="kt-header__topbar-welcome kt-hidden-mobile">Hi,</span> <span
        class="kt-header__topbar-username kt-hidden-mobile">Sean</span>
      <img alt="Pic" src="{{assets('media/users/300_25.jpg')}}"/>
      <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
      <span class="kt-badge kt-badge--username kt-badge--lg kt-badge--brand kt-hidden kt-badge--bold">S</span>
    </div>
  </div>
  <div
    class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-sm">
    <!--[html-partial:include:{"file":"partials\/_dropdown-user-solid.html"}]/-->
    @include('common.keen.partials._dropdown-user-solid')
  </div>
</div>
<!--end: User Bar -->
