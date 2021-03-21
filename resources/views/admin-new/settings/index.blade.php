@extends('admin.layouts.contentLayoutMaster')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            <i class="fas fa-cogs kt-font-success fa-fw"></i> {{ trans('setting.title') }}
                        </h3>
                    </div>
                </div>
                {!! Form::open(['route' => ['settings.edit']]) !!}
                <div class="kt-portlet__body">


                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active kt-font-danger" data-toggle="tab" href="#kt_tabs_general_info">
                                <i class="la la-building-o kt-font-danger"></i>
                                {{ trans('setting.general.title') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link kt-font-success" data-toggle="tab" href="#kt_tabs_admin_appearance_title">
                                <i class="fas fa-user-shield"></i>
                                {{ trans('setting.general.admin_appearance_title') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link kt-font-warning" data-toggle="tab" href="#kt_tabs_seo">
                                <i class="la la-search-plus "></i>
                                {{ trans('setting.general.seo_block') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link kt-font-primary" data-toggle="tab" href="#kt_tabs_cache">
                                <i class="la la-fast-forward "></i>
                                {{ trans('setting.general.cache_block') }}

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link kt-font-secondary" data-toggle="tab" href="#kt_tabs_google_analytics">
                                <i class="la la-line-chart "></i>
                                {{ trans('setting.settings.title') }}

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link kt-font-danger" data-toggle="tab" href="#kt_tabs_backup">
                                <i class="la la-server "></i>
                                {{ trans('backup.settings.title') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_tabs_captcha">
                                <i class="la la-font  kt-font-info"></i>
                                {{ trans('captcha.settings.title') }}
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="kt_tabs_general_info" role="tabpanel">
                            <div class="form-group form-group-last">
                                <div class="alert alert-secondary" role="alert">
                                    <div class="alert-text">
                                        {{ trans('setting.general.description') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="site_title">{{ trans('setting.general.site_title') }}</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control next-input"
                                           value="{{ setting('site_title') }}" id="site_title"
                                           name="site_title" data-counter="120"
                                           placeholder="{{ trans('setting.general.site_title') }}">
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="show_site_name">{{ trans('setting.general.show_site_name') }}</label>
                                </div>
                                <div class="col-md-7">
                                    <label class="kt-radio kt-radio--success">
                                        <input type="radio" name="show_site_name" value="1"
                                               @if (setting('show_site_name', false)) checked
                                            @endif> {{ trans('setting.general.show') }}
                                        <span></span>
                                    </label>

                                    <label class="kt-radio kt-radio--success">
                                        <input type="radio" name="show_site_name" value="0"
                                               @if (!setting('show_site_name', false)) checked
                                            @endif> {{ trans('setting.general.hide') }}
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="show_on_front">{{ trans('setting.general.show_on_front') }}</label>
                                </div>
                                <div class="col-md-7">
                                    <select name="show_on_front" class="custom-select form-control" id="show_on_front">
                                        <option value="">{{ trans('setting.general.select') }}</option>
                                        @foreach($pages as $page)
                                            <option value="{{ $page->id }}"
                                                    @if (setting('show_on_front') == $page->id) selected
                                                @endif>{{ $page->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="admin_email">{{ trans('setting.general.admin_email') }}</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control next-input"
                                           value="{{ setting('admin_email') }}" id="admin_email"
                                           name="admin_email" data-counter="120"
                                           placeholder="{{ trans('setting.general.admin_email') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="time_zone">{{ trans('setting.general.time_zone') }}</label>
                                </div>
                                <div class="col-md-7">

                                    <select name="time_zone" class="custom-select form-control" id="time_zone">
                                        @foreach(DateTimeZone::listIdentifiers(DateTimeZone::ALL) as $time_zone)
                                            <option value="{{ $time_zone }}"
                                                    @if (setting('time_zone', 'UTC') === $time_zone) selected @endif>{{ $time_zone }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize" for="optimize_page_speed_enable">
                                        {{ trans('setting.general.optimize_page_speed') }}
                                    </label>
                                </div>
                                <div class="col-md-7">

                                    <label class="kt-radio kt-radio--success">
                                        <input type="radio" name="optimize_page_speed_enable" value="1"
                                               @if (setting('optimize_page_speed_enable')) checked
                                            @endif> {{ trans('setting.general.yes') }}
                                        <span></span>
                                    </label>
                                    <label class="kt-radio kt-radio--success">
                                        <input type="radio" name="optimize_page_speed_enable" value="0"
                                               @if (!setting('optimize_page_speed_enable')) checked
                                            @endif> {{ trans('setting.general.no') }}
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="enable_send_error_reporting_via_email">{{ trans('setting.general.enable_send_error_reporting_via_email') }}</label>
                                </div>
                                <div class="col-md-7">

                                    <label class="kt-radio kt-radio--success">
                                        <input type="radio" name="enable_send_error_reporting_via_email" value="1"
                                               @if (setting('enable_send_error_reporting_via_email')) checked
                                            @endif> {{ trans('setting.general.yes') }}
                                        <span></span>
                                    </label>
                                    <label class="kt-radio kt-radio--success">
                                        <input type="radio" name="enable_send_error_reporting_via_email" value="0"
                                               @if (!setting('enable_send_error_reporting_via_email')) checked
                                            @endif> {{ trans('setting.general.no') }}
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="kt_tabs_admin_appearance_title" role="tabpanel">
                            <div class="form-group form-group-last">
                                <div class="alert alert-secondary" role="alert">
                                    <div class="alert-text">
                                        {{ trans('setting.general.admin_appearance_description') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="admin_logo">{{ trans('setting.general.admin_logo') }}</label>
                                </div>
                                <div class="col-md-7">
{{--                                    {!! Form::mediaImage('admin_logo', setting('admin_logo', config('core.base.general.logo')), ['allow_thumb' => true]) !!}--}}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="admin_title">{{ trans('setting.general.admin_title') }}</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control next-input"
                                           value="{{ setting('admin_title') }}" id="admin_title"
                                           name="admin_title" data-counter="120"
                                           placeholder="{{ trans('setting.general.admin_title') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="rich_editor">{{ trans('setting.general.rich_editor') }}</label>
                                </div>
                                <div class="col-md-7">
                                    <label class="kt-radio kt-radio--success">
                                        <input type="radio" name="rich_editor" value="ckeditor"
                                               @if (setting('rich_editor', 'ckeditor') == 'ckeditor') checked @endif> {{ __('CKEditor') }}
                                        <span></span>
                                    </label>

                                    <label class="kt-radio kt-radio--success">
                                        <input type="radio" name="rich_editor" value="tinymce"
                                               @if (setting('rich_editor', 'ckeditor') == 'tinymce') checked @endif> {{ __('TinyMCE') }}
                                        <span></span>
                                    </label>


                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="default_admin_theme">{{ trans('setting.general.default_admin_theme') }}</label>
                                </div>
                                <div class="col-md-7">

                                    <select name="default_admin_theme" class="custom-select form-control"
                                            id="default_admin_theme">
                                        @foreach(Assets::getThemes() as $theme => $path)
                                            <option value="{{ $theme }}"
                                                    @if (setting('default_admin_theme', config('core.base.general.default-theme')) === $theme) selected @endif>{{ Str::studly($theme) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="show_admin_bar">{{ trans('setting.general.show_admin_bar') }}</label>
                                </div>
                                <div class="col-md-7">
                                    <label class="kt-radio kt-radio--success">
                                        <input type="radio" name="show_admin_bar" value="1"
                                               @if (setting('show_admin_bar')) checked
                                            @endif> {{ trans('setting.general.yes') }}
                                        <span></span>
                                    </label>
                                    <label class="kt-radio kt-radio--success">
                                        <input type="radio" name="show_admin_bar" value="0"
                                               @if (!setting('show_admin_bar')) checked
                                            @endif> {{ trans('setting.general.no') }}
                                        <span></span>
                                    </label>


                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="enable_change_admin_theme">{{ trans('setting.general.enable_change_admin_theme') }}</label>
                                </div>
                                <div class="col-md-7">
                                    <label class="kt-radio kt-radio--success">
                                        <input type="radio" name="enable_change_admin_theme" value="1"
                                               @if (setting('enable_change_admin_theme')) checked
                                            @endif> {{ trans('setting.general.yes') }}
                                        <span></span>
                                    </label>
                                    <label class="kt-radio kt-radio--success">
                                        <input type="radio" name="enable_change_admin_theme" value="0"
                                               @if (!setting('enable_change_admin_theme')) checked
                                            @endif> {{ trans('setting.general.no') }}
                                        <span></span>
                                    </label>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize" for="enable_multi_language_in_admin">
                                        {{ trans('setting.general.enable_multi_language_in_admin') }}</label>
                                </div>
                                <div class="col-md-7">
                                    <label class="kt-radio kt-radio--success">
                                        <input type="radio" name="enable_multi_language_in_admin" value="1"
                                               @if (setting('enable_multi_language_in_admin')) checked
                                            @endif> {{ trans('setting.general.yes') }}
                                        <span></span>
                                    </label>
                                    <label class="kt-radio kt-radio--success">
                                        <input type="radio" name="enable_multi_language_in_admin" value="0"
                                               @if (!setting('enable_multi_language_in_admin')) checked
                                            @endif> {{ trans('setting.general.no') }}
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="admin_login_background_image">{{ trans('setting.general.admin_login_background_image') }}</label>
                                </div>
                                <div class="col-md-7">
{{--                                    {!! Form::mediaImage('admin_login_background_image', setting('admin_login_background_image'), ['allow_thumb' => true]) !!}--}}
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="kt_tabs_seo" role="tabpanel">
                            <div class="form-group form-group-last">
                                <div class="alert alert-secondary" role="alert">
                                    <div class="alert-text">
                                        {{ trans('setting.general.seo_block_description') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="seo_title">{{ trans('setting.general.seo_title') }}</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control next-input"
                                           value="{{ setting('seo_title') }}" id="seo_title"
                                           name="seo_title" data-counter="120"
                                           placeholder="{{ trans('setting.general.seo_title') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="seo_keywords">{{ trans('setting.general.seo_keywords') }}</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control next-input"
                                           value="{{ setting('seo_keywords') }}" id="seo_keywords"
                                           name="seo_keywords" data-counter="120"
                                           placeholder="{{ trans('setting.general.seo_keywords') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="seo_description">{{ trans('setting.general.seo_description') }}</label>
                                </div>
                                <div class="col-md-7">
                                    <textarea data-counter="386" class="form-control next-input " id="seo_description"
                                              name="seo_description">{{ setting('seo_description') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="google_site_verification">{{ trans('setting.general.google_site_verification') }}</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control next-input"
                                           value="{{ setting('google_site_verification') }}"
                                           id="google_site_verification"
                                           name="google_site_verification" data-counter="120"
                                           placeholder="{{ trans('setting.general.google_site_verification') }}">
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane" id="kt_tabs_cache" role="tabpanel">
                            <div class="form-group form-group-last">
                                <div class="alert alert-secondary" role="alert">
                                    <div class="alert-text">
                                        {{ trans('setting.general.cache_description') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize" for="enable_cache">
                                        {{ trans('setting.general.enable_cache') }}</label>
                                </div>
                                <div class="col-md-7">

                                    <label class="kt-radio kt-radio--success">
                                        <input type="radio" name="enable_cache" value="1"
                                               @if (setting('enable_cache')) checked
                                            @endif> {{ trans('setting.general.yes') }}
                                        <span></span>
                                    </label>
                                    <label class="kt-radio kt-radio--success">
                                        <input type="radio" name="enable_cache" value="0"
                                               @if (!setting('enable_cache')) checked
                                            @endif> {{ trans('setting.general.no') }}
                                        <span></span>
                                    </label>


                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="cache_time">{{ trans('setting.general.cache_time') }}</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="number" class="form-control next-input"
                                           value="{{ setting('cache_time'),10 }}" id="cache_time"
                                           name="cache_time" data-counter="120" min="0"
                                           placeholder="{{ trans('setting.general.cache_time') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="cache_time_site_map">{{ trans('setting.general.cache_time_site_map') }}</label>
                                </div>
                                <div class="col-md-7">
                                    <label class="text-title-field"
                                           for="cache_time_site_map">{{ trans('setting.general.cache_time_site_map') }}</label>
                                    <input type="number" class="form-control next-input" name="cache_time_site_map"
                                           id="cache_time_site_map"
                                           value="{{ setting('cache_time_site_map', 3600) }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize" for="cache_admin_menu_enable">
                                        {{ trans('setting.general.cache_admin_menu') }}</label>
                                </div>
                                <div class="col-md-7">


                                    <label class="kt-radio kt-radio--success">
                                        <input type="radio" name="cache_admin_menu_enable" value="1"
                                               @if (setting('cache_admin_menu_enable')) checked
                                            @endif> {{ trans('setting.general.yes') }}
                                        <span></span>
                                    </label>
                                    <label class="kt-radio kt-radio--success">
                                        <input type="radio" name="cache_admin_menu_enable" value="0"
                                               @if (!setting('cache_admin_menu_enable')) checked
                                            @endif> {{ trans('setting.general.no') }}
                                        <span></span>
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane" id="kt_tabs_google_analytics" role="tabpanel">
                            <div class="form-group form-group-last">
                                <div class="alert alert-secondary" role="alert">
                                    <div class="alert-text">
                                        {{ trans('setting.settings.description') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="google_analytics">{{ trans('setting.settings.tracking_code') }}</label>
                                </div>
                                <div class="col-md-7">
                                    <input data-counter="120" type="text" class="form-control next-input"
                                           name="google_analytics" id="google_analytics"
                                           value="{{ setting('google_analytics') }}"
                                           placeholder="{{ trans('setting.settings.tracking_code_placeholder') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="view_id">{{ trans('setting.settings.view_id') }}</label>
                                </div>
                                <div class="col-md-7">
                                    <input data-counter="120" type="text" class="form-control next-input"
                                           name="analytics_view_id" id="analytics_view_id"
                                           value="{{ setting('analytics_view_id', config('plugins.analytics.general.view_id')) }}"
                                           placeholder="{{ trans('setting.settings.view_id_description') }}">

                                </div>
                            </div>
                            @if (!app()->environment('demo'))
                                <div class="form-group row">
                                    <div class="col-md-3 offset-1">
                                        <label class="text-capitalize"
                                               for="analytics_service_account_credentials">{{ trans('setting.settings.json_credential') }}</label>
                                    </div>
                                    <div class="col-md-7">
                                        <textarea class="next-input form-control"
                                                  name="analytics_service_account_credentials"
                                                  id="analytics_service_account_credentials" rows="5"
                                                  placeholder="{{ trans('setting.settings.json_credential_description') }}">{{ setting('analytics_service_account_credentials') }}</textarea>

                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="tab-pane" id="kt_tabs_backup" role="tabpanel">
                            <div class="form-group form-group-last">
                                <div class="alert alert-secondary" role="alert">
                                    <div class="alert-text">
                                        {{ trans('backup.settings.description') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize" for="backup_mysql_execute_path">
                                        {{ trans('backup.settings.backup_mysql_execute_path') }}
                                    </label>
                                </div>
                                <div class="col-md-7">
                                    <input data-counter="120" type="text" class="form-control next-input"
                                           name="backup_mysql_execute_path" id="backup_mysql_execute_path"
                                           value="{{ setting('backup_mysql_execute_path') }}"
                                           placeholder="{{ trans('backup.settings.backup_mysql_execute_path_placeholder') }}">

                                </div>
                            </div>

                        </div>

                        <div class="tab-pane" id="kt_tabs_captcha" role="tabpanel">
                            <div class="form-group form-group-last">
                                <div class="alert alert-secondary" role="alert">
                                    <div class="alert-text">
                                        {{ trans('captcha.settings.description') }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize" for="enable_captcha">
                                        {{ trans('setting.general.optimize_page_speed') }}
                                    </label>
                                </div>
                                <div class="col-md-7">

                                    <label class="kt-radio kt-radio--success">
                                        <input type="radio" name="enable_captcha" value="1"
                                               @if (setting('enable_captcha')) checked
                                            @endif> {{ trans('setting.general.yes') }}
                                        <span></span>
                                    </label>
                                    <label class="kt-radio kt-radio--success">
                                        <input type="radio" name="enable_captcha" value="0"
                                               @if (!setting('enable_captcha')) checked
                                            @endif> {{ trans('setting.general.no') }}
                                        <span></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="captcha_site_key">{{ trans('captcha.settings.captcha_site_key') }}</label>
                                </div>
                                <div class="col-md-7">
                                    <input data-counter="120" type="text" class="form-control next-input"
                                           name="captcha_site_key" id="captcha_site_key"
                                           value="{{ setting('captcha_site_key', config('plugins.captcha.general.site_key')) }}"
                                           placeholder="{{ trans('captcha.settings.captcha_site_key') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3 offset-1">
                                    <label class="text-capitalize"
                                           for="captcha_secret">{{ trans('captcha.settings.captcha_secret') }}</label>
                                </div>
                                <div class="col-md-7">
                                    <input data-counter="120" type="text" class="form-control next-input"
                                           name="captcha_secret" id="captcha_secret"
                                           value="{{ setting('captcha_secret', config('plugins.captcha.general.secret')) }}"
                                           placeholder="{{ trans('captcha.settings.captcha_secret') }}">
                                </div>
                            </div>

                            <span
                                class="form-text text-muted"> {{ trans('captcha.settings.helper') }}</span>

                        </div>


                        {{--{!! apply_filters(BASE_FILTER_AFTER_SETTING_CONTENT, null) !!}--}}
                    </div>
                </div>


                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <button type="submit" class="btn btn-primary">
                            {{ trans('setting.save_settings') }}
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
