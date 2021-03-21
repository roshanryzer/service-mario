@extends('admin.layouts.contentLayoutMaster')
@section('content')


    <div class="row">
        <div class="col-lg-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            <i class="fas fa-images kt-font-success fa-fw"></i>
                            {{ trans('setting.media.title') }}
                        </h3>
                    </div>
                </div>
                {!! Form::open(['route' => ['settings.media']]) !!}
                <div class="kt-portlet__body">

                    <div class="form-group row">
                        <div class="col-md-3 offset-1">
                            <label class="text-title-field"
                                   for="media_driver">{{ trans('setting.media.driver') }}
                            </label>
                        </div>
                        <div class="col-md-7">
                            <select name="media_driver" class="custom-select" id="media_driver">
                                <option value="local" @if (setting('media_driver') === 'local') selected @endif>Local</option>
                                <option value="s3" @if (setting('media_driver') === 's3') selected @endif>Amazon S3</option>
                            </select>
                        </div>
                    </div>
                    <div class="s3-config-wrapper" @if (setting('media_driver') !== 's3') style="display: none;" @endif>

                        <div class="form-group row">
                            <div class="col-md-3 offset-1">
                                <label class="text-capitalize text-right "
                                       for="media_aws_access_key_id">{{ trans('setting.media.aws_access_key_id') }}</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control next-input"
                                       value="{{ setting('media_aws_access_key_id') }}" id="media_aws_access_key_id"
                                       name="media_aws_access_key_id" placeholder="Ex: AKIAIKYXBSNBXXXXXX" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3 offset-1">
                                <label class="text-capitalize text-right "
                                       for="media_aws_secret_key">{{ trans('setting.media.aws_secret_key') }}</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control next-input"
                                       value="{{ setting('media_aws_secret_key') }}" id="media_aws_secret_key"
                                       name="media_aws_secret_key" placeholder="Ex: +fivlGCeTJCVVnzpM2WfzzrFIMLHGhxxxxxxx" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3 offset-1">
                                <label class="text-capitalize text-right "
                                       for="media_aws_default_region">{{ trans('setting.media.aws_default_region') }}</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control next-input"
                                       value="{{ setting('media_aws_default_region') }}" id="media_aws_default_region"
                                       name="media_aws_default_region" placeholder="Ex: ap-southeast-1" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 offset-1">
                                <label class="text-capitalize text-right "
                                       for="media_aws_bucket">{{ trans('setting.media.aws_bucket') }}</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control next-input"
                                       value="{{ setting('media_aws_bucket') }}" id="media_aws_bucket"
                                       name="media_aws_bucket" placeholder="Ex: ap-southeast-1" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 offset-1">
                                <label class="text-capitalize text-right "
                                       for="media_aws_url">{{ trans('setting.media.aws_url') }}</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control next-input"
                                       value="{{ setting('media_aws_url') }}" id="media_aws_url"
                                       name="media_aws_url" placeholder="Ex: https://s3-ap-southeast-1.amazonaws.com/roshan" >
                            </div>
                        </div>


                    </div>
                </div>

                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <button type="submit"
                                class="btn btn-primary">
                            {{ trans('setting.save_settings') }}</button>
                    </div>
                </div>
                {!! Form::close() !!}


                {{--<div class="max-width-1200">
                    <div class="flexbox-annotated-section">

                        <div class="flexbox-annotated-section-annotation">
                            <div class="annotated-section-title pd-all-20">
                                <h2></h2>
                            </div>
                            <div class="annotated-section-description pd-all-20 p-none-t">
                                <p class="color-note">{{ trans('setting.media.description') }}</p>
                            </div>
                        </div>

                        <div class="flexbox-annotated-section-content">
                            <div class="wrapper-content pd-all-20">


                            </div>
                        </div>

                    </div>

                    <div class="flexbox-annotated-section" style="border: none">
                        <div class="flexbox-annotated-section-annotation">
                            &nbsp;
                        </div>
                        <div class="flexbox-annotated-section-content">
                            <button class="btn btn-info" type="submit">{{ trans('setting.save_settings') }}</button>
                        </div>
                    </div>
                </div>--}}



            </div>
        </div>
    </div>



@endsection

@push('footer')
    <script>
        $(document).ready(function () {
            $(document).on('change', '#media_driver', function () {
               if ($(this).val() === 's3') {
                   $('.s3-config-wrapper').show();
               } else {
                   $('.s3-config-wrapper').hide();
               }
            });
        });
    </script>
@endpush
