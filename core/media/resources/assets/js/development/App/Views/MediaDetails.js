import {Helpers} from '../Helpers/Helpers';

export class MediaDetails {
    constructor() {
        this.$detailsWrapper = $('.rv-media-main .rv-media-details');

        this.descriptionItemTemplate = '<div class="rv-media-name"><p>__title__</p>__url__</div>';

        this.onlyFields = [
            'name',
            'full_url',
            'size',
            'mime_type',
            'created_at',
            'updated_at',
            'nothing_selected',
        ];

        this.externalTypes = [
            'youtube',
            'vimeo',
            'metacafe',
            'dailymotion',
            'vine',
            'instagram',
        ];
    }

    renderData(data) {
        let _self = this;
        let thumb = data.type === 'image' ? '<img src="' + data.full_url + '" alt="' + data.name + '">' : data.mime_type === 'youtube' ? '<img src="' + data.options.thumb + '" alt="' + data.name + '">' : '<i class="' + data.icon + '"></i>';
        let description = '';
        let useClipboard = false;
        _.forEach(data, function (val, index) {
            if (_.contains(_self.onlyFields, index)) {
                if ((!_.contains(_self.externalTypes, data.type)) || (_.contains(_self.externalTypes, data.type) && !_.contains(['size', 'mime_type'], index))) {
                    description += _self.descriptionItemTemplate
                        .replace(/__title__/gi, RV_MEDIA_CONFIG.translations[index])
                        .replace(/__url__/gi, val ? index === 'full_url' ? '<div class="input-group"><input id="file_details_url" type="text" value="' + val + '" class="form-control"><span class="input-group-btn"><button class="btn btn-default js-btn-copy-to-clipboard" type="button" data-clipboard-target="#file_details_url" title="Copied" data-trigger="click"><img class="clippy" src="' + Helpers.asset('/backend/core/media/images/clippy.svg') + '" width="13" alt="Copy to clipboard"></button></span></div>' : '<span title="' + val + '">' + val + '</span>' : '');
                    if (index === 'full_url') {
                        useClipboard = true;
                    }
                }
            }
        });
        _self.$detailsWrapper.find('.rv-media-thumbnail').html(thumb);
        _self.$detailsWrapper.find('.rv-media-description').html(description);
        if (useClipboard) {
            let clipboard = new Clipboard('.js-btn-copy-to-clipboard');
            $('.js-btn-copy-to-clipboard').tooltip().on('mouseleave', function (event) {
                $(this).tooltip('hide');
            });
        }
    }
}
