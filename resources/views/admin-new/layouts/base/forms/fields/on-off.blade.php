@if ($showLabel && $showField)

    @if ($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
            @endif
            @endif

            <p class="mb-0">
                {!! $name !!}
            </p>
            {!! Form::onOff($name, $options['value'], $options['attr']) !!}
            {{--            {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}--}}

            @include('admin.layouts.base.forms.partials.errors')

            @if ($showLabel && $showField)
                @if ($options['wrapper'] !== false)
        </div>
    @endif
@endif


<script>
</script>
