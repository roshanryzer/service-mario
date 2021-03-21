@extends('admin.layouts.contentLayoutMaster')
@section('content')
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            @if ($table->isHasFilter())
                                <div class="table-configuration-wrap" @if (request()->has('filter_table_id')) style="display: block;" @endif>
                                    <span class="configuration-close-btn btn-show-table-options"><i class="fa fa-times"></i></span>
                                    {!! $table->renderFilter() !!}
                                </div>
                            @endif
                        </div>

                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">


                            @if ($actions)
                                <div class="btn-group dropdown mr-1 mb-1">
                                    <button type="button" class="btn btn-primary">{{ trans('general.bulk_actions') }}</button>
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        @foreach ($actions as $action)
                                            {!! $action !!}
                                        @endforeach
                                    </div>
                                </div>

                                <div class="btn-group mb-1">
                                    <div class="dropdown">
                                        <button class="btn btn-info dropdown-toggle mr-1" type="button"                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{ trans('general.bulk_actions') }}
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                            @foreach ($actions as $action)
                                                <li>
                                                    {!! $action !!}
                                                </li>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($table->isHasFilter())
                                <button class="btn btn-primary btn-show-table-options">{{ trans('general.filters') }}</button>
                            @endif
                            <p class="card-text"> ...</p>
                            <div class="table-responsive">
                                @section('main-table')
                                    {!! $dataTable->table(compact('id', 'class'), false) !!}
                                @show
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page-script')
    {!! $dataTable->scripts() !!}
@endsection
