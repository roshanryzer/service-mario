@extends('admin.layouts.fullLayoutMaster')
@section('title', 'Reset Password')
@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('admin/css/pages/authentication.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('admin/css/plugins/forms/validation/form-validation.css')) }}">
@endsection
@section('content')
    <section class="row flexbox-container">
        <div class="col-xl-7 col-10 d-flex justify-content-center">
            <div class="card bg-authentication rounded-0 mb-0 w-100">
                <div class="row m-0">
                    <div class="col-lg-6 d-lg-block d-none text-center align-self-center p-0">
                        <img src="{{ asset('admin/images/pages/reset-password.png') }}" alt="branding logo">
                    </div>
                    <div class="col-lg-6 col-12 p-0">
                        <div class="card rounded-0 mb-0 px-2">
                            <div class="card-header pb-1">
                                <div class="card-title">
                                    <h4 class="mb-0">Reset Password</h4>
                                </div>
                            </div>
                            <p class="px-2">Please enter your new password.</p>
                            <div class="card-content">
                                <div class="card-body pt-1">
                                    <form id="resetPasswordForm">
                                        <fieldset class="form-label-group form-group position-relative has-icon-left">
                                            <input type="email" class="form-control" id="email" name="email" required
                                                   @isset($email) value="{{ $email }}" @endisset placeholder="Email">
                                            <div class="form-control-position">
                                                <i class="feather icon-at-sign"></i>
                                            </div>
                                            <label for="email">email</label>
                                        </fieldset>

                                        <fieldset class="form-label-group position-relative has-icon-left">
                                            <input type="password" class="form-control" id="password"
                                                   name="password" placeholder="Password" required>
                                            <div class="form-control-position">
                                                <i class="feather icon-lock"></i>
                                            </div>
                                            <label for="password">Password</label>
                                        </fieldset>

                                        <fieldset class="form-label-group position-relative has-icon-left">
                                            <input type="password" class="form-control" id="password_confirmation"
                                                   name="password_confirmation" placeholder="Confirm Password" required>
                                            <div class="form-control-position">
                                                <i class="feather icon-lock"></i>
                                            </div>
                                            <label for="password_confirmation">Confirm Password</label>
                                        </fieldset>
                                        <div class="row pt-2">
                                            <div class="col-12 col-md-6 mb-1">
                                                <a href="{{ route('login') }}"
                                                   class="btn btn-outline-primary btn-block px-0">Go Back to Login</a>
                                            </div>
                                            <div class="col-12 col-md-6 mb-1">
                                                <button type="submit" class="btn btn-primary btn-block px-0">Reset
                                                </button>
                                            </div>
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
        $(document).on('submit', '#resetPasswordForm', function (e) {
            e.preventDefault();
            let resetRoute = "{{ route('password-reset.post', ':id') }}";
            resetRoute = resetRoute.replace(':id', `{{ $code }}`);

            let form = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: resetRoute,
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

