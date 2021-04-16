<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>{{config('constants.site_title', 'Service Marios')}} - @yield('title') - Admin Dashboard</title>

<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="{{ config('constants.site_icon') }}" type="image/x-icon">

<link href="{{asset('css/app.css')}}" rel="stylesheet">
<link href="{{asset('css/adminpanel.css')}}" rel="stylesheet">
<link href="{{asset('css/aside.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('dist/switchery.min.css')}}"/>

<link rel="stylesheet" href="{{asset('admin/css/colors.css')}}"/>
<link rel="stylesheet" href="{{asset('admin/css/components.css')}}"/>
<link rel="stylesheet" href="{{asset('admin/css/themes/dark-layout.css')}}"/>
<link rel="stylesheet" href="{{asset('admin/css/themes/dark-layout.css')}}"/>


@yield('styles')

</head>
<body class="has-navbar-fixed-top ">
@include('admin.include.header')
<div class="columns is-variable is-0">

@include('admin.include.nav')

<div class="column is-10-desktop is-offset-2-desktop is-9-tablet is-offset-3-tablet is-12-mobile">
<div id="app" class="p-1">
<div class="columns is-variable is-desktop">
<div class="column">
<h1 class="title">
@yield('title')
</h1>
</div>
<div class="column">
@include('common.notify')
</div>
<div class="column is-1">
@if (Request::segment(2) != 'dashboard')
<a href="{{ URL::previous() }}"
class="button is-default is-hidden-mobile	is-pulled-right	">@lang('admin.back')</a>
@endif
</div>
</div>
@yield('content')
@include('admin.include.footer')
</div>
</div>
</div>
<script src="{{ asset('admin/js/core/app-menu.js') }}"></script>
<script src="{{ asset('admin/js/core/app.js') }}"></script>
<script src="{{ asset('admin/js/scripts/components.js') }}"></script>

<script src="{{ asset('js/app.js')}}"></script>
<script src="{{ asset('js/admin.js')}}"></script>
<script src="{{ asset('dist/switchery.min.js')}}"></script>
<script>
function closeAlert(event) {
let element = event.target;
while (element.nodeName !== "BUTTON") {
 element = element.parentNode;
}
 element.parentNode.parentNode.removeChild(element.parentNode);
}
</script>
@yield('scripts')
</body>
</html>