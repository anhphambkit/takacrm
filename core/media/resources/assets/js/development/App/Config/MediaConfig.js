let MediaConfig = $.parseJSON(localStorage.getItem('MediaConfig')) || {};

let defaultConfig = {
    app_key: '483a0xyzytz1242c0d520426e8ba366c530c3d9dxxx',
    request_params: {
        view_type: 'tiles',
        filter: 'everything',
        view_in: 'my_media',
        search: '',
        sort_by: 'created_at-desc',
        folder_id: 0,
    },
    hide_details_pane: false,
    icons: {
        folder: 'far fa-folder',
    },
    actions_list: {
        basic: [
            {
                icon: 'fa fa-eye',
                name: 'Preview',
                action: 'preview',
                order: 0,
                class: 'rv-action-preview',
            },
        ],
        file: [
            {
                icon: 'fa fa-link',
                name: 'Copy link',
                action: 'copy_link',
                order: 0,
                class: 'rv-action-copy-link',
            },
            {
                icon: 'fa fa-pencil',
                name: 'Rename',
                action: 'rename',
                order: 1,
                class: 'rv-action-rename',
            },
            {
                icon: 'fa fa-copy',
                name: 'Make a copy',
                action: 'make_copy',
                order: 2,
                class: 'rv-action-make-copy',
            },
            {
                icon: 'fa fa-dot-circle-o',
                name: 'Set focus point',
                action: 'set_focus_point',
                order: 3,
                class: 'rv-action-set-focus-point',
            },
        ],
        user: [
            {
                icon: 'fa fa-share-alt',
                name: 'Share',
                action: 'share',
                order: 0,
                class: 'rv-action-share',
            },
            {
                icon: 'fa fa-ban',
                name: 'Remove share',
                action: 'remove_share',
                order: 1,
                class: 'rv-action-remove-share',
            },
            {
                icon: 'fa fa-star',
                name: 'Favorite',
                action: 'favorite',
                order: 2,
                class: 'rv-action-favorite',
            },
            {
                icon: 'fa fa-star-o',
                name: 'Remove favorite',
                action: 'remove_favorite',
                order: 3,
                class: 'rv-action-favorite',
            },
        ],
        other: [
            {
                icon: 'fa fa-download',
                name: 'Download',
                action: 'download',
                order: 0,
                class: 'rv-action-download',
            },
            {
                icon: 'fa fa-trash',
                name: 'Move to trash',
                action: 'trash',
                order: 1,
                class: 'rv-action-trash',
            },
            {
                icon: 'fa fa-eraser',
                name: 'Delete permanently',
                action: 'delete',
                order: 2,
                class: 'rv-action-delete',
            },
            {
                icon: 'fa fa-undo',
                name: 'Restore',
                action: 'restore',
                order: 3,
                class: 'rv-action-restore',
            },
        ],
    },
    denied_download: [
        'youtube',
    ],
};

if (!MediaConfig.app_key || MediaConfig.app_key !== defaultConfig.app_key) {
    MediaConfig = defaultConfig;
}

let RecentItems = $.parseJSON(localStorage.getItem('RecentItems')) || [];

export {MediaConfig, RecentItems};
