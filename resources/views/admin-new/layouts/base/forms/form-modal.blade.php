<div class="modal-box-container">
    @if ($showStart)
        {!! Form::open(array_except($formOptions, ['template'])) !!}
    @endif

    <div class="modal-title">
        <i class="til_img"></i> <strong>{!! $form->getTitle() !!}</strong>
    </div>
    <div class="modal-body">
        <div class="form-body">
            @if ($showFields)
                @foreach ($fields as $field)
                    @if (!in_array($field->getName(), $exclude))
                        {!! $field->render() !!}
                    @endif
                @endforeach
            @endif
        </div>
    </div>

    @if ($showEnd)
        {!! Form::close() !!}
    @endif
</div>

@if ($form->getValidatorClass())
    @if ($form->isUseInlineJs())
        {!! Assets::getAppModuleItemToHtml('form-validation') !!}
        {!! $form->renderValidatorJs() !!}
        @include('media::partials.media')
        <script>
            "use strict";
            Roshan.initMediaIntegrate();
        </script>
    @else
        @push('footer')
            {!! $form->renderValidatorJs() !!}
        @endpush
    @endif
@endif
