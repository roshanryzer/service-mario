<div class="form-actions form-actions-default action-{{ $direction ?? 'horizontal' }}">
    <div class="card-title">
        <h4>
            @if (isset($icon) && !empty($icon))
                <i class="{{ $icon }}"></i>
            @endif
            <span>{{ isset($title) ? $title : apply_filters(BASE_ACTION_FORM_ACTIONS_TITLE, trans('forms.publish')) }}</span>
        </h4>
    </div>
    <div class="card-body">
        <div class="btn-set">
            @php do_action(BASE_ACTION_FORM_ACTIONS, 'default') @endphp
            <button type="submit" name="submit" value="save" class="btn btn-success mr-1 mb-1 waves-effect waves-light">
                <i class="fa fa-save"></i> {{ trans('forms.save') }}
            </button>
            @if (!isset($only_save) || $only_save == false)
                &nbsp;
            <button type="submit" name="submit" value="apply" class="btn btn-info mr-1 mb-1 waves-effect waves-light">
                <i class="fa fa-check-circle"></i> {{ trans('forms.save_and_continue') }}
            </button>
            @endif
        </div>
    </div>
</div>
<div id="waypoint"></div>
<div class="form-actions form-actions-fixed-top hidden">
{{--    {!! AdminBreadcrumb::render() !!}--}}
    <div class="btn-set">
        @php do_action(BASE_ACTION_FORM_ACTIONS, 'fixed-top') @endphp
        <button type="submit" name="submit" value="save" class="btn btn-success mr-1 mb-1 waves-effect waves-light">
            <i class="fa fa-save"></i> {{ trans('forms.save') }}
        </button>
        @if (!isset($only_save) || $only_save == false)
            &nbsp;
            <button type="submit" name="submit" value="apply" class="btn btn-info mr-1 mb-1 waves-effect waves-light">
                <i class="fa fa-check-circle"></i> {{ trans('forms.save_and_continue') }}
            </button>
        @endif
    </div>
</div>
