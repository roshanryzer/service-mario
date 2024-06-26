@extends('theme-temp.layouts.base')

@section ('page')

    @include('theme-temp.layouts.partials.svg-icon')

    <div class="page-wrapper">
        @include('theme-temp.layouts.partials.top-header')
        <div class="clearfix"></div>
        <!-- Page container -->
        <div class="page-container col-md-12">

            <!-- Sidebar -->
            <div class="page-sidebar-wrapper">
                <div class="page-sidebar navbar-collapse">
                    <div class="sidebar">
                        <div class="sidebar-content">
                            <ul class="page-sidebar-menu page-header-fixed navigation" data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200">
                                @include('theme-temp.layouts.partials.sidebar')
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /sidebar -->

            <div class="page-content-wrapper">
                <div class="page-content @if (Route::currentRouteName() == 'media.index') rv-media-integrate-wrapper @endif">
                    {!! AdminBreadcrumb::render() !!}
                    <div class="clearfix"></div>
                    @yield('content')
                    @include('admin.layouts.base.table.modal')
                    @include('theme-temp.layouts.partials.footer')
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- /page container -->
    </div>
@stop

@section('javascript')
    @include('media::partials.media')
@endsection

@push('footer')
    @routes
@endpush

