@extends('admin.layouts.fullLayoutMaster')
@section('title', 'Login Page')
@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('admin/css/pages/authentication.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('admin/css/plugins/forms/validation/form-validation.css')) }}">
@endsection
@section('content')
    <section class="row flexbox-container">
        <div class="col-xl-8 col-11 d-flex justify-content-center">
            <div class="card bg-authentication rounded-0 mb-0">
                <div class="row m-0">
                    <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                        <img src="{{ asset('admin/images/pages/login.png') }}" alt="branding logo">
                    </div>
                    <div class="col-lg-6 col-12 p-0">
                        <div class="card rounded-0 mb-0 px-2">
                            <div class="card-header pb-1">
                                <div class="card-title">
                                    <h4 class="mb-0">Login</h4>
                                </div>
                            </div>
                            <p class="px-2">Welcome back, please login to your account.</p>
                            <div class="card-content">
                                <div class="card-body pt-1">
                                    <form method="post" enctype="multipart/form-data" id="loginForm">
                                        <fieldset class="form-label-group form-group position-relative has-icon-left">
                                            <input type="email" class="form-control" id="user_email" name="user_email"
                                                   placeholder="Email" required>
                                            <div class="form-control-position">
                                                <i class="feather icon-at-sign"></i>
                                            </div>
                                            <label for="user_email">email</label>
                                        </fieldset>

                                        <fieldset class="form-label-group position-relative has-icon-left">
                                            <input type="password" class="form-control" id="user_password"
                                                   name="user_password" placeholder="Password" required>
                                            <div class="form-control-position">
                                                <i class="feather icon-lock"></i>
                                            </div>
                                            <label for="user_password">Password</label>
                                        </fieldset>
                                        <div class="form-group d-flex justify-content-between align-items-center">
                                            <div class="text-left">
                                                <fieldset class="checkbox">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" name="remember_me">
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                              <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">Remember me</span>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="text-right">
                                                <a href="{{ route('forgot-password') }}" class="card-link">Forgot
                                                    Password?</a></div>
                                        </div>
                                        <a href="{{ route('register') }}"
                                           class="btn btn-outline-primary float-left btn-inline">Register</a>
                                        <button type="submit" class="btn btn-primary float-right btn-inline">Login
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="login-footer">
                                <div class="divider">
                                    {{-- <div class="divider-text">OR</div>--}}
                                </div>
                                <div class="footer-btn d-inline">
                                    {{-- <a href="#" class="btn btn-facebook"><span class="fa fa-facebook"></span></a>--}}
                                    {{-- <a href="#" class="btn btn-twitter white"><span class="fa fa-twitter"></span></a>--}}
                                    {{-- <a href="#" class="btn btn-google"><span class="fa fa-google"></span></a>--}}
                                    {{-- <a href="#" class="btn btn-github"><span class="fa fa-github-alt"></span></a>--}}
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
        $(document).on('submit', '#loginForm', function (e) {
            e.preventDefault();
            let form = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('login.post') }}",
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

