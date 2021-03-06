<!DOCTYPE html>
<!-- Theme: Keen - The Ultimate Bootstrap Admin ThemeAuthor: KeenThemesWebsite: http://wwwthemes.com/Contact: support@keenthemes.comFollow: www.twitter.com/keenthemesDribbble: www.dribbble.com/keenthemesLike: www.facebook.com/keenthemesLicense: You must have a valid license purchased only from https://themes.getbootstrap.com/product/keen-the-ultimate-bootstrap-admin-theme/ in order to legally use the theme for your project.-->
<html lang="en">
<!-- begin::Head -->
<head>
  <meta charset="utf-8"/>
  <title>{{ $title }} - {{ option_localized('site_name') }}</title>
  <meta name="description" content="Latest updates and statistic charts">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!--begin::Fonts -->
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
  <script>
    WebFont.load({
      google: {
        "families": [
          "Poppins:300,400,500,600,700"]
      },
      active: function () {
        sessionStorage.fonts = true;
      }
    });
  </script>
  <!--end::Fonts -->
  @include('common.dependencies.style')
  <link rel="shortcut icon" href="{{assets('images/logos/favicon.ico')}}"/>
</head>

@php
  $user = Auth::user();
@endphp

<!-- end::Head -->
<!-- begin::Body -->
<body
  class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
@include('common.partials._layout-page-loader')
@include('common._layout')
@include('common.dependencies.script')
</body>
<!-- end::Body -->
</html>
