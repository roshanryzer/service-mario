@if (session()->has('success_msg'))
     <script>
        toastr.success("{{ session('success_msg') }}", 'Success', {
            "showMethod": "slideDown",
            "hideMethod": "slideUp",
            "timeOut": 2000,
            "closeButton": true
        });
    </script>

@endif
@if (session()->has('error_msg'))
    <script>
        toastr.error("{{ session('error_msg') }}", 'Error', {
            "showMethod": "slideDown",
            "hideMethod": "slideUp",
            "timeOut": 2000,
            "closeButton": true
        });
    </script>
@endif
@if (isset($error_msg) && !empty($error_msg))
    <script>
        toastr.error("{{ $error_msg }}", 'Error', {
            "showMethod": "slideDown",
            "hideMethod": "slideUp",
            "timeOut": 2000,
            "closeButton": true
        });
    </script>
@endif
@if (isset($errors) && !empty($errors) && count($errors->all()) > 0)
    @foreach ($errors->all() as $error)
        <script>
            toastr.error("{{ $error }}", 'Error', {
                "showMethod": "slideDown",
                "hideMethod": "slideUp",
                "timeOut": 2000,
                "closeButton": true
            });
        </script>
    @endforeach
@endif
