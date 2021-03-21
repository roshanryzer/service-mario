<script type="text/javascript">
    var RoshanVariables = RoshanVariables || {};

    @if (Auth::check())
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

@push('footer')
    @if (session()->has('success_msg') || session()->has('error_msg') || (isset($errors) && $errors->count() > 0) || isset($error_msg))
        <script type="text/javascript">
            $(document).ready(function () {
                @if (session()->has('success_msg'))
                Roshan.showNotice('success', '{{ session('success_msg') }}');
                @endif
                @if (session()->has('error_msg'))
                Roshan.showNotice('error', '{{ session('error_msg') }}');
                @endif
                @if (isset($error_msg))
                Roshan.showNotice('error', '{{ $error_msg }}');
                @endif
                @if (isset($errors))
                @foreach ($errors->all() as $error)
                Roshan.showNotice('error', '{{ $error }}');
                @endforeach
                @endif
            });
        </script>
    @endif
@endpush
