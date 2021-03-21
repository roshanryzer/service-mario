@extends('admin.layouts.fullLayoutMaster')

@section('title', 'Register User')

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('admin/css/pages/authentication.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('admin/css/plugins/forms/validation/form-validation.css')) }}">
@endsection
@section('content')
    <section class="row flexbox-container">
        <div class="col-xl-8 col-10 d-flex justify-content-center">
            <div class="card bg-authentication rounded-0 mb-0">
                <div class="row m-0">
                    <div class="col-lg-5 d-lg-block d-none text-center align-self-center pl-0 pr-3 py-0">
                        <img src="{{ asset('admin/images/pages/register.jpg') }}" alt="branding logo">
                    </div>
                    <div class="col-lg-7 col-12 p-0">
                        <div class="card rounded-0 mb-0 p-2">
                            <div class="card-header pt-50 pb-1">
                                <div class="card-title">
                                    <h4 class="mb-0">Create Account</h4>
                                </div>
                            </div>
                            <p class="px-2">Fill the below form to create a new account.</p>
                            <div class="card-content">
                                <div class="card-body pt-0">
                                    <form method="post" id="registrationForm" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-label-group">
                                                    <input type="text" id="first_name" name="first_name"
                                                           class="form-control" placeholder="First Name" required>
                                                    <label for="first_name">First Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-label-group">
                                                    <input type="text" id="last_name" name="last_name"
                                                           class="form-control" placeholder="Last Name" required>
                                                    <label for="last_name">Last Name</label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-label-group">
                                            <input type="email" id="email" name="email" class="form-control"
                                                   placeholder="Email" required>
                                            <label for="email">Email</label>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-label-group">
                                                    <input type="password" id="password" name="password"
                                                           class="form-control" placeholder="Password" required>
                                                    <label for="password">Password</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-label-group">
                                                    <input type="password" id="password_confirmation"
                                                           name="password_confirmation" class="form-control"
                                                           placeholder="Confirm Password" required
                                                           data-validation-match-match="password">
                                                    <label for="password_confirmation">Confirm Password</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-label-group">
                                                    <input type="text" id="mobile" name="mobile"
                                                           class="form-control" placeholder="Mobile" required>
                                                    <label for="mobile">Mobile</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-label-group">
                                                    <input type="text" id="address" name="address"
                                                           class="form-control" placeholder="Address" required>
                                                    <label for="address">Address</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-12">
                                                <fieldset class="checkbox">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" name="terms_and_conditions"
                                                               value="Accepted">
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                              <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class=""> I accept the terms & conditions.</span>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <a href="{{ route('login') }}"
                                           class="btn btn-outline-primary float-left btn-inline mb-50">Login</a>
                                        <button type="submit" class="btn btn-primary float-right btn-inline mb-50">
                                            Register
                                        </button>
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
    {{--    <script src="{{ asset(mix('admin/vendors/js/forms/validation/jqBootstrapValidation.js')) }}"></script>--}}
@endsection

@section('page-script')
    <script src="{{ asset(mix('admin/js/scripts/auth/auth.js')) }}"></script>
    <script>
        $(document).on('submit', '#registrationForm', function (e) {
            e.preventDefault();
            let form = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('register.post') }}",
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
                    // window.location = response.route;
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
                        console.log(response);
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
