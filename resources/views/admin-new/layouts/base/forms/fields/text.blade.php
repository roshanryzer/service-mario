@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!} >
            @endif
            @endif
            @if ($showField)
                {!! Form::input($type, $name, $options['value'], $options['attr']) !!}

                @include('admin.layouts.base.forms.partials.help_block')
            @endif
            @if ($showLabel && $options['label'] !== false && $options['label_show'])
                {!!   Form::customLabel($name, $options['label'], $options['label_attr'])!!}
            @endif


            @include('admin.layouts.base.forms.partials.errors')

            @if ($showLabel && $showField)
                @if ($options['wrapper'] !== false)
        </div>
    @endif
@endif
