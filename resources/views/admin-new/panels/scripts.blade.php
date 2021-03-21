{!! Assets::renderFooter() !!}

@yield('vendor-script')
<!--<script src="{{ asset(mix('admin/js/core/app-menu.js')) }}"></script>
<script src="{{ asset(mix('admin/js/core/app.js')) }}"></script>
<script src="{{ asset(mix('admin/js/scripts/components.js')) }}"></script>-->
@if($configData['blankPage'] == false)
<!--    <script src="{{ asset(mix('admin/js/scripts/customizer.js')) }}"></script>
    <script src="{{ asset(mix('admin/js/scripts/footer.js')) }}"></script>-->
@endif

@yield('page-script')
