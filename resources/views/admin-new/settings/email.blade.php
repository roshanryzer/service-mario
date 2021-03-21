@extends('admin.layouts.contentLayoutMaster')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            {!! Form::open(['route' => ['settings.email.edit']]) !!}

            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            <i class="fas fa-envelope kt-font-danger fa-fw"></i>
                            {{ trans('setting.email.title') }}
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="form-group form-group-last">
                        <div class="alert alert-secondary" role="alert">
                            <div class="alert-text">
                                {{trans('setting.email.description') }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 offset-1">
                            <label class="text-capitalize"
                                   for="email_driver">{{ trans('setting.email.driver') }}</label>
                        </div>
                        <div class="col-md-7">
                            <select name="email_driver" class="custom-select" id="email_driver">
                                <option value="smtp"
                                        @if (setting('email_driver', config('mail.driver')) == 'smtp') selected @endif>
                                    SMTP
                                </option>
                                <option value="sendmail"
                                        @if (setting('email_driver', config('mail.driver')) == 'sendmail') selected @endif>
                                    SendMail
                                </option>
                                <option value="mailgun"
                                        @if (setting('email_driver', config('mail.driver')) == 'mailgun') selected @endif>
                                    MailGun
                                </option>
                                <option value="mandrill"
                                        @if (setting('email_driver', config('mail.driver')) == 'mandrill') selected @endif>
                                    Mandrill
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 offset-1">
                            <label class="text-capitalize"
                                   for="email_port">{{ trans('setting.email.port') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="number" class="form-control next-input"
                                   value="{{ setting('email_port', config('mail.port')) }}" id="email_port"
                                   name="email_port" data-counter="10"
                                   placeholder="{{ trans('setting.email.port_placeholder') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 offset-1">
                            <label class="text-capitalize"
                                   for="email_host">{{ trans('setting.email.host') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control next-input"
                                   value="{{ setting('email_host', config('mail.host')) }}" id="email_host"
                                   name="email_host" data-counter="60"
                                   placeholder="{{ trans('setting.email.host_placeholder') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 offset-1">
                            <label class="text-capitalize"
                                   for="email_username">{{ trans('setting.email.username') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control next-input"
                                   value="{{ setting('email_username', config('mail.username')) }}" id="email_username"
                                   name="email_username" data-counter="60"
                                   placeholder="{{ trans('setting.email.username_placeholder') }}">
                        </div>
                    </div>
                    <div
                        class="form-group row setting-mail-password @if (setting('email_driver', config('mail.driver')) == 'mailgun') hidden @endif">
                        <div class="col-md-3 offset-1">
                            <label class="text-capitalize"
                                   for="email_password">{{ trans('setting.email.password') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="password" class="form-control"
                                   value="{{ setting('email_password', config('mail.password')) }}" id="email_password"
                                   name="email_password" data-counter="120"
                                   placeholder="{{ trans('setting.email.password_placeholder') }}">
                        </div>
                    </div>
                    <div
                        class="form-group row setting-mail-mail-gun @if (setting('email_driver', config('mail.driver')) == 'mailgun') hidden @endif">
                        <div class="col-md-3 offset-1">
                            <label class="text-capitalize"
                                   for="email_password">{{ trans('setting.email.password') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="password" class="form-control"
                                   value="{{ setting('email_password', config('mail.password')) }}" id="email_password"
                                   name="email_password" data-counter="120"
                                   placeholder="{{ trans('setting.email.password_placeholder') }}">
                        </div>
                    </div>
                    <div
                        class="setting-mail-mail-gun @if (setting('email_driver', config('mail.driver')) !== 'mailgun') hidden @endif">
                        <div class="form-group">
                            <label class="text-title-field"
                                   for="email_mail_gun_domain">{{ trans('setting.email.mail_gun_domain') }}</label>
                            <input data-counter="60" type="text" class="next-input" name="email_mail_gun_domain"
                                   id="email_mail_gun_domain"
                                   value="{{ setting('email_mail_gun_domain', config('services.mailgun.domain')) }}"
                                   placeholder="{{ trans('setting.email.mail_gun_domain_placeholder') }}">
                        </div>
                        @if (!app()->environment('demo'))
                            <div class="form-group">
                                <label class="text-title-field"
                                       for="email_mail_gun_secret">{{ trans('setting.email.mail_gun_secret')  }}</label>
                                <input data-counter="60" type="text" class="next-input" name="email_mail_gun_secret"
                                       id="email_mail_gun_secret"
                                       value="{{ setting('email_mail_gun_secret', config('services.mailgun.secret')) }}"
                                       placeholder="{{ trans('setting.email.mail_gun_secret_placeholder') }}">
                            </div>
                        @endif
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 offset-1">
                            <label class="text-capitalize"
                                   for="email_encryption">{{ trans('setting.email.encryption') }}</label>
                        </div>
                        <div class="col-md-7">

                            <select name="email_encryption" class="custom-select" id="email_encryption">
                                <option value="tls"
                                        @if (setting('email_encryption', config('mail.encryption')) == 'tls') selected @endif>
                                    TLS
                                </option>
                                <option value="ssl"
                                        @if (setting('email_encryption', config('mail.encryption')) == 'ssl') selected @endif>
                                    SSL
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 offset-1">
                            <label class="text-capitalize"
                                   for="email_from_name">{{ trans('setting.email.sender_name') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control next-input"
                                   value="{{ setting('email_from_name', config('mail.from.name')) }}"
                                   id="email_from_name"
                                   name="email_from_name" data-counter="60"
                                   placeholder="{{ trans('setting.email.sender_name_placeholder') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 offset-1">
                            <label class="text-capitalize"
                                   for="email_from_address">{{ trans('setting.email.sender_email') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control next-input"
                                   value="{{ setting('email_from_address', config('mail.from.address')) }}"
                                   id="email_from_address"
                                   name="email_from_address" data-counter="60"
                                   placeholder="donot-reply@example.com">
                        </div>
                    </div>

                </div>
            </div>

            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{ trans('setting.email.template_title') }}
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="form-group form-group-last">
                        <div class="alert alert-secondary" role="alert">
                            <div class="alert-text">
                                {{ trans('setting.email.template_description') }}
                            </div>
                        </div>
                    </div>


                    <div class="wrapper-content pd-all-20">
                        <div class="table-wrap">
                            <table class="table product-list ws-nm">
                                <thead>
                                <tr>
                                    <th class="border-none-b">{{ trans('setting.template') }}</th>
                                    <th class="border-none-b"> {{ trans('setting.description') }} </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <a class="hover-underline a-detail-template"
                                           href="{{ route('setting.email.template.edit', ['type' => 'core', 'name' => 'base', 'template_file' => 'header']) }}">
                                            {{ trans('setting.email.template_header') }}
                                        </a>
                                    </td>
                                    <td>{{ trans('setting.email.template_header_description') }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a class="hover-underline a-detail-template"
                                           href="{{ route('setting.email.template.edit', ['type' => 'core', 'name' => 'base', 'template_file' => 'footer']) }}">
                                            {{ trans('setting.email.template_footer') }}
                                        </a>
                                    </td>
                                    <td>{{ trans('setting.email.template_footer_description') }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>



            {!! apply_filters(BASE_FILTER_AFTER_SETTING_EMAIL_CONTENT, null) !!}


            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <button class="btn btn-secondary" type="button" data-target="#send-test-email-modal"
                            data-toggle="modal">{{ trans('setting.test_send_mail') }}</button>
                    <button class="btn btn-info"
                            type="submit">{{ trans('setting.save_settings') }}</button>
                </div>
            </div>
            {!! Form::close() !!}
            {!! Form::modalAction('send-test-email-modal', trans('setting.test_email_modal_title'), 'info', view('admin.setting.test-email')->render(), 'send-test-email-btn', trans('setting.send')) !!}
        </div>
    </div>

@stop
