<div class="modal fade text-left" id="modal_add_folder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header bg-info white">
            <h4 class="modal-title white" id="myModalLabel11"><i class="la la-tree"></i>{{ trans('core-media::media.create_folder') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-dismiss-modal="#modal_add_folder">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="rv-form form-add-folder">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="{{ trans('core-media::media.folder_name') }}">
                    <button type="submit" class="btn btn-info rv-btn-add-folder">{{ trans('core-media::media.create') }}</button>
                </div>
            </form>
            <div class="modal-notice"></div>
        </div>
    </div>
  </div>
</div>

<div class="modal fade text-left" tabindex="-1" role="dialog" id="modal_share_items" aria-labelledby="myModalLabel18" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="rv-form form-share-items">
                <div class="modal-header bg-info white">
                    <h4 class="modal-title white" id="myModalLabel18"><i class="fab fa-windows"></i> {{ trans('core-media::media.share_title') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('core-media::media.close') }}" data-dismiss-modal="#modal_share_items">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="share-to">
                        <div class="form-group">
                            <label for="share_option">{{ trans('core-media::media.share_to') }}</label>
                            <select id="share_option" class="form-control">
                                <option value="no_share">{{ trans('core-media::media.do_not_share') }}</option>
                                <option value="everyone">{{ trans('core-media::media.share_everyone') }}</option>
                                <option value="user">{{ trans('core-media::media.share_to_specific_users') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="share_to_users">{{ trans('core-media::media.please_select_user') }}</label>
                            <select id="share_to_users"
                                    class="form-control"
                                    multiple="multiple">
                            </select>
                        </div>
                    </div>
                    <div class="modal-notice"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss-modal="#modal_share_items">
                        {{ trans('core-media::media.close') }}
                    </button>
                    <button type="submit" class="btn btn-info">
                        {{ trans('core-media::media.confirm') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal_delete_items">
    <div class="modal-dialog modal-danger" role="document">
        <div class="modal-content">
            <form class="rv-form form-delete-items">
                <div class="modal-header bg-info white">
                    <h4 class="modal-title white" id="myModalLabel18"><i class="fab fa-windows"></i> {{ trans('core-media::media.confirm_delete') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('core-media::media.close') }}" data-dismiss-modal="#modal_delete_items">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ trans('core-media::media.confirm_delete_description') }}</p>
                    <div class="modal-notice"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss-modal="#modal_delete_items">
                        {{ trans('core-media::media.close') }}
                    </button>
                    <button type="submit" class="btn btn-info">
                        {{ trans('core-media::media.confirm') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal_trash_items">
    <div class="modal-dialog modal-danger" role="document">
        <div class="modal-content">
            <form class="rv-form form-delete-items">
                <div class="modal-header bg-info white">
                    <h4 class="modal-title white" id="myModalLabel18"><i class="fab fa-windows"></i> {{ trans('core-media::media.move_to_trash') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('core-media::media.close') }}" data-dismiss-modal="#modal_trash_items">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ trans('core-media::media.confirm_trash') }}</p>
                    <div class="modal-notice"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss-modal="#modal_trash_items">
                        {{ trans('core-media::media.close') }}
                    </button>
                    <button type="submit" class="btn btn-info">
                        {{ trans('core-media::media.confirm') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal_empty_trash">
    <div class="modal-dialog modal-danger" role="document">
        <div class="modal-content">
            <form class="rv-form form-empty-trash">
                <div class="modal-header bg-info white">
                    <h4 class="modal-title white" id="myModalLabel18"><i class="fab fa-windows"></i> {{ trans('core-media::media.empty_trash_title') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('core-media::media.close') }}" data-dismiss-modal="#modal_empty_trash">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ trans('core-media::media.empty_trash_description') }}</p>
                    <div class="modal-notice"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss-modal="#modal_empty_trash">
                        {{ trans('core-media::media.close') }}
                    </button>
                    <button type="submit" class="btn btn-info">
                        {{ trans('core-media::media.confirm') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade text-left" tabindex="-1" role="dialog" id="modal_rename_items" aria-labelledby="myModalLabel18" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="rv-form form-rename">
                <div class="modal-header bg-info white">
                    <h4 class="modal-title white" id="myModalLabel18"><i class="fab fa-windows"></i> {{ trans('core-media::media.rename') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('core-media::media.close') }}" data-dismiss-modal="#modal_rename_items">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="rename-items"></div>
                    <div class="modal-notice"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss-modal="#modal_rename_items">
                        {{ trans('core-media::media.close') }}
                    </button>
                    <button type="submit" class="btn btn-info">
                        {{ trans('core-media::media.save_changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal_set_focus_point" aria-labelledby="myModalLabel18" aria-hidden="true">
    <div class="modal-dialog modal-danger modal-lg" role="document">
        <div class="modal-content">
            <form class="rv-form form-set-focus-point">
                <div class="modal-header bg-info white">
                    <h4 class="modal-title white" id="myModalLabel18"><i class="fab fa-windows"></i> {{ trans('core-media::media.set_focus_point') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('core-media::media.close') }}" data-dismiss-modal="#modal_set_focus_point">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 10px 0 0 10px;">
                    <div style="position: relative;">
                        <div class="focuspoint-frames" style="min-height: 400px;"></div>

                        <div class="focuspoint-info">
                            <div class="helper-tool">
                                <p>{{ trans('core-media::media.set_focus_description') }}</p>
                                <div class="helper-tool-target">
                                    <img class="helper-tool-img">
                                    <img class="reticle" src="{{ url('backend/core/media/packages/focuspoint/images/focuspoint-target.png') }}">
                                    <img class="target-overlay">
                                </div>
                                <p>
                                    <label for="data-attr">{{ trans('core-media::media.focus_data_attribute') }}:</label>
                                    <input class='helper-tool-data-attr' id="data-attr" name="data-attr" type='text' placeholder='data-focus-x="0" data-focus-y="0" '>
                                </p>
                                <p>
                                    <label for="css3-val">{{ trans('core-media::media.focus_css_background') }}:</label>
                                    <input class='helper-tool-css3-val' id="css3-val" name="css3-val" type='text' placeholder='background-position:'>
                                </p>
                                <p>
                                    <input type="hidden" class="helper-tool-reticle-css">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss-modal="#modal_set_focus_point">
                        {{ trans('core-media::media.close') }}
                    </button>
                    <button type="submit" class="btn btn-info">
                        {{ trans('core-media::media.save_changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>




    <div class="modal fade" tabindex="-1" role="dialog" id="modal_coming_soon">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss-modal="#modal_coming_soon" aria-label="{{ trans('core-media::media.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="fa fa-windows"></i> {{ trans('core-media::media.comming_soon') }}
                    </h4>
                </div>
                <div class="modal-body">
                    <p>These features are on development</p>
                    <div class="modal-notice"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_add_from_youtube">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss-modal="#modal_add_from_youtube" aria-label="{{ trans('core-media::media.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="fa fa-windows"></i> {{ trans('core-media::media.add_from_youtube') }}
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group">
                            <label class="input-group-addon custom-checkbox">
                                <input type="checkbox">
                                <span class="pull-left"></span>
                                <small>{{ trans('core-media::media.playlist') }}</small>
                            </label>
                            <input type="text" class="form-control rv-youtube-url" placeholder="https://">
                            <div class="input-group-btn">
                                <button class="btn btn-success rv-btn-add-youtube-url" type="button">{{ trans('core-media::media.add_url') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-notice"></div>
                </div>
            </div>
        </div>
    </div>
    
    
