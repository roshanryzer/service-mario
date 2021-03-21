class Auth {
    handleLogin() {
        $('#loginForm').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                user_email: {
                    required: true
                },
                user_password: {
                    required: true
                },
                remember: {
                    required: false
                }
            },
            messages: {
                username: {
                    required: 'Username is required.'
                },
                password: {
                    required: 'Password is required.'
                }
            },
            invalidHandler: () => { //display error alert on form submit
                $('.alert-danger', $('#loginForm')).show();
            },
            highlight: (element) => { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            success: (label) => {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },
            errorPlacement: (error, element) => {
                error.insertAfter(element.closest('.form-control'));
            },
            // submitHandler: (form) => {
            //     $('#loginForm').trigger("submit"); // form validation success, call ajax form submit
            // }
        });

        $('#loginForm input').keypress((e) => {
            if (e.which === 13) {
                if ($('#loginForm').validate().form()) {
                    $('#loginForm').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });
    }

    handleRegistration() {
        $('#registrationForm').validate({
            errorElement: 'small', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                first_name: {
                    required: true,
                },
                last_name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                },
                password_confirmation: {
                    required: true,
                    equalTo : "#password"
                },
                mobile: {
                    required: true,
                    digits: true,
                    maxlength: 10,
                    minlength: 10,
                },
                address: {
                    required: true
                },

            },
            messages: {
                first_name: {
                    required: 'First Name is required.'
                },
                last_name: {
                    required: 'Last Name is required.'
                },
                email: {
                    required: 'Email Id is required.',
                    email: 'Enter a valid Email Id'
                },
                password: {
                    required: 'Password is required.'
                },
                password_confirmation: {
                    required: 'Password Confirmation is required.',
                    equalTo:'Password must be same'
                },
                mobile: {
                    required: "Mobile Number is required",
                    digits: "Mobile field accepts only numbers",
                    minlength: "Minimum length 10",
                    maxlength: "Maximum length 10",
                    regx: "Please Enter a valid Mobile Number"
                },
            },
            invalidHandler: () => { //display error alert on form submit
                $('.alert-danger', $('#registrationForm')).show();
            },
            highlight: (element) => { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            success: (label) => {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },
            errorPlacement: (error, element) => {
                // error.insertAfter(element.closest('.form-control'));
                error.insertAfter(element);
            },
            // submitHandler: (form) => {
            //     form.submit(); // form validation success, call ajax form submit
            // }
        });

        $('#registrationForm input').keypress((e) => {
            if (e.which === 13) {
                if ($('#registrationForm').validate().form()) {
                    $('#registrationForm').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });
    }

    handleForgotPassword() {
        $('#forgotPasswordForm').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: '',
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },

            messages: {
                email: {
                    required: 'Email is required.'
                }
            },

            invalidHandler: () => { //display error alert on form submit
                $('.alert-danger', $('#forgotPasswordForm')).show();
            },

            highlight: (element) => { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: (label) => {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: (error, element) => {
                error.insertAfter(element.closest('.form-control'));
            },
            // submitHandler: (form) => {
            //     form.submit();
            // }
        });

        $('#forgotPasswordForm input').keypress((e) => {
            if (e.which === 13) {
                if ($('#forgotPasswordForm').validate().form()) {
                    $('#forgotPasswordForm').submit();
                }
                return false;
            }
        });

    }

    handleResetPassword() {
        $('#resetPasswordForm').validate({
            errorElement: 'small', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                },
                password_confirmation: {
                    required: true,
                    equalTo : "#password"
                },
            },
            messages: {
                email: {
                    required: 'Email Id is required.',
                    email: 'Enter a valid Email Id'
                },
                password: {
                    required: 'Password is required.'
                },
                password_confirmation: {
                    required: 'Password Confirmation is required.',
                    equalTo:'Password must be same'
                },

            },
            invalidHandler: () => { //display error alert on form submit
                $('.alert-danger', $('#resetPasswordForm')).show();
            },
            highlight: (element) => { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            success: (label) => {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },
            errorPlacement: (error, element) => {
                // error.insertAfter(element.closest('.form-control'));
                error.insertAfter(element);
            },
            // submitHandler: (form) => {
            //     form.submit(); // form validation success, call ajax form submit
            // }
        });

        $('#resetPasswordForm input').keypress((e) => {
            if (e.which === 13) {
                if ($('#resetPasswordForm').validate().form()) {
                    $('#resetPasswordForm').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });
    }

    init() {
        this.handleLogin();
        this.handleRegistration();
        this.handleForgotPassword();
        this.handleResetPassword();
    }
}

$(document).ready(() => {
    new Auth().init();
});
