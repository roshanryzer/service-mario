@extends('admin.layouts.contentLayoutMaster')

@section('content')
    <div class="card">
        <div class="card-title">
            <h4>
                <span><i class="fas fa-sync"></i> {{ trans('cache.cache_commands') }}</span>
            </h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered vertical-middle table-hover">
                <colgroup>
                    <col width="70%">
                    <col width="30%">
                </colgroup>
                <tbody>
                    <tr>
                        <td>
                            {{ trans('cache.commands.clear_cms_cache.description') }}
                        </td>
                        <td>
                            <button class="btn btn-danger btn-block btn-clear-cache" data-type="clear_cms_cache" data-url="{{ route('system.cache.clear') }}">
                                {{ trans('cache.commands.clear_cms_cache.title') }}
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ trans('cache.commands.refresh_compiled_views.description') }}
                        </td>
                        <td>
                            <button class="btn btn-warning btn-block btn-clear-cache" data-type="refresh_compiled_views" data-url="{{ route('system.cache.clear') }}">
                                {{ trans('cache.commands.refresh_compiled_views.title') }}
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ trans('cache.commands.clear_config_cache.description') }}
                        </td>
                        <td>
                            <button class="btn green-meadow btn-block btn-clear-cache" data-type="clear_config_cache" data-url="{{ route('system.cache.clear') }}">
                                {{ trans('cache.commands.clear_config_cache.title') }}
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ trans('cache.commands.clear_route_cache.description') }}
                        </td>
                        <td>
                            <button class="btn green-meadow btn-block btn-clear-cache" data-type="clear_route_cache" data-url="{{ route('system.cache.clear') }}">
                                {{ trans('cache.commands.clear_route_cache.title') }}
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ trans('cache.commands.clear_log.description') }}
                        </td>
                        <td>
                            <button class="btn green-meadow btn-block btn-clear-cache" data-type="clear_log" data-url="{{ route('system.cache.clear') }}">
                                {{ trans('cache.commands.clear_log.title') }}
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
