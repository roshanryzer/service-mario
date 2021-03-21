@extends('admin.layouts.fullLayoutMaster')

@section('title', 'Forgot Password')

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('admin/css/pages/authentication.css')) }}">
@endsection
@section('content')
    <section class="row flexbox-container">
        <div class="col-xl-7 col-md-9 col-10 d-flex justify-content-center px-0">
            <div class="card bg-authentication rounded-0 mb-0">
                <div class="row m-0">
                    <div class="col-lg-6 d-lg-block d-none text-center align-self-center">
                        <img src="{{ asset('admin/images/pages/forgot-password.png') }}" alt="branding logo">
                    </div>
                    <div class="col-lg-6 col-12 p-0">
                        <div class="card rounded-0 mb-0 px-2 py-1">
                            <div class="card-header pb-1">
                                <div class="card-title">
                                    <h4 class="mb-0">Recover your password</h4>
                                </div>
                            </div>
                            <p class="px-2 mb-0">Please enter your email address and we'll send you instructions on how
                                to reset your password.</p>
                            <div class="card-content">
                                <div class="card-body">
                                    <form id="forgotPasswordForm">
{{--                                        <div class="form-label-group">--}}
{{--                                            <input type="email" id="inputEmail" class="form-control"--}}
{{--                                                   placeholder="Email">--}}
{{--                                            <label for="inputEmail">Email</label>--}}
{{--                                        </div>--}}
                                        <fieldset class="form-label-group form-group position-relative has-icon-left">
                                            <input type="email" class="form-control" id="user_email" name="user_email"
                                                   placeholder="Email" required>
                                            <div class="form-control-position">
                                                <i class="feather icon-at-sign"></i>
                                            </div>
                                            <label for="user_email">email</label>
                                        </fieldset>
                                        <div class="float-md-left d-block mb-1">
                                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-block px-75">Back
                                                to Login</a>
                                        </div>
                                        <div class="float-md-right d-block mb-1">
                                            <button type="submit" class="btn btn-primary float-right btn-inline">Recover
                                                Password
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('vendor-script')
    <script src="{{ asset(mix('admin/vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
@endsection
@section('page-script')
    <script src="{{ asset(mix('admin/js/scripts/auth/auth.js')) }}"></script>
    <script>
        $(document).on('submit', '#forgotPasswordForm', function (e) {
            console.log('dada')
            e.preventDefault();
            let form = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('forgot-password.post') }}",
                contentType: false,
                processData: false,
                data: form,
                dataType: 'json',
                beforeSend: function (data) {
                },
                success: function (response) {
                    toastr.success(response.message, response.title, {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        "timeOut": 4000,
                        "closeButton": true
                    });
                    if (response.route) {
                        window.location = response.route;
                    }
                },
                error: function (response) {
                    if (response.status === 422) {
                        $.each(response.responseJSON.errors, function (i, error) {
                            let el = $(document).find('[name="' + i + '"]');
                            el.after($('<small id=' + i + '-error class="help-block" >' + error[0] + '</small>').fadeOut(15000));
                            setTimeout(function () {
                                el.removeClass('is-invalid');
                            }, 8000);
                        });
                    } else {
                        toastr.error(response.responseJSON.message, response.responseJSON.title, {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            "timeOut": 4000,
                            "closeButton": true
                        });
                    }
                }
            });
        });
    </script>
@endsection
