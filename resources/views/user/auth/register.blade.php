@extends('user.layout.auth')

@section('content')

<section class="hero is-info is-fullheight">
    <div class="log-overlay"></div>
    <div class="full-page-bg-inner">
        <div class="columns no-margin">
            <div class="col-md-6 log-left">
                <span class="login-logo"><img src="{{ Setting::get('site_logo',asset('asset/img/logo.png'))}}"></span>
                <h2>Create your account and get moving in minutes</h2>
                <p>Welcome to {{Setting::get('site_title','Service Mario')}}, the easiest way to get around at the tap of a
                    button.</p>
            </div>
            <div class="col-md-6 log-right">
                <div class="login-box-outer">
                    <div class="login-box row no-margin">
                        <div class="col-md-12">
                            <a class="log-blk-btn" href="{{url('login')}}">ALREADY HAVE AN ACCOUNT?</a>
                            <h3>Create a New Account</h3>
                        </div>
                        <form role="form" method="POST" action="{{ url('/register') }}">

                            <!--                            <div id="first_step">
                                <div class="col-md-4">
                                    <input value="+55" type="text" placehold="+1" id="country_code" name="country_code" />
                                </div> 

                                <div class="col-md-8">
                                    <input type="text" autofocus id="phone_number" class="form-control" placehold="Número celular com DDD" name="phone_number" value="{{ old('phone_number') }}" data-stripe="number" maxlength="11" onkeypress="return isNumberKey(event);" required/>
                                </div>

                                <div class="col-md-8">
                                    @if ($errors->has('phone_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-md-12" style="padding-bottom: 10px;" id="mobile_verfication"></div>
                                <div class="col-md-12" style="padding-bottom: 10px;">
                                    <input type="button" class="log-teal-btn small verify_btn" onclick="smsLogin();" value="VERIFICAR NÚMERO"/>
                                </div>

                            </div>-->

                            {{ csrf_field() }}

                            <div id="second_step">
                                <input value="+91" type="hidden" id="country_code" name="country_code" />

                                <div class="col-md-6">
                                    <label for="name">Name</label>
                                    <input type="text" autofocus class="form-control" placehold="Name" name="first_name"
                                        value="{{ old('first_name') }}" data-validation="alphanumeric"
                                        data-validation-allowing=" -"
                                        data-validation-error-msg="First Name can only contain alphanumeric characters and . - spaces">

                                    @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="name">Last name</label>
                                    <input type="text" class="form-control" placehold="Second name" name="last_name"
                                        value="{{ old('last_name') }}" data-validation="alphanumeric"
                                        data-validation-allowing=" -"
                                        data-validation-error-msg="Last Name can only contain alphanumeric characters and . - spaces">

                                    @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-12">
                                    <label for="name">Email</label>
                                    <input type="email" class="form-control" name="email" placehold="E-mail"
                                        value="{{ old('email') }}" data-validation="email">

                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-md-12">
                                    <label for="name">Phone no</label>
                                    <input type="text" id="phone_number" class="form_tel" class="form-control"
                                        placehold="Número celular com DDD" name="phone_number"
                                        value="{{ old('phone_number') }}" data-stripe="number" maxlength="11"
                                        onkeypress="return isNumberKey(event);" required />
                                </div>

                                <div class="col-md-12">
                                    
                                    <div class="col-md-6">
                                    <label class="checkbox"><input type="radio" name="gender" value="MALE"
                                            data-validation="required"
                                            data-validation-error-msg="Please select a gender"> Male</label>
                                </div>
                                <div class="col-md-6">
                                    <label class="checkbox"><input type="radio" name="gender" value="FEMALE"
                                        data-validation-error-msg="Please select a gender"> Female</label>
                                </div>
                                    
                                    @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-md-12">
                                    <label for="name">password</label>
                                    <input type="password" class="form-control" name="password" data-validation="length"
                                        data-validation-length="min6"
                                        data-validation-error-msg="Password should not be less than 6 characters">

                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-md-12">
                                    <label for="name">Confirm password</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        data-validation="confirmation" data-validation-confirm="password"
                                        data-validation-error-msg="Passwords do not match">

                                    @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @if(config('constants.referral') == 1)
                                <div class="col-md-12">
                                    <label for="name">Referal code (optional)</label>
                                    <input type="text" placehold="Reference Code (Optional)" class="form-control"
                                        name="referral_code">

                                    @if ($errors->has('referral_code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('referral_code') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                @else
                                <input type="hidden" name="referral_code">
                                @endif

                                <div class="col-md-12">
                                    <button class="log-teal-btn" type="submit">REGISTER</button>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-12">
                            <p class="helper">Or <a href="{{route('login')}}">Sign in</a> with your user account.</p>
                        </div>

                    </div>

                    <div class="log-copy">
                        <p class="no-margin">&copy;{{date('Y')}} {{Setting::get('site_title','Service Mario')}}</p>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection

@section('scripts')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script src="{{ asset('asset/js/jmask.js') }}"></script>
<script type="text/javascript">
    $('.form_tel').mask('(99)99999-9999');

    @if(count($errors) > 0)
    $("#second_step").show();
    @endif
    $.validate({
        modules: 'security',
    });
    $('.checkbox-inline').on('change', function () {
        $('.checkbox-inline').not(this).prop('checked', false);
    });

    function isNumberKey(evt) {
        var edValue = document.getElementById("phone_number");
        var s = edValue.value;
        if (event.keyCode == 13) {
            event.preventDefault();
            if (s.length >= 10) {
                smsLogin();
            }
        }
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>


@endsection