@extends('theme-temp.layouts.base')

@section('body-class') full-width page-condensed @stop

@section('page')

    @include('theme-temp.layouts.partials.top-header')

    @yield('content')

    <!-- Footer -->
    <div class="footer clearfix center-block row">
        <div class="col-xs-12 col-sm-8">{!! trans('layouts.copyright') !!}</div>

        <div class="d-none d-sm-block col-sm-4 text-right">
            <strong>{{ trans('layouts.powered_by') }}</strong>
            <a href="http://www.Roshan.com"><img src="{{ url('/images/logos/logo.png') }}"/></a>
        </div>
    </div>
    <!-- /footer -->
@stop
