@extends('admin.layouts.contentLayoutMaster')
@section('content')
    <section id="floating-label-layouts">

        @if ($showStart)
            {!! Form::open(array_except($formOptions, ['template'])) !!}
        @endif

        @if ($form->getModuleName())
            @php do_action(BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION, $form->getModuleName(), request(), $form->getModel()) @endphp
        @endif

        <div class="row <!--match-height-->">
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            @if ($showFields && $form->hasMainFields())
                                <div class="{{ $form->getWrapperClass() }}">
                                    <div class="row">
                                        @foreach ($fields as $key => $field)
                                            @if ($field->getName() == $form->getBreakFieldPoint())
                                                @break
                                            @else
                                                @unset($fields[$key])
                                            @endif
                                            <div class="col-12">
                                                @if (!in_array($field->getName(), $exclude))
                                                    {!! $field->render() !!}
                                                    @if ($field->getName() == 'name')
                                                        {!! apply_filters(BASE_FILTER_SLUG_AREA, $form->getModuleName(), $form->getModel()) !!}
                                                    @endif
                                                @endif
                                            </div>

                                        @endforeach
                                    </div>

                                </div>
                            @endif

                            @foreach ($form->getMetaBoxes() as $key => $metaBox)
                                {!! $form->getMetaBox($key) !!}
                            @endforeach

                            @if ($form->getModuleName())
                                @php do_action(BASE_ACTION_META_BOXES, $form->getModuleName(), 'advanced', $form->getModel()) @endphp
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12">

                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            {!! $form->getActionButtons() !!}
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">

                            @if ($form->getModuleName())
                                @php do_action(BASE_ACTION_META_BOXES, $form->getModuleName(), 'top', $form->getModel()) @endphp
                            @endif

                            @foreach ($fields as $field)
                                @if (!in_array($field->getName(), $exclude))
                                    <div class="card">
                                        <div class="card-title">
                                            <h4>{!! Form::customLabel($field->getName(), $field->getOption('label'), $field->getOption('label_attr')) !!}</h4>
                                        </div>
                                        <div class="card-body">
                                            {!! $field->render([], in_array($field->getType(), ['radio', 'checkbox'])) !!}
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            @if ($form->getModuleName())
                                @php do_action(BASE_ACTION_META_BOXES, $form->getModuleName(), 'side', $form->getModel()) @endphp
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($showEnd)
            {!! Form::close() !!}
        @endif
    </section>
@stop

@if ($form->getValidatorClass())
    @if ($form->isUseInlineJs())
        {!! Assets::getJavascriptItemToHtml('jquery') !!}
        {!! Assets::getAppModuleItemToHtml('form-validation') !!}
        {!! $form->renderValidatorJs() !!}
    @else
        @push('footer')
            {!! $form->renderValidatorJs() !!}
        @endpush
    @endif
@endif
