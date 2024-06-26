@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif
@endif

@if ($showLabel && $options['label'] !== false && $options['label_show'])
    {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
@endif

@if ($showField)
    <div class="input-group color-picker">
        {!! Form::text($name, $options['value'] ?? '#000', $options['attr']) !!}
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i></i>
            </span>
        </div>
    </div>
    @include('admin.layouts.base.forms.partials.help_block')
@endif

@include('admin.layouts.base.forms.partials.errors')

@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        </div>
    @endif
@endif
