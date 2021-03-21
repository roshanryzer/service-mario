<body
    class="horizontal-layout horizontal-menu {{$configData['horizontalMenuType']}} {{ $configData['blankPageClass'] }} {{ $configData['bodyClass'] }}  {{($configData['theme'] === 'dark') ? 'dark-layout' : 'light' }} {{ $configData['footerType'] }}  footer-light"
    data-menu="horizontal-menu" data-col="2-columns" data-open="hover" data-layout="{{ $configData['theme'] }}">

{{-- Include Sidebar --}}
@include('admin.panels.sidebar')

<!-- BEGIN: Header-->
{{-- Include Navbar --}}
@include('admin.panels.navbar')

{{-- Include Sidebar --}}
@include('admin.panels.horizontalMenu')

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    @if(($configData['contentLayout']!=='default') && isset($configData['contentLayout']))
        <div class="content-area-wrapper">
            <div class="{{ $configData['sidebarPositionClass'] }}">
                <div class="sidebar">
                    @yield('content-sidebar')
                </div>
            </div>
            <div class="{{ $configData['contentsidebarClass'] }}">
                <div class="content-wrapper">
                    <div class="content-body">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="content-wrapper">
            @if($configData['pageHeader'] == true)
                @include('admin.panels.breadcrumb')
            @endif

            <div class="content-body">
                @yield('content')
            </div>
        </div>
    @endif

</div>
<!-- End: Content-->

@if($configData['blankPage'] == false && isset($configData['blankPage']))
    @include('admin.pages.customizer')
@endif

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

@include('admin.panels.footer')

@include('admin.panels.scripts')

@include('admin.panels.notifications')

</body>

</html>
