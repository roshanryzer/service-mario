@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif
@endif

@if ($showField)
    {!! Form::permalink($name, $options['value'], 0, $prefix) !!}
    @include('admin.layouts.base.forms.partials.help_block')
@endif

@include('admin.layouts.base.forms.partials.errors')


@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        </div>
    @endif
@endif
