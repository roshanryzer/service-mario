<a href="{{ route('categories.edit', $item->id) }}" class="btn btn-icon btn-icon rounded-circle btn-primary mr-1 mb-1 waves-effect waves-light tip"
   data-original-title="{{ trans('tables.edit') }}"><i class="feather icon-edit"></i></a>
@if (!$item->is_default)
    <a href="#" class="btn btn-icon btn-icon rounded-circle btn-danger mr-1 mb-1 waves-effect waves-lightdeleteDialog tip" data-toggle="modal"
       data-section="{{ route('categories.delete', $item->id) }}" role="button"
       data-original-title="{{ trans('tables.delete_entry') }}">
        <i class="feather icon-trash"></i>
    </a>
@endif

