@extends('theme-temp.layouts.error')

@section('content')

    <div>
        <div class="col-md-10">
            <h3>{{ trans('errors.500_title') }}</h3>
            <p>{{ trans('errors.reasons') }}</p>
            <ul>
                {!! trans('errors.500_msg') !!}
            </ul>

            <p>{!! trans('errors.try_again') !!}</p>
        </div>
    </div>

@stop
