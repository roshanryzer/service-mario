@if (!empty($categories))
    <div class="card">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseCategories">
            <h4 class="card-title">
                <span>{{ trans('categories.menu') }}</span>
                <i class="fa fa-angle-down narrow-icon"></i>
            </h4>
        </a>
        <div id="collapseCategories" class="panel-collapse collapse">
            <div class="card-body">
                <div class="box-links-for-menu">
                    <div class="the-box">
                        {!! $categories !!}
                        <div class="text-right">
                            <div class="btn-group btn-group-devided">
                                <a href="#" class="btn-add-to-menu btn btn-primary">
                                    <span class="text"><i class="fa fa-plus"></i> {{ trans('core.menu::menu.add_to_menu') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
