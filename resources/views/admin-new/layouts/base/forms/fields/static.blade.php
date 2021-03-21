@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
    <div {!! $options['wrapperAttrs'] !!} >
    @endif
@endif

@if ($showLabel && $options['label'] !== false && $options['label_show'])
    {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
@endif

@if ($showField)
    <{!! $options['tag'] !!} {!! $options['elemAttrs'] !!}>
            {!! e($options['value']) !!}
    </{!! $options['tag'] !!}>

    @include('admin.layouts.base.forms.partials.help_block')

@endif


@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
    </div>
    @endif
@endif
