<input type="checkbox" class="custom-control-input" name="{{ $name }}" id="{{ $name }}" value="1"
       @if ($value) checked @endif {!! html_attributes_builder($attributes) !!}>
<label class="custom-control-label" for="{{ $name }}"></label>
