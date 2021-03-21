@if (array_get($meta_box, 'before_wrapper'))
    {!! array_get($meta_box, 'before_wrapper') !!}
@endif

@if (array_get($meta_box, 'wrap', true))
    <div class="card" {{ Html::attributes(array_get($meta_box, 'attributes', [])) }}>
        <div class="card-title">
            <h4>
                <span> {{ array_get($meta_box, 'title') }}</span>
            </h4>
        </div>
        <div class="card-body">
            {!! array_get($meta_box, 'content') !!}
        </div>
    </div>
@else
    {!! array_get($meta_box, 'content') !!}
@endif

@if (array_get($meta_box, 'after_wrapper'))
    {!! array_get($meta_box, 'after_wrapper') !!}
@endif
