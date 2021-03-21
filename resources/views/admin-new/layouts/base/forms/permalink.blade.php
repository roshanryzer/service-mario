<div id="edit-slug-box" @if (empty($value) && !$errors->has($name)) class="hidden" @endif>
    <label class="control-label required" for="current-slug">{{ trans('forms.permalink') }}:</label>
    <span id="sample-permalink">
        <a class="permalink" target="_blank" href="{{ str_replace('--slug--', $value, url($prefix . '/' . config('core.slug.general.pattern'))) }}">
            <span class="default-slug">{{ url($prefix) }}/<span id="editable-post-name">{{ $value }}</span>{{ $ending_url }}</span>
        </a>
    </span>
    ‎<span id="edit-slug-buttons">
        <button type="button" class="btn mr-1 mb-1 btn-outline-warning btn-sm waves-effect waves-light" id="change_slug">{{ trans('forms.edit') }}</button>
        <button type="button" class="save btn mr-1 mb-1 btn-outline-success btn-sm waves-effect waves-light" id="btn-ok">{{ trans('forms.ok') }}</button>
        <button type="button" class="cancel button-link btn mr-1 mb-1 btn-outline-danger btn-sm waves-effect waves-light">{{ trans('forms.cancel') }}</button>
    </span>
</div>
<input type="hidden" id="current-slug" name="{{ $name }}" value="{{ $value }}">
<div data-url="{{ route('slug.create') }}" data-view="{{ rtrim(str_replace('--slug--', '', url($prefix . '/' . config('core.slug.general.pattern'))), '/') . '/' }}" id="slug_id" data-id="{{ $id }}"></div>
<input type="hidden" name="slug_id" value="{{ $id }}">
