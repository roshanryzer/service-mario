@extends('admin.layouts.contentLayoutMaster')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="bs-callout bs-callout-primary">
                <p>{{ trans('system.report_description') }}:</p>
                <button id="btn-report" class="btn btn-info btn-sm">{{ trans('system.get_system_report') }}</button>

                <div id="report-wrapper">
                    <textarea name="txt-report" id="txt-report" class="col-sm-12" rows="10" spellcheck="false" onfocus="this.select()">
                        ### {{ trans('system.system_environment') }}

                        - {{ trans('system.framework_version') }}: {{ $systemEnv['version'] }}
                        - {{ trans('system.timezone') }}: {{ $systemEnv['timezone'] }}
                        - {{ trans('system.debug_mode') }}: {!! $systemEnv['debug_mode'] ? '&#10004;' : '&#10008;' !!}
                        - {{ trans('system.storage_dir_writable') }}: {!! $systemEnv['storage_dir_writable'] ? '&#10004;' : '&#10008;' !!}
                        - {{ trans('system.cache_dir_writable') }}: {!! $systemEnv['cache_dir_writable'] ? '&#10004;' : '&#10008;' !!}
                        - {{ trans('system.app_size') }}: {{ $systemEnv['app_size'] }}
                        @foreach($systemExtras as $extraStatKey => $extraStatValue)
                            - {{ $extraStatKey }}: {{ is_bool($extraStatValue) ? ($extraStatValue ? '&#10004;' : '&#10008;') : $extraStatValue }}
                        @endforeach

                        ### {{ trans('system.server_environment') }}

                        - {{ trans('system.php_version') }}: {{ $serverEnv['version'] }}
                        - {{ trans('system.server_software') }}: {{ $serverEnv['server_software'] }}
                        - {{ trans('system.server_os') }}: {{ $serverEnv['server_os'] }}
                        - {{ trans('system.database') }}: {{ $serverEnv['database_connection_name'] }}
                        - {{ trans('system.ssl_installed') }}: {!! $serverEnv['ssl_installed'] ? '&#10004;' : '&#10008;' !!}
                        - {{ trans('system.cache_driver') }}: {{ $serverEnv['cache_driver'] }}
                        - {{ trans('system.session_driver') }}: {{ $serverEnv['session_driver'] }}
                        - {{ trans('system.mbstring_ext') }}: {!! $serverEnv['mbstring'] ? '&#10004;' : '&#10008;' !!}
                        - {{ trans('system.openssl_ext') }}: {!! $serverEnv['openssl'] ? '&#10004;' : '&#10008;' !!}
                        - {{ trans('system.pdo_ext') }}: {!! $serverEnv['pdo'] ? '&#10004;' : '&#10008;' !!}
                        - {{ trans('system.curl_ext') }}: {!! $serverEnv['curl'] ? '&#10004;' : '&#10008;' !!}
                        - {{ trans('system.exif_ext') }}: {!! $serverEnv['exif'] ? '&#10004;' : '&#10008;' !!}
                        - {{ trans('system.file_info_ext') }}: {!! $serverEnv['fileinfo'] ? '&#10004;' : '&#10008;' !!}
                        - {{ trans('system.tokenizer_ext') }}: {!! $serverEnv['tokenizer']  ? '&#10004;' : '&#10008;'!!}
                        @foreach($serverExtras as $extraStatKey => $extraStatValue)
                            - {{ $extraStatKey }}: {{ is_bool($extraStatValue) ? ($extraStatValue ? '&#10004;' : '&#10008;') : $extraStatValue }}
                        @endforeach

                        ### {{ trans('system.installed_packages') }}

                        @foreach($packages as $package)
                            - {{ $package['name'] }} : {{ $package['version'] }}
                        @endforeach

                        @if(!empty($extraStats))
                            ### {{ trans('system.extra_information') }}

                            @foreach($extraStats as $extraStatKey => $extraStatValue)
                                - {{ $extraStatKey }} : {{ is_bool($extraStatValue) ? ($extraStatValue ? '&#10004;' : '&#10008;') : $extraStatValue }}
                            @endforeach
                        @endif
                    </textarea>
                    <button id="copy-report" class="btn btn-info btn-sm">{{ trans('system.copy_report') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row"> <!-- Main Row -->

        <div class="col-sm-8"> <!-- Package & Dependency column -->
            <div class="card">
                <div class="card-title">
                    <h4>
                        <span>{{ trans('system.installed_packages') }}</span>
                    </h4>
                </div>
                <div class="card-body">
                    {!! $infoTable->renderTable() !!}
                </div>
            </div>
        </div> <!-- / Package & Dependency column -->

        <div class="col-sm-4"> <!-- Server Environment column -->
            <div class="card">
                <div class="card-title">
                    <h4>
                        <span>{{ trans('system.system_environment') }}</span>
                    </h4>
                </div>

                <ul class="list-group">
                    <li class="list-group-item">{{ trans('system.framework_version') }}: {{ $systemEnv['version'] }}</li>
                    <li class="list-group-item">{{ trans('system.timezone') }}: {{ $systemEnv['timezone'] }}</li>
                    <li class="list-group-item">{{ trans('system.debug_mode') }}: {!! $systemEnv['debug_mode'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('system.storage_dir_writable') }}: {!! $systemEnv['storage_dir_writable'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('system.cache_dir_writable') }}: {!! $systemEnv['cache_dir_writable'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('system.app_size') }}: {{ $systemEnv['app_size'] }}</li>
                    @foreach($systemExtras as $extraStatKey => $extraStatValue)
                        <li class="list-group-item">{{ $extraStatKey }}: {!! is_bool($extraStatValue) ? ($extraStatValue ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>') : $extraStatValue !!}</li>
                    @endforeach
                </ul>
            </div>

            <div class="card">
                <div class="card-title">
                    <h4>
                        <span>{{ trans('system.server_environment') }}</span>
                    </h4>
                </div>

                <ul class="list-group">
                    <li class="list-group-item">{{ trans('system.php_version') }}: {{ $serverEnv['version'] }}</li>
                    <li class="list-group-item">{{ trans('system.server_software') }}: {{ $serverEnv['server_software'] }}</li>
                    <li class="list-group-item">{{ trans('system.server_os') }}: {{ $serverEnv['server_os'] }}</li>
                    <li class="list-group-item">{{ trans('system.database') }}: {{ $serverEnv['database_connection_name'] }}</li>
                    <li class="list-group-item">{{ trans('system.ssl_installed') }}: {!! $serverEnv['ssl_installed'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('system.cache_driver') }}: {{ $serverEnv['cache_driver'] }}</li>
                    <li class="list-group-item">{{ trans('system.session_driver') }}: {{ $serverEnv['session_driver'] }}</li>
                    <li class="list-group-item">{{ trans('system.openssl_ext') }}: {!! $serverEnv['openssl'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('system.mbstring_ext') }}: {!! $serverEnv['mbstring'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('system.pdo_ext') }}: {!! $serverEnv['pdo'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('system.curl_ext') }}: {!! $serverEnv['curl'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('system.exif_ext') }}: {!! $serverEnv['exif'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('system.file_info_ext') }}: {!! $serverEnv['fileinfo'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('system.tokenizer_ext') }}: {!! $serverEnv['tokenizer']  ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>'!!}</li>
                    @foreach($serverExtras as $extraStatKey => $extraStatValue)
                        <li class="list-group-item">{{ $extraStatKey }}: {!! is_bool($extraStatValue) ? ($extraStatValue ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>') : $extraStatValue !!}</li>
                    @endforeach
                </ul>
            </div>

            @if(!empty($extraStats))
                <div class="card">
                    <div class="card-title">
                        <h4>
                            <span>{{ trans('system.extra_stats') }}</span>
                        </h4>
                    </div>

                    <ul class="list-group">
                        @foreach($extraStats as $extraStatKey => $extraStatValue)
                            <li class="list-group-item">{{ $extraStatKey }}: {!! is_bool($extraStatValue) ? ($extraStatValue ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>') : $extraStatValue !!}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div> <!-- / Server Environment column -->

    </div> <!-- / Main Row -->
@stop
