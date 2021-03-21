<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600">
{!! Assets::renderHeader() !!}
@yield('vendor-style')

@php
$configData = Helper::applClasses();
@endphp

{{-- Page Styles --}}
@if($configData['mainLayoutType'] === 'horizontal')
<link rel="stylesheet" href="{{ asset(mix('admin/css/core/menu/menu-types/horizontal-menu.css')) }}">
@endif
<link rel="stylesheet" href="{{ asset(mix('admin/css/core/menu/menu-types/vertical-menu.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('admin/css/core/colors/palette-gradient.css')) }}">

@yield('page-style')

<link rel="stylesheet" href="{{ asset(mix('admin/css/custom-laravel.css')) }}">

@if($configData['direction'] === 'rtl' && isset($configData['direction']))
<link rel="stylesheet" href="{{ asset(mix('admin/css/custom-rtl.css')) }}">
@endif
