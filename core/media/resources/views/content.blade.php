<div class="rv-media-container">
    <div class="rv-media-wrapper">
        <input type="checkbox" id="media_aside_collapse" class="fake-click-event hidden">
        <input type="checkbox" id="media_details_collapse" class="fake-click-event hidden">
        <aside class="rv-media-aside @if (config('media.sidebar_display') != 'vertical') rv-media-aside-hide-desktop @endif">
            <label for="media_aside_collapse" class="collapse-sidebar">
                <i class="fas fa-sign-out-alt"></i>
            </label>
            <div class="rv-media-block rv-media-filters">
                <div class="rv-media-block-title">
                    {{ trans('core-media::media.filter') }}
                </div>
                <div class="rv-media-block-content">
                    <ul class="rv-media-aside-list">
                        <li>
                            <a href="#" class="js-rv-media-change-filter" data-type="filter" data-value="everything">
                                <i class="fa fa-recycle"></i> {{ trans('core-media::media.everything') }}
                            </a>
                        </li>
                        @if (array_key_exists('image', config('media.mime_types', [])))
                            <li>
                                <a href="#" class="js-rv-media-change-filter" data-type="filter" data-value="image">
                                    <i class="fa fa-file-image-o"></i> {{ trans('core-media::media.image') }}
                                </a>
                            </li>
                        @endif
                        @if (array_key_exists('video', config('media.mime_types', [])))
                            <li>
                                <a href="#" class="js-rv-media-change-filter" data-type="filter" data-value="video">
                                    <i class="fa fa-file-video-o"></i> {{ trans('core-media::media.video') }}
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="#" class="js-rv-media-change-filter" data-type="filter" data-value="document">
                                <i class="fa fa-file-o"></i> {{ trans('core-media::media.document') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="rv-media-block rv-media-view-in">
                <div class="rv-media-block-title">
                    {{ trans('core-media::media.view_in') }}
                </div>
                <div class="rv-media-block-content">
                    <ul class="rv-media-aside-list">
                        @if (config('media.mode') != 'simple')
                            <li>
                                <a href="#" class="js-rv-media-change-filter" data-type="view_in" data-value="my_media">
                                    <i class="fa fa-user-secret"></i> {{ trans('core-media::media.my_media') }}
                                </a>
                            </li>
                            <li>
                                <a href="#" class="js-rv-media-change-filter" data-type="view_in" data-value="public">
                                    <i class="fa fa-globe"></i> {{ trans('core-media::media.public') }}
                                </a>
                            </li>
                            <li>
                                <a href="#" class="js-rv-media-change-filter" data-type="view_in" data-value="shared">
                                    <i class="fa fa-share-square"></i> {{ trans('core-media::media.shared') }}
                                </a>
                            </li>
                            <li>
                                <a href="#" class="js-rv-media-change-filter" data-type="view_in"
                                   data-value="shared_with_me">
                                    <i class="fa fa-share-alt-square"></i> {{ trans('core-media::media.shared_with_me') }}
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="#" class="js-rv-media-change-filter" data-type="view_in" data-value="my_media">
                                    <i class="fa fa-globe"></i> {{ trans('core-media::media.all_media') }}
                                </a>
                            </li>
                        @endif
                        @if (BMedia::hasAnyPermission(['folders.delete', 'files.delete']))
                            <li>
                                <a href="#" class="js-rv-media-change-filter" data-type="view_in" data-value="trash">
                                    <i class="fa fa-trash"></i> {{ trans('core-media::media.trash') }}
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="#" class="js-rv-media-change-filter" data-type="view_in" data-value="recent">
                                <i class="fa fa-clock-o"></i> {{ trans('core-media::media.recent') }}
                            </a>
                        </li>
                        <li>
                            <a href="#" class="js-rv-media-change-filter" data-type="view_in" data-value="favorites">
                                <i class="fa fa-star"></i> {{ trans('core-media::media.favorites') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="rv-media-aside-bottom">
                <div class="progress">
                    <div class="progress-bar progress-bar-danger" role="progressbar" style="width: 0;"></div>
                </div>
                <div class="used-analytics"><span>...</span></div>
            </div>
        </aside>
        <div class="rv-media-main-wrapper">
            <header class="rv-media-header">
                <div class="rv-media-top-header">
                    <div class="rv-media-actions">
                        <label for="media_aside_collapse" class="btn btn-danger collapse-sidebar">
                            <i class="fa fa-bars"></i>
                        </label>
                        @if (BMedia::hasPermission('files.create'))
                            <button class="btn btn-success js-dropzone-upload">
                                <i class="fa fa-cloud-upload"></i> {{ trans('core-media::media.upload') }}
                            </button>
                        @endif
                        @if (config('media.allow_external_services') && BMedia::hasPermission('files.create'))
                            <div class="btn-group" role="group">
                                <div class="dropdown">
                                    <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">
                                        <i class="fa fa-plus"></i> {{ trans('core-media::media.add_from') }}
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="#" data-toggle="modal" data-target="#modal_add_from_youtube">
                                                <i class="fa fa-youtube"></i> {{ trans('core-media::media.youtube') }}
                                            </a>
                                        </li>
                                        @if (app()->environment() == 'demo')
                                            <li>
                                                <a href="#" data-toggle="modal" data-target="#modal_coming_soon">
                                                    <i class="fa fa-vimeo"></i> {{ trans('core-media::media.vimeo') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="modal" data-target="#modal_coming_soon">
                                                    <i class="fa fa-vine"></i> {{ trans('core-media::media.vine') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="modal" data-target="#modal_coming_soon">
                                                    <i class="fa fa-youtube-play"></i> {{ trans('core-media::media.daily_motion') }}
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        @endif
                        @if (BMedia::hasPermission('folders.create'))
                            <button class="btn btn-success" data-toggle="modal" data-target="#modal_add_folder">
                                <i class="fa fa-folder"></i> {{ trans('core-media::media.create_folder') }}
                            </button>
                        @endif
                        <button class="btn btn-success js-change-action" data-type="refresh">
                            <i class="fa fa-refresh"></i> {{ trans('core-media::media.refresh') }}
                        </button>

                        @if (config('media.sidebar_display') != 'vertical')
                            <div class="btn-group" role="group">
                                <div class="dropdown">
                                    <button class="btn btn-success dropdown-toggle js-rv-media-change-filter-group" type="button" data-toggle="dropdown">
                                        <i class="fa fa-filter"></i> {{ trans('core-media::media.filter') }} <span class="js-rv-media-filter-current"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="#" class="js-rv-media-change-filter" data-type="filter" data-value="everything">
                                                <i class="fa fa-recycle"></i> {{ trans('core-media::media.everything') }}
                                            </a>
                                        </li>
                                        @if (array_key_exists('image', config('media.mime_types', [])))
                                            <li>
                                                <a href="#" class="js-rv-media-change-filter" data-type="filter" data-value="image">
                                                    <i class="fa fa-file-image-o"></i> {{ trans('core-media::media.image') }}
                                                </a>
                                            </li>
                                        @endif
                                        @if (array_key_exists('video', config('media.mime_types', [])))
                                            <li>
                                                <a href="#" class="js-rv-media-change-filter" data-type="filter" data-value="video">
                                                    <i class="fa fa-file-video-o"></i> {{ trans('core-media::media.video') }}
                                                </a>
                                            </li>
                                        @endif
                                        <li>
                                            <a href="#" class="js-rv-media-change-filter" data-type="filter" data-value="document">
                                                <i class="fa fa-file-o"></i> {{ trans('core-media::media.document') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="btn-group" role="group">
                            <div class="dropdown">
                                <button class="btn btn-success dropdown-toggle js-rv-media-change-filter-group" type="button" data-toggle="dropdown">
                                    <i class="fa fa-eye"></i> {{ trans('core-media::media.view_in') }} <span class="js-rv-media-filter-current"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    @if (config('media.mode') != 'simple')
                                        <li>
                                            <a href="#" class="js-rv-media-change-filter" data-type="view_in" data-value="my_media">
                                                <i class="fa fa-user-secret"></i> {{ trans('core-media::media.my_media') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="js-rv-media-change-filter" data-type="view_in" data-value="public">
                                                <i class="fa fa-globe"></i> {{ trans('core-media::media.public') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="js-rv-media-change-filter" data-type="view_in" data-value="shared">
                                                <i class="fa fa-share-square"></i> {{ trans('core-media::media.shared') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="js-rv-media-change-filter" data-type="view_in"
                                               data-value="shared_with_me">
                                                <i class="fa fa-share-alt-square"></i> {{ trans('core-media::media.shared_with_me') }}
                                            </a>
                                        </li>
                                    @else
                                        <li>
                                            <a href="#" class="js-rv-media-change-filter" data-type="view_in" data-value="my_media">
                                                <i class="fa fa-globe"></i> {{ trans('core-media::media.all_media') }}
                                            </a>
                                        </li>
                                    @endif
                                    <li>
                                        <a href="#" class="js-rv-media-change-filter" data-type="view_in" data-value="trash">
                                            <i class="fa fa-trash"></i> {{ trans('core-media::media.trash') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="js-rv-media-change-filter" data-type="view_in" data-value="recent">
                                            <i class="fa fa-clock-o"></i> {{ trans('core-media::media.recent') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="js-rv-media-change-filter" data-type="view_in" data-value="favorites">
                                            <i class="fa fa-star"></i> {{ trans('core-media::media.favorites') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endif

                        @if (BMedia::hasAnyPermission(['folders.delete', 'files.delete']))
                            <button class="btn btn-danger js-files-action hidden" data-action="empty_trash">
                                <i class="fa fa-trash-o"></i> {{ trans('core-media::media.empty_trash') }}
                            </button>
                        @endif

                    </div>
                    <div class="rv-media-search">
                        <form class="input-search-wrapper" action="" method="GET">
                            <input type="text" class="form-control" placeholder="{{ trans('core-media::media.search_file_and_folder') }}">
                            <button class="btn btn-link" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="rv-media-bottom-header">
                    <div class="rv-media-breadcrumb">
                        <ul class="breadcrumb"></ul>
                    </div>
                    <div class="rv-media-tools">
                        <div class="btn-group" role="group">
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle"
                                        type="button"
                                        data-toggle="dropdown">
                                    {{ trans('core-media::media.sort') }} <i class="fa fa-sort-alpha-desc"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="#"
                                           class="js-rv-media-change-filter"
                                           data-type="sort_by"
                                           data-value="name-asc">
                                            <i class="fa fa-sort-alpha-asc"></i> {{ trans('core-media::media.file_name_asc') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="js-rv-media-change-filter"
                                           data-type="sort_by"
                                           data-value="name-desc">
                                            <i class="fa fa-sort-alpha-desc"></i> {{ trans('core-media::media.file_name_desc') }}
                                        </a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="#"
                                           class="js-rv-media-change-filter"
                                           data-type="sort_by"
                                           data-value="created_at-asc">
                                            <i class="fa fa-sort-numeric-asc"></i> {{ trans('core-media::media.created_date_asc') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="js-rv-media-change-filter"
                                           data-type="sort_by"
                                           data-value="created_at-desc">
                                            <i class="fa fa-sort-numeric-desc"></i> {{ trans('core-media::media.created_date_desc') }}
                                        </a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="#"
                                           class="js-rv-media-change-filter"
                                           data-type="sort_by"
                                           data-value="updated_at-asc">
                                            <i class="fa fa-sort-numeric-asc"></i> {{ trans('core-media::media.uploaded_date_asc') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="js-rv-media-change-filter"
                                           data-type="sort_by"
                                           data-value="updated_at-desc">
                                            <i class="fa fa-sort-numeric-desc"></i> {{ trans('core-media::media.uploaded_date_desc') }}
                                        </a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="#"
                                           class="js-rv-media-change-filter"
                                           data-type="sort_by"
                                           data-value="size-asc">
                                            <i class="fa fa-sort-numeric-asc"></i> {{ trans('core-media::media.size_asc') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="js-rv-media-change-filter"
                                           data-type="sort_by"
                                           data-value="size-desc">
                                            <i class="fa fa-sort-numeric-desc"></i> {{ trans('core-media::media.size_desc') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="dropdown rv-dropdown-actions disabled">
                                <button class="btn btn-default dropdown-toggle"
                                        type="button" data-toggle="dropdown">
                                    {{ trans('core-media::media.actions') }} &nbsp;<i class="fa fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right"></ul>
                            </div>
                        </div>
                        <div class="btn-group js-rv-media-change-view-type" role="group">
                            <button class="btn btn-default" type="button" data-type="tiles">
                                <i class="fa fa-th-large"></i>
                            </button>
                            <button class="btn btn-default" type="button" data-type="list">
                                <i class="fa fa-th-list"></i>
                            </button>
                        </div>
                        <label for="media_details_collapse" class="btn btn-link collapse-panel">
                            <i class="fas fa-sign-out-alt"></i>
                        </label>
                    </div>
                </div>
            </header>

            <main class="rv-media-main">
                <div class="rv-media-items"></div>
                <div class="rv-media-details hidden">
                    <div class="rv-media-thumbnail">
                        <i class="far fa-image"></i>
                    </div>
                    <div class="rv-media-description">
                        <div class="rv-media-name">
                            <p>{{ trans('core-media::media.nothing_is_selected') }}</p>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="rv-media-footer hidden">
                <button type="button" class="btn btn-danger btn-lg js-insert-to-editor">{{ trans('core-media::media.insert') }}</button>
            </footer>
        </div>
        <div class="rv-upload-progress hide-the-pane">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('core-media::media.upload_progress') }}</h3>
                    <a href="javascript:void(0);" class="close-pane">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="panel-body">
                    <ul class="rv-upload-progress-table"></ul>
                </div>
            </div>
        </div>
    </div>

    @include("core-media::partials.modals")
    <button class="hidden js-rv-clipboard-temp"></button>
</div>

@include("core-media::partials.x-templates")