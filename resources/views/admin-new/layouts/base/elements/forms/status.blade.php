<div class="card">
    <div class="card-title">
        <h4><span class="required">{{ trans('tables.status') }}</span></h4>
    </div>
    <div class="card-body">
        <div class="ui-select-wrapper">
            {!! Form::select(isset($name) ? $name : 'status', isset($values) ? $values : [1 => trans('system.activated'), 0 => trans('system.deactivated')], isset($selected) ? $selected : old(isset($name) ? $name : 'status', 1), ['class' => 'ui-select']) !!}
            <svg class="svg-next-icon svg-next-icon-size-16">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#select-chevron"></use>
            </svg>
        </div>
    </div>
</div>
