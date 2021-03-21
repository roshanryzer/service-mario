@if($showLabel && $showField)
    @if($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!} >
            @endif
            @endif

            @if($showField)

                    <div class="vs-checkbox-con vs-checkbox-success">
                        {!! Form::checkbox($name, $options['value'], $options['checked'], $options['attr'])  !!}

                        <span class="vs-checkbox">
                      <span class="vs-checkbox--check">
                        <i class="vs-icon feather icon-check"></i>
                      </span>
                    </span>
                        <span class="">
                             @if($showLabel && $options['label'] !== false && $options['label_show'])
                                {!!  Form::customLabel($name, $options['label'], $options['label_attr'])  !!}
                            @endif
                        </span>
                    </div>




                @include('admin.layouts.base.forms.partials.help_block')
            @endif

            @include('admin.layouts.base.forms.partials.errors')

            @if($showLabel && $showField)
                @if($options['wrapper'] !== false)
        </div>
    @endif
@endif
