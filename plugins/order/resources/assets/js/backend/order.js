import Helper from '@coreComponents/base/js/helper';
import Select2ServerSide from '@coreComponents/base/js/select2-server-side';
import axios from 'axios';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let customerSelectServerSide = new Select2ServerSide();
customerSelectServerSide.wrapperSelect = '#select-customer-list';
customerSelectServerSide.urlAjax = API.SEARCH_AJAX_CUSTOMER;
customerSelectServerSide.placeholder = 'Input name, customer code, email or phone to search';
customerSelectServerSide.formatDataResult = (customerSelectServerSide, data) => {
    return formatDataResultSelect2(customerSelectServerSide, data);
};

customerSelectServerSide.formatDataSelection = (customerSelectServerSide, data) => {
    return formatDataSelectionSelect2(customerSelectServerSide, data);
};
customerSelectServerSide.init();

function formatDataResultSelect2(_this, data) {
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

function formatDataSelectionSelect2(_this, data) {
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

// Order general Info:
$(document).on('change', '#select-customer-list', function (e) {
    e.preventDefault();

    let customerId = $(this).val();
    
    if (customerId) {
        let data = {
            "customer_id" : customerId
        };
        let request = axios.get(API.GET_INFO_WITH_CONTACT_OF_CUSTOMER, { params: data});

        return request
            .then(function(data){
                $('#customer_name').val(data.data.full_name);
                $('#customer_phone').val(data.data.phone);
                $('#customer_email').val(data.data.email);
                $('#customer_address').val(data.data.address_full);

                $(`#select-customer-contact-list`).empty();
                $(`#select-customer-contact-list`).select2({
                    placeholder: "Select a contact",
                    minimumResultsForSearch: Infinity,
                    data: data.data.customer_contacts,
                    templateResult: Helper.iconFormat,
                    templateSelection: Helper.iconFormat,
                    escapeMarkup: function(es) { return es; }
                });
            })
            .catch(function(data){
                console.log("error", data);
            })
            .then(function(data){

            });
    }
});

$(`#select-user-performed-list`).select2({
    placeholder: "Select a user",
    minimumResultsForSearch: Infinity,
    templateResult: Helper.iconFormat,
    templateSelection: Helper.iconFormat,
    escapeMarkup: function(es) { return es; }
});
