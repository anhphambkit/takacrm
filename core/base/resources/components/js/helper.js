export default {
    trans(key, replace = {})
    {
        let arr = new Array();
        arr.push(key);
        let translation = arr.reduce((t, i) => t[i] || null, window.translations);
        translation = translation != null ? translation:key;
        for (var placeholder in replace) {
            translation = translation.replace(`:${placeholder}`, replace[placeholder]);
        }

        return translation;
    },

    renderImageWithNameTable(img, name, link = "#") {
        return `<div class="media">
                        <div class="media-left pr-1"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="${img}"
                                 alt="avatar" class="avatar-table"></span></div>
                        <div class="media-body media-middle">
                            <a class="media-heading name" href="${link}">${name}</a>
                        </div>
                    </div>`;
    },

    renderColorNameTable(colorCode, name) {
        return `<span class="minicolor-preview">
                        <span class="minicolor-square-box" style="background-color: ${colorCode};"></span>
                        </span>
                   <span class="customer-color-attr">${name}</span>`;
    },

    renderStatusBasic(status) {
        let statusClass = 'badge-success';
        let statusName = 'Active';
        if (!status) {
            statusClass = 'badge-secondary';
            statusName = 'De-active';
        }
        return `<div class="badge ${statusClass}">${statusName}</div>`;
    },

    renderActionsTableBasic(linkView, linkEdit, linkDelete) {
        return `<div class="table-actions row">
                        <a href="${linkView}" class="btn btn-table-actions btn-icon btn-pure info mr-1 tip" data-toggle="tooltip" data-placement="top" title="View detail"">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="${linkEdit}" class="btn btn-table-actions btn-icon btn-pure success mr-1 tip" data-toggle="tooltip" data-placement="top" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-table-actions btn-icon btn-pure danger mr-1 deleteDialog tip" data-toggle="modal" data-section="${linkDelete}" role="button">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </div>`;
    },

    // Format icon
    iconFormat(item, keyValue = 'text') {
        let avatar = '/vendor/core/images/default-avatar.jpg';
        if (item.avatar)
            avatar = item.avatar;
        return `<img class="image-item-select" src="${avatar}" />${item.full_name || item[keyValue]}`;
    },

    // Format color:
    colorFormat(item) {
        let html = `<span class="minicolor-preview">
                           <span class="minicolor-square-box" style="background-color: ${item.code};"></span>
                       </span>
                       <span class="customer-color-attr">${item.text}</span>`;
        return html;
    },

    // Format product option
    formatProductOption(item) {
        if (!item.id) { return item.text; }

        let avatar = item.image_feature ? item.image_feature : '/vendor/core/images/default-avatar.jpg';
        let markup = `<div class='select2-result-data clearfix'>
                    <div class='select2-result-data__avatar select2-image'>
                        <img class="select2-image-custom" src='${avatar}' />
                    </div>
                    <div class='select2-result-data__meta'>
                        <div class='select2-result-data__title select2-title'>${item.text}</div>`;

        if (item.category_name) {
            markup += `<div class='select2-result-data__title option-info-select select2-category'>
                        <span class="icon-select-info icon-category-select">
                            <i class="far fa-folder-open"></i>
                        </span>
                        <span class="content-info-select content-select-category">
                            ${item.category_name}
                        </span>
                    </div>`;
        }
        if (item.retail_price) {
            markup += `<div class='select2-result-data__title option-info-select select2-retail-price'>
                        <span class="icon-select-info icon-retail-price-select">
                            <i class="far fa-money-bill-alt"></i>
                        </span>
                        <span class="content-info-select content-select-retail-price">
                            ${item.retail_price}
                        </span>
                    </div>`;
        }

        markup += `</div></div>`;
        return markup;
    },

    // Format product option
    formatProductSelectedOption(item) {
        if (!item.id) { return item.text; }

        let avatar = item.image_feature ? item.image_feature : '/vendor/core/images/default-avatar.jpg';

        let markup = `<div class='select2-result-data selected-order-product clearfix' data-name="${item.text}" data-id="${item.id}" data-sku="${item.sku}" data-image="${item.image_feature}" 
                        data-retail-price="${item.retail_price}" data-category="${item.category_name}" data-unit="${item.unit}" data-short-description="${item.short_description}">
                    <div class='select2-result-data__avatar select2-image select-selection'>
                        <img class="select2-image-custom select2-image-selection" src='${avatar}' />
                    </div>
                    <div class='select2-result-data__meta select-selection'>
                        <div class='select2-result-data__title select2-title'>${item.text}</div>
                    </div>
                </div>`;
        return markup ;
    },

    // Format product option
    formatInitProductOption(item) {
        if (!item.id) { return item.text; }

        let avatar = $(item.element).data('image') ? $(item.element).data('image') : '/vendor/core/images/default-avatar.jpg';
        let markup = `<div class='select2-result-data clearfix'>
                    <div class='select2-result-data__avatar select2-image'>
                        <img class="select2-image-custom" src='${avatar}' />
                    </div>
                    <div class='select2-result-data__meta'>
                        <div class='select2-result-data__title select2-title'>${item.text}</div>`;

        if ($(item.element).data('category')) {
            markup += `<div class='select2-result-data__title option-info-select select2-category'>
                        <span class="icon-select-info icon-category-select">
                            <i class="far fa-folder-open"></i>
                        </span>
                        <span class="content-info-select content-select-category">
                            ${$(item.element).data('category')}
                        </span>
                    </div>`;
        }
        if ($(item.element).data('retail-price')) {
            markup += `<div class='select2-result-data__title option-info-select select2-retail-price'>
                        <span class="icon-select-info icon-retail-price-select">
                            <i class="far fa-money-bill-alt"></i>
                        </span>
                        <span class="content-info-select content-select-retail-price">
                            ${$(item.element).data('retail-price')}
                        </span>
                    </div>`;
        }

        markup += `</div></div>`;
        return markup;
    },

    // Format product option
    formatInitProductSelectedOption(item) {
        if (!item.id) { return item.text; }

        let avatar = $(item.element).data('image') ? $(item.element).data('image') : '/vendor/core/images/default-avatar.jpg';

        let markup = `<div class='select2-result-data clearfix' data-name="${item.text}" data-id="${item.id}" data-short-description="${$(item.element).data('short-description')}" data-sku="${$(item.element).data('sku')}" data-image="${$(item.element).data('image')}" data-retail-price="${$(item.element).data('retail-price')}" data-category="${$(item.element).data('category')}">
                    <div class='select2-result-data__avatar select2-image select-selection'>
                        <img class="select2-image-custom select2-image-selection" src='${avatar}' />
                    </div>
                    <div class='select2-result-data__meta select-selection'>
                        <div class='select2-result-data__title select2-title'>${item.text}</div>
                    </div>
                </div>`;
        return markup ;
    },

    /**
     *
     * @param _this
     * @param data
     * @returns {*}
     */
    formatDataResultCustomerSelect2(_this, data) {
        if (data.loading) {
            return data.text;
        }
        let avatar = data.avatar ? data.avatar : '/vendor/core/images/default-avatar.jpg';
        let markup = `<div class='select2-result-data clearfix'>
                    <div class='select2-result-data__avatar select2-image'>
                        <img class="select2-image-custom" src='${avatar}' />
                    </div>
                    <div class='select2-result-data__meta'>
                        <div class='select2-result-data__title select2-title'>${data.full_name} <span class="select2-option-info">(${data.customer_code})</span></div>`;

        if (data.email) {
            markup += `<div class='select2-result-data__title select2-email'>
                        <span class="icon-select-info icon-email-select">
                            <i class="far fa-envelope"></i>
                        </span>
                        <span class="content-info-select content-select-email">
                            ${data.email}
                        </span>
                    </div>`;
        }
        if (data.phone) {
            markup += `<div class='select2-result-data__title select2-phone'>
                        <span class="icon-select-info icon-phone-select">
                            <i class="fas fa-mobile-alt"></i>
                        </span>
                        <span class="content-info-select content-select-phone">
                            ${data.phone}
                        </span>
                    </div>`;
        }

        markup += `</div></div>`;
        return markup;
    },

    /**
     *
     * @param _this
     * @param data
     * @returns {*}
     */
    formatDataSelectionCustomerSelect2(_this, data) {
        if (data.full_name) {
            let avatar = data.avatar ? data.avatar : '/vendor/core/images/default-avatar.jpg';
            let markup = `<div class='select2-result-data clearfix' data-customer-full-name="${data.full_name}" data-customer-phone="${data.phone}" data-customer-email="${data.email}">
                    <div class='select2-result-data__avatar select2-image select-selection'>
                        <img class="select2-image-custom select2-image-selection" src='${avatar}' />
                    </div>
                    <div class='select2-result-data__meta select-selection'>
                        <div class='select2-result-data__title select2-title'>${data.full_name} <span class="select2-option-info">(${data.customer_code})</span></div>
                    </div>
                </div>`;
            return markup ;
        }
        return data.text;
    }
}