<!-- BEGIN: Footer-->
@if($configData["mainLayoutType"] == 'horizontal' && isset($configData["mainLayoutType"]))
    <footer
        class="footer {{ $configData['footerType'] }} {{($configData['footerType']=== 'footer-hidden') ? 'd-none':''}} footer-light navbar-shadow">
        @else
            <footer
                class="footer {{ $configData['footerType'] }} {{($configData['footerType']=== 'footer-hidden') ? 'd-none':''}} footer-light">
                @endif
                <p class="clearfix blue-grey lighten-2 mb-0"><span
                        class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; {{ Date('Y') }}<a
                            class="text-bold-800 grey darken-2" href="#"
                            target="_blank">Service Mario,</a>All rights Reserved</span><span
                        class="float-md-right d-none d-md-block">Hand-crafted with<i
                            class="feather icon-heart pink"></i></span>
                    <button class="btn btn-primary btn-icon scroll-top" type="button"><i
                            class="feather icon-arrow-up"></i></button>
                </p>
            </footer>
            <!-- END: Footer-->
            <script type="text/javascript">
                var RoshanVariables = RoshanVariables || {};

                @if (Sentinel::check())
                    RoshanVariables.languages = {
                    tables: {!! json_encode(trans('tables'), JSON_HEX_APOS) !!},
                    notices_msg: {!! json_encode(trans('notices'), JSON_HEX_APOS) !!},
                    pagination: {!! json_encode(trans('pagination'), JSON_HEX_APOS) !!},
                    system: {
                        'character_remain': '{{ trans('forms.character_remain') }}'
                    }
                };
                @else
                    RoshanVariables.languages = {
                    notices_msg: {!! json_encode(trans('notices'), JSON_HEX_APOS) !!},
                };
                @endif
            </script>
