import Helper from '@coreComponents/base/js/helper';
import Select2ServerSide from '@coreComponents/base/js/select2-server-side';
import axios from 'axios';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let customerSelectServerSide = new Select2ServerSide();
customerSelectServerSide.wrapperSelect = '#select-customer-list';
customerSelectServerSide.urlAjax = API.SEARCH_AJAX_CUSTOMER;
customerSelectServerSide.placeholder = 'Input name, customer code, email or phone to search';
customerSelectServerSide.formatDataResult = (data) => {
    return formatDataResultSelect2(data);
};

customerSelectServerSide.formatDataSelection = (data) => {
    return formatDataSelectionSelect2(data);
};
customerSelectServerSide.init();

function formatDataResultSelect2(data) {
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
}

function formatDataSelectionSelect2(data) {
    if (data.full_name) {
        let avatar = data.avatar ? data.avatar : '/vendor/core/images/default-avatar.jpg';
        let markup = `<div class='select2-result-data clearfix'>
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