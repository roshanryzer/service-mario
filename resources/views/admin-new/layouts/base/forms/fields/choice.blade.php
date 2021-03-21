@if($showLabel && $showField)
    @if($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!} >
            @endif
            @endif
            @if($showLabel && $options['label'] !== false && $options['label_show'])
                {!!  Form::customLabel($name, $options['label'], $options['label_attr'])  !!}
            @endif
            @if($showField)
                @foreach ((array)$options['children'] as $child)
                    {!!  $child->render($options['choice_options'], true, true, false)  !!}
                @endforeach
                @include('admin.layouts.base.forms.partials.help_block')
            @endif
            @include('admin.layouts.base.forms.partials.errors')

            @if($showLabel && $showField)
                @if($options['wrapper'] !== false)
        </div>
    @endif
@endif
