import {MediaConfig} from '../development/App/Config/MediaConfig';
import {Helpers} from '../development/App/Helpers/Helpers';
import {MediaService} from '../development/App/Services/MediaService';
import {MessageService} from '../development/App/Services/MessageService';
import {FolderService} from '../development/App/Services/FolderService';
import {UploadService} from '../development/App/Services/UploadService';
import {ActionsService} from '../development/App/Services/ActionsService';
import {ExternalServices} from '../development/App/Externals/ExternalServices';
import {EditorService} from './integrate';

class MediaManagement {
    constructor() {
        this.MediaService = new MediaService();
        this.UploadService = new UploadService();
        this.FolderService = new FolderService();

        new ExternalServices();

        this.$body = $('body');
    }

    init() {
        Helpers.resetPagination();
        this.setupLayout();

        this.handleMediaList();
        this.changeViewType();
        this.changeFilter();
        this.search();
        this.handleActions();

        this.UploadService.init();

        this.handleModals();
        this.scrollGetMore();
    }

    setupLayout() {
        /**
         * Sidebar
         */
        let $current_filter = $('.js-rv-media-change-filter[data-type="filter"][data-value="' + Helpers.getRequestParams().filter + '"]');

        $current_filter.closest('li')
            .addClass('active')
            .closest('.dropdown').find('.js-rv-media-filter-current').html('(' + $current_filter.html() + ')');

        let $current_view_in = $('.js-rv-media-change-filter[data-type="view_in"][data-value="' + Helpers.getRequestParams().view_in + '"]');

        $current_view_in.closest('li')
            .addClass('active')
            .closest('.dropdown').find('.js-rv-media-filter-current').html('(' + $current_view_in.html() + ')');


        /**
         * append lht js
         */
        $current_filter.closest('button')
            .addClass('active')
            .closest('.menu-media').find('.js-rv-media-filter-current').html('(' + $current_filter.html() + ')');

        $current_view_in.closest('button')
            .addClass('active')
            .closest('.menu-media').find('.js-rv-media-filter-current').html('(' + $current_view_in.html() + ')');
        

        if (Helpers.isUseInModal()) {
            $('.rv-media-footer').removeClass('hidden');
        }

        /**
         * Sort
         */
        $('.js-rv-media-change-filter[data-type="sort_by"][data-value="' + Helpers.getRequestParams().sort_by + '"]')
            .closest('li')
            .addClass('active');

        /**
         * append lht js
         */
         $('.js-rv-media-change-filter[data-type="sort_by"][data-value="' + Helpers.getRequestParams().sort_by + '"]')
            .closest('button')
            .addClass('active');

        /**
         * Details pane
         */
        let $mediaDetailsCheckbox = $('#media_details_collapse');
        $mediaDetailsCheckbox.prop('checked', MediaConfig.hide_details_pane || false);
        setTimeout(() => {
            $('.rv-media-details').removeClass('hidden');
        }, 300);
        $mediaDetailsCheckbox.on('change', function (event) {
            event.preventDefault();
            MediaConfig.hide_details_pane = $(this).is(':checked');
            Helpers.storeConfig();
        });

        $(document).on('click', 'button[data-dismiss-modal]', function() {
            let modal = $(this).data('dismiss-modal');
            $(modal).modal('hide');
        });
    }

    handleMediaList() {
        let _self = this;

        /*Ctrl key in Windows*/
        let ctrl_key = false;

        /*Command key in MAC*/
        let meta_key = false;

        /*Shift key*/
        let shift_key = false;

        $(document).on('keyup keydown', function (e) {
            /*User hold ctrl key*/
            ctrl_key = e.ctrlKey;
            /*User hold command key*/
            meta_key = e.metaKey;
            /*User hold shift key*/
            shift_key = e.shiftKey;
        });

        _self.$body
            .on('click', '.js-media-list-title', function (event) {
                event.preventDefault();
                let $current = $(this);

                if (shift_key) {
                    let firstItem = _.first(Helpers.getSelectedItems());
                    if (firstItem) {
                        let firstIndex = firstItem.index_key;
                        let currentIndex = $current.index();
                        $('.rv-media-items li').each(function (index) {
                            if (index > firstIndex && index <= currentIndex) {
                                $(this).find('input[type=checkbox]').prop('checked', true);
                            }
                        });
                    }
                } else {
                    if (!ctrl_key && !meta_key) {
                        $current.closest('.rv-media-items').find('input[type=checkbox]').prop('checked', false);
                    }
                }

                let $lineCheckBox = $current.find('input[type=checkbox]');
                $lineCheckBox.prop('checked', true);
                ActionsService.handleDropdown();

                _self.MediaService.getFileDetails($current.data());
            })
            .on('dblclick', '.js-media-list-title', function (event) {
                event.preventDefault();
                let data = $(this).data();
                if (data.is_folder === true) {
                    Helpers.resetPagination();
                    _self.FolderService.changeFolder(data.id);
                } else {
                    if (!Helpers.isUseInModal()) {
                        ActionsService.handlePreview();
                    } else if (Helpers.getConfigs().request_params.view_in !== 'trash') {
                        let selectedFiles = Helpers.getSelectedFiles();
                        if (_.size(selectedFiles) > 0) {
                            EditorService.editorSelectFile(selectedFiles);
                        }
                    }
                }
            })
            .on('dblclick', '.js-up-one-level', function (event) {
                event.preventDefault();
                let count = $('.rv-media-breadcrumb .breadcrumb li').length;
                $('.rv-media-breadcrumb .breadcrumb li:nth-child(' + (count - 1) + ') a').trigger('click');
            })
            .on('contextmenu', '.js-context-menu', function (e) {
                if (!$(this).find('input[type=checkbox]').is(':checked')) {
                    $(this).trigger('click');
                }
            })
            .on('click contextmenu', '.rv-media-items', function (e) {
                if (!_.size(e.target.closest('.js-context-menu'))) {
                    $('.rv-media-items input[type="checkbox"]').prop('checked', false);
                    $('.rv-dropdown-actions').addClass('disabled');
                    _self.MediaService.getFileDetails({
                        icon: 'far fa-image',
                        nothing_selected: '',
                    });
                }
            })
        ;
    }

    changeViewType() {
        let _self = this;
        _self.$body.on('click', '.js-rv-media-change-view-type .btn', function (event) {
            event.preventDefault();
            let $current = $(this);
            if ($current.hasClass('active')) {
                return;
            }
            $current.closest('.js-rv-media-change-view-type').find('.btn').removeClass('active');
            $current.addClass('active');

            MediaConfig.request_params.view_type = $current.data('type');

            if ($current.data('type') === 'trash') {
                $(document).find('.js-insert-to-editor').prop('disabled', true);
            } else {
                $(document).find('.js-insert-to-editor').prop('disabled', false);
            }

            Helpers.storeConfig();

            _self.MediaService.getMedia(true, true);
        });
        $('.js-rv-media-change-view-type .btn[data-type="' + Helpers.getRequestParams().view_type + '"]').trigger('click');

        this.bindIntegrateModalEvents();
    }

    changeFilter() {
        let _self = this;
        _self.$body.on('click', '.js-rv-media-change-filter', function (event) {
            event.preventDefault();
            if (!Helpers.isOnAjaxLoading()) {
                let $current = $(this);
                let $parent = $current.closest('ul');
                let data = $current.data();

                MediaConfig.request_params[data.type] = data.value;

                if (data.type === 'view_in') {
                    MediaConfig.request_params.folder_id = 0;
                    if (data.value === 'trash') {
                        $(document).find('.js-insert-to-editor').prop('disabled', true);
                    } else {
                        $(document).find('.js-insert-to-editor').prop('disabled', false);
                    }
                }

                $current.closest('.dropdown').find('.js-rv-media-filter-current').html('(' + $current.html() + ')');

                Helpers.storeConfig();
                MediaService.refreshFilter();

                Helpers.resetPagination();
                _self.MediaService.getMedia(true);

                $parent.find('> li').removeClass('active');
                $current.closest('li').addClass('active');
            }
        });
    }

    search() {
        let _self = this;
        $('.input-search-wrapper input[type="text"]').val(Helpers.getRequestParams().search || '');
        _self.$body.on('submit', '.input-search-wrapper', function (event) {
            event.preventDefault();
            MediaConfig.request_params.search = $(this).find('input[type="text"]').val();

            Helpers.storeConfig();
            Helpers.resetPagination();
            _self.MediaService.getMedia(true);
        })
    }

    handleActions() {
        let _self = this;

        _self.$body
            .on('click', '.rv-media-actions .js-change-action[data-type="refresh"]', function (event) {
                event.preventDefault();

                Helpers.resetPagination();

                let ele_options = typeof window.rvMedia.$el !== 'undefined' ? window.rvMedia.$el.data('rv-media') : undefined;
                if (typeof ele_options !== 'undefined' && ele_options.length > 0 && typeof ele_options[0].selected_file_id !== 'undefined') {
                    _self.MediaService.getMedia(true, true);
                } else
                    _self.MediaService.getMedia(true, false);
            })
            .on('click', '.rv-media-items li.no-items', function (event) {
                event.preventDefault();
                $('.rv-media-header .rv-media-top-header .rv-media-actions .js-dropzone-upload').trigger('click');
            })
            .on('submit', '.form-add-folder', function (event) {
                event.preventDefault();
                let $input = $(this).find('input[type=text]');
                let folderName = $input.val();
                _self.FolderService.create(folderName);
                $input.val('');
            })
            .on('click', '.js-change-folder', function (event) {
                event.preventDefault();
                let folderId = $(this).data('folder');
                Helpers.resetPagination();
                _self.FolderService.changeFolder(folderId);
            })
            .on('click', '.js-files-action', function (event) {
                event.preventDefault();
                ActionsService.handleGlobalAction($(this).data('action'), function (res) {
                    Helpers.resetPagination();
                    _self.MediaService.getMedia(true);
                });
            })
        ;
    }

    handleModals() {
        let _self = this;
        /*Rename files*/
        _self.$body.on('show.bs.modal', '#modal_rename_items', function (event) {
            ActionsService.renderRenameItems();
        });
        _self.$body.on('submit', '#modal_rename_items .form-rename', function (event) {
            event.preventDefault();
            let items = [];
            let $form = $(this);

            $('#modal_rename_items .form-control').each(function () {
                let $current = $(this);
                let data = $current.closest('.form-group').data();
                data.name = $current.val();
                items.push(data);
            });

            ActionsService.processAction({
                action: $form.data('action'),
                selected: items
            }, function (res) {
                if (!res.error) {
                    $form.closest('.modal').modal('hide');
                    _self.MediaService.getMedia(true);
                } else {
                    $('#modal_rename_items .form-group').each(function () {
                        let $current = $(this);
                        if (_.contains(res.data, $current.data('id'))) {
                            $current.addClass('has-error');
                        } else {
                            $current.removeClass('has-error');
                        }
                    });
                }
            });
        });

        /*Delete files*/
        _self.$body.on('submit', '.form-delete-items', function (event) {
            event.preventDefault();
            let items = [];
            let $form = $(this);

            _.each(Helpers.getSelectedItems(), function (value) {
                items.push({
                    id: value.id,
                    is_folder: value.is_folder,
                })
            });

            ActionsService.processAction({
                action: $form.data('action'),
                selected: items
            }, function (res) {
                $form.closest('.modal').modal('hide');
                if (!res.error) {
                    _self.MediaService.getMedia(true);
                }
            });
        });

        /*Empty trash*/
        _self.$body.on('submit', '#modal_empty_trash .rv-form', function (event) {
            event.preventDefault();
            let $form = $(this);

            ActionsService.processAction({
                action: $form.data('action')
            }, function (res) {
                $form.closest('.modal').modal('hide');
                _self.MediaService.getMedia(true);
            });
        });

        /*Share files*/
        let users = [];
        let $shareOption = $('#share_option');
        let $shareToUsers = $('#share_to_users');
        $shareOption.on('change', function (event) {
            event.preventDefault();
            if ($(this).val() === 'user') {
                $shareToUsers.closest('.form-group').removeClass('hidden');
            } else {
                $shareToUsers.closest('.form-group').addClass('hidden');
            }
        }).trigger('change');
        _self.$body
            .on('show.bs.modal', '#modal_share_items', function (event) {
                $shareOption.val('no_share').trigger('change');
                $shareToUsers.val('');

                let selectedItems = Helpers.getSelectedItems();

                if (_.size(selectedItems) !== 1) {

                    let is_public = true;
                    $.each(selectedItems, function (index, el) {
                        if (el.is_public == 0) {
                            is_public = false;
                        }
                    });

                    if (is_public) {
                        $shareOption.val('everyone').trigger('change');
                    } else {
                        $.ajax({
                            url: RV_MEDIA_URL.get_users,
                            type: 'GET',
                            dataType: 'json',
                            success: function (res) {
                                if (!res.error) {
                                    $shareToUsers.html('');
                                    users = res.data;
                                    _.each(users, function (value) {
                                        let option = '<option value="' + value.id + '">' + value.name + '</option>';
                                        $shareToUsers.append(option);
                                    });
                                } else {
                                    MessageService.showMessage('error', res.message, RV_MEDIA_CONFIG.translations.message.error_header);
                                }
                            },
                            error: function (data) {
                                MessageService.handleError(data);
                            }
                        });
                    }
                } else {
                    let selectedItem = _.first(selectedItems);

                    if (selectedItem.is_public) {
                        $shareOption.val('everyone').trigger('change');
                    } else {
                        $.ajax({
                            url: RV_MEDIA_URL.get_shared_users,
                            type: 'GET',
                            data: {
                                share_id: selectedItem.id,
                                is_folder: selectedItem.is_folder,
                            },
                            dataType: 'json',
                            success: function (res) {
                                if (!res.error) {
                                    $shareToUsers.html('');
                                    users = res.data.users;
                                    let totalSelected = 0;
                                    _.each(users, function (value) {
                                        let isSelected = value.is_selected;
                                        if (isSelected) {
                                            totalSelected++;
                                        }
                                        let option = '<option value="' + value.id + '" ' + (isSelected ? 'selected' : '') + '>' + value.name + '</option>';
                                        $shareToUsers.append(option);
                                    });
                                    if (totalSelected > 0) {
                                        $shareOption.val('user').trigger('change');
                                    }
                                } else {
                                    MessageService.showMessage('error', res.message, RV_MEDIA_CONFIG.translations.message.error_header);
                                }
                            },
                            error: function (data) {
                                MessageService.handleError(data);
                            }
                        });
                    }
                }
            })
            .on('submit', '#modal_share_items .rv-form', function (event) {
                event.preventDefault();
                let $form = $(this);

                let items = [];
                _.each(Helpers.getSelectedItems(), function (value) {
                    items.push({
                        id: value.id,
                        is_folder: value.is_folder,
                    })
                });

                ActionsService.processAction({
                    action: $form.data('action'),
                    selected: items,
                    share_option: $shareOption.val(),
                    users: $shareToUsers.val()
                }, function (res) {
                    $form.closest('.modal').modal('hide');
                    _self.MediaService.getMedia(true);
                });
            })
            .on('submit', '#modal_set_focus_point .rv-form', function (event) {
                event.preventDefault();
                let $form = $(this);

                let items = [];
                let selected_items = Helpers.getSelectedItems();
                _.each(selected_items, function (value) {
                    items.push({
                        id: value.id,
                        is_folder: value.is_folder
                    });
                });

                ActionsService.processAction({
                    action: $form.data('action'),
                    selected: items,
                    data_attribute: $('.helper-tool-data-attr').val(),
                    css_bg_position: $('.helper-tool-css3-val').val(),
                    retice_css: $('.helper-tool-reticle-css').val()
                }, function (res) {
                    $form.closest('.modal').modal('hide');
                    _.each(selected_items, function (value) {
                        if (value.id === res.data.id) {
                            $('.js-media-list-title[data-id=' + value.id + ']').data(res.data);
                        }
                    });
                });
            });

        if (MediaConfig.request_params.view_in === 'trash') {
            $(document).find('.js-insert-to-editor').prop('disabled', true);
        } else {
            $(document).find('.js-insert-to-editor').prop('disabled', false);
        }

        this.bindIntegrateModalEvents();
    }

    checkFileTypeSelect(selectedFiles) {
        if (typeof window.rvMedia.$el !== 'undefined') {
            let firstItem = _.first(selectedFiles);
            let ele_options = window.rvMedia.$el.data('rv-media');
            if (typeof ele_options !== 'undefined' && typeof ele_options[0] !== 'undefined' && typeof ele_options[0].file_type !== 'undefined' && firstItem !== 'undefined'
                && firstItem.type !== 'undefined' && !ele_options[0].file_type.match(firstItem.type)) {
                return false;
            }
        }
        return true;
    }

    bindIntegrateModalEvents() {
        let $main_modal = $('#rv_media_modal');
        let _self = this;
        $main_modal.off('click', '.js-insert-to-editor').on('click', '.js-insert-to-editor', function (event) {
            event.preventDefault();
            let selectedFiles = Helpers.getSelectedFiles();
            if (_.size(selectedFiles) > 0) {
                window.rvMedia.options.onSelectFiles(selectedFiles, window.rvMedia.$el);
                if (_self.checkFileTypeSelect(selectedFiles)) {
                    $main_modal.find('.close').trigger('click');
                }
            }
        });

        $main_modal.off('dblclick', '.js-media-list-title').on('dblclick', '.js-media-list-title', function (event) {
            event.preventDefault();
            if (Helpers.getConfigs().request_params.view_in !== 'trash') {
                let selectedFiles = Helpers.getSelectedFiles();
                if (_.size(selectedFiles) > 0) {
                    window.rvMedia.options.onSelectFiles(selectedFiles, window.rvMedia.$el);
                    if (_self.checkFileTypeSelect(selectedFiles)) {
                        $main_modal.find('.close').trigger('click');
                    }
                }
            } else {
                ActionsService.handlePreview();
            }
        });
    }

    static setupSecurity() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }



    //scroll get more media
    scrollGetMore() {
        let _self = this;
        $('.rv-media-main .rv-media-items').bind('DOMMouseScroll mousewheel', function (e) {
            if (e.originalEvent.detail > 0 || e.originalEvent.wheelDelta < 0) {
                if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight - 350) {
                    if (typeof RV_MEDIA_CONFIG.pagination != 'undefined' && RV_MEDIA_CONFIG.pagination.has_more) {
                        _self.MediaService.getMedia(false, false, true);
                    } else {
                        return;
                    }
                }
            }
        });
    }
}

$(document).ready(function () {
    window.rvMedia = window.rvMedia || {};

    MediaManagement.setupSecurity();
    new MediaManagement().init();
});