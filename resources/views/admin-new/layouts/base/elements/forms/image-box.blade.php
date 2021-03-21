<div class="card">
    <div class="card-title">
        <h4><span>{{ isset($title) ? $title : trans('forms.image') }}</span></h4>
    </div>
    <div class="card-body">
        {!! Form::mediaImage(isset($name) ? $name : 'image', $value) !!}
        {!! Form::error(isset($name) ? $name : 'image', $errors) !!}
    </div>
</div>
