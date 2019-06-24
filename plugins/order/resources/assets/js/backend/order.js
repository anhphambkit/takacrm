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
    return Helper.formatDataResultCustomerSelect2(customerSelectServerSide, data);
};

customerSelectServerSide.formatDataSelection = (customerSelectServerSide, data) => {
    return Helper.formatDataSelectionCustomerSelect2(customerSelectServerSide, data);
};

customerSelectServerSide.formatInitDataResult = (customerSelectServerSide, data) => {
    return Helper.formatInitDataResultCustomerSelect2(customerSelectServerSide, data);
};

customerSelectServerSide.formatInitDataSelection = (customerSelectServerSide, data) => {
    return Helper.formatInitDataSelectionCustomerSelect2(customerSelectServerSide, data);
};
customerSelectServerSide.init();

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
                $('#customer_code').val(data.data.customer_code);
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

// Init customer contact select:
$(`#select-customer-contact-list`).select2({
    placeholder: "Select a contact",
    minimumResultsForSearch: Infinity,
    templateResult: Helper.iconInitFormat,
    templateSelection: Helper.iconInitFormat,
    escapeMarkup: function(es) { return es; }
});
let customerContactDefault = $('#select-customer-contact-list').data('value');
$('#select-customer-contact-list').val(customerContactDefault).trigger('change');

$(document).on('click', '.btn-add-order-product', function (e) {
    e.preventDefault();
    let rowProduct = `<tr class="row-product-order row-product-order-${index}" id="row-product-order-${index}" data-product-index="${index}">
                       <td scope="row">${index}</td>
                       <td class="product-basic-info product-basic-info-${index}" id="product-basic-info-${index}">
                            <div class="input-group select-order-product select-order-product-${index}" data-product-index="${index}">
                               <select class='custom-select select2-placeholder-single form-control product-order-list product-order-list-${index}' name='order_products[${index}][id]' data-product-index="${index}">
                               </select>
                               <div class="input-group-prepend">
                                   <button class="btn btn-outline-secondary btn-add-short-description-for-product btn-add-short-description-for-product-${index}" type="button" data-toggle="collapse" data-target="#collapse-product-short-description-${index}" aria-expanded="false" aria-controls="collapse-product-short-description-${index}">
                                       <i class="fa fa-plus"></i>
                                   </button>
                               </div>
                            </div>
                            <div class="collapse collapse-product-short-description" id="collapse-product-short-description-${index}">
                                <textarea class="product-short-description form-control product-short-description-${index}" placeholder="Note" id="product-short-description-${index}" name="order_products[${index}][short_description]"></textarea>
                            </div>
                       </td>
                       <td>
                            <input type="text" class="form-control product-sku product-sku-${index}" data-product-index="${index}" readonly="readonly" id="product-sku-${index}" placeholder="SKU" name="order_products[${index}][sku]" />
                       </td>
                       <td>
                           <input type="text" class="form-control product-unit product-unit-${index}" data-product-index="${index}" readonly="readonly" id="product-unit-${index}" placeholder="Unit" name="order_products[${index}][unit_name]" />
                       </td>
                       <td>
                            <input type="text" class="form-control product-quantity product-quantity-${index}" data-product-index="${index}" id="product-quantity-${index}" placeholder="Quantity" name="order_products[${index}][quantity]" />
                       </td>
                       <td>
                           <input type="text" class="form-control product-price product-retail-price-${index}" data-product-index="${index}" id="product-retail-price-${index}" placeholder="Price" name="order_products[${index}][retail_price]" />
                       </td>
                       <td>
                           <input type="text" class="form-control product-vat product-vat-${index}" data-product-index="${index}" id="product-vat-${index}" placeholder="VAT" name="order_products[${index}][vat]" />
                       </td>
                       <td>
                            <input type="text" class="form-control product-discount-percent product-discount-percent-${index}" data-product-index="${index}" id="product-discount-percent-${index}" placeholder="Discount percent" name="order_products[${index}][discount_percent]" />
                       </td>
                       <td>
                            <input type="text" class="form-control product-discount product-discount-${index}" data-product-index="${index}" id="product-discount-${index}" placeholder="Discount" name="order_products[${index}][discount]" />
                       </td>
                       <td>
                            <input type="text" class="form-control product-total-price product-total-price-${index}" data-product-index="${index}" readonly="readonly" id="product-total-price-${index}" placeholder="Total price" name="order_products[${index}][total_price]" />
                       </td>
                       <td>
                           <button type="button" class="btn btn-sm btn-danger btn-delete-row-product btn-delete-row-product-${index}" id="btn-delete-row-product-${index}" data-product-index="${index}"><i class="fa fa-trash"></i></button>
                       </td>
                   </tr>`;
    $('.table-body-order-product').append(rowProduct);
    initSelectProduct(index);
    index++;
})

// Products List
let listProducts = $.map(PRODUCTS, function(item) {
    return {
        id : item.id,
        sku: item.sku,
        text: item.name,
        retail_price: item.retail_price,
        vat_percent: item.vat,
        discount_percent: item.discount_percent,
        image_feature: item.image_feature,
        category_name: item.category_name,
        short_description: item.short_description,
        unit: item.unit_name,
    };
});

$(`.product-order-list`).each(function () {
    let defaultValue = $(this).data('value');
    $(this).select2({
        placeholder: "Select a product",
        minimumResultsForSearch: Infinity,
        templateResult: Helper.formatInitProductOption,
        templateSelection: Helper.formatInitProductSelectedOption,
        escapeMarkup: function(es) { return es; }
    });
    $(this).val(defaultValue).trigger('change');
});

function initSelectProduct(index = 1) {
    $(`.product-order-list.product-order-list-${index}`).empty();
    $(`.product-order-list.product-order-list-${index}`).select2({
        placeholder: "Select a product",
        minimumResultsForSearch: Infinity,
        data: listProducts,
        templateResult: Helper.formatProductOption,
        templateSelection: Helper.formatProductSelectedOption,
        escapeMarkup: function(es) { return es; }
    });

    $(`.product-order-list.product-order-list-${index}`).trigger('change');
}

$(document).on('change', '.product-order-list', function (e) {
    e.preventDefault();
    let selectedIndex = $(this).parents('.select-order-product').data('product-index');
    let productId = $(this).val();
    let data = {
        "product_id" : productId
    };
    let request = axios.get(API.GET_INFO_PRICE_OF_PRODUCT, { params: data});

    return request
        .then(function(data){
            $(`#product-sku-${selectedIndex}`).val(data.data.sku);
            $(`#product-short-description-${selectedIndex}`).val(data.data.short_description);
            $(`#product-unit-${selectedIndex}`).val(data.data.unit_name);
            $(`#product-quantity-${selectedIndex}`).val(1);
            $(`#product-retail-price-${selectedIndex}`).val(data.data.retail_price);
            $(`#product-vat-${selectedIndex}`).val(data.data.vat);
            $(`#product-discount-percent-${selectedIndex}`).val(data.data.discount_percent);
            calculatorTotalPriceRowProduct(selectedIndex, true);
        })
        .catch(function(data){
            console.log("error", data);
        })
        .then(function(data){

        });
});

$(document).on('change', '.product-quantity, .product-vat, .product-price, .product-discount-percent', function (e) {
    e.preventDefault();
    let selectedIndex = $(this).data('product-index');
    calculatorTotalPriceRowProduct(selectedIndex, true);
});

$(document).on('change', '.product-discount', function (e) {
    e.preventDefault();
    let selectedIndex = $(this).data('product-index');
    calculatorTotalPriceRowProduct(selectedIndex, false);
});

$(document).on('click', '.btn-delete-row-product', function (e) {
    e.preventDefault();
    let selectedIndex = $(this).data('product-index');
    $(`#row-product-order-${selectedIndex}`).remove();
    calculatorSubTotalPriceOrder();
});

function calculatorTotalPriceRowProduct(index, isChangeDiscountPercent = true) {
    let quantity = parseInt($(`#product-quantity-${index}`).val()) || 0;
    let retailPrice = parseInt($(`#product-retail-price-${index}`).val()) || 0;
    let vatPercent = parseFloat($(`#product-vat-${index}`).val()) || 0;
    let discountPercent = parseFloat($(`#product-discount-percent-${index}`).val()) || 0;
    let priceAfterVat = quantity*retailPrice*((100+vatPercent)/100) || 0;
    let discountPrice = priceAfterVat*(discountPercent/100) || 0;
    if (isChangeDiscountPercent) {
        $(`#product-discount-${index}`).val(Math.round(discountPrice));
    }
    else {
        $(`#product-discount-percent-${index}`).val(0);
        discountPrice = parseInt($(`#product-discount-${index}`).val()) || 0;
    }
    let totalPrice = priceAfterVat - discountPrice;
    $(`#product-total-price-${index}`).val(Math.round(totalPrice));
    calculatorSubTotalPriceOrder();
};

function calculatorSubTotalPriceOrder() {
    let subTotal = 0;
    $('.product-total-price').each(function () {
         subTotal += parseInt($(this).val());
    });
    $('#sub_total').val(subTotal);
    reCalculatorFeeOrder();
}

$(document).on('click', '.btn-add-condition-order', function (e) {
    e.preventDefault();
    let conditionHtml = `<div class="row row-condition-order row-condition-order-${indexConditions}" id="row-condition-order-${indexConditions}" data-condition-index="${indexConditions}">
                            <div class="form-group col-md-1 mb-2">
                                <label for="order-condition-${indexConditions}">${indexConditions}</label>
                            </div>
                            <div class="form-group col-md-10 mb-2">
                               <textarea rows=2 class="form-control order-condition order-condition-${indexConditions}" data-condition-index="${indexConditions}" id="order-condition-${indexConditions}" placeholder="Conditions" name="order_conditions[${indexConditions}]"></textarea>
                            </div>
                            <div class="form-group col-md-1 mb-2 action-condition-order">
                                <button type="button" class="btn btn-sm btn-danger btn-delete-condition-order btn-delete-condition-order-${indexConditions}" id="btn-delete-condition-order-${indexConditions}" data-order-index="${indexConditions}"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>`;
    $('.condition-order-area').append(conditionHtml);
    indexConditions++;
});

$(document).on('click', '.btn-delete-condition-order', function (e) {
    e.preventDefault();
    let selectedIndex = $(this).parents('.row-condition-order').data('condition-index');
    $(`#row-condition-order-${selectedIndex}`).remove();
});

// Total Price
$(document).on('change', '.order-fee-percent', function (e) {
    e.preventDefault();
    let subTotal = parseInt($(`#sub_total`).val()) || 0;
    let elementName = $(this).data('fee-name');
    let feePercent = parseFloat($(this).val()) || 0;
    let isDiscountAfterTax = $(`#is_discount_after_tax`).prop('checked');
    let feePrice = parseInt($(`#fees_${elementName}`).val());
    if (feePercent)
        feePrice = subTotal*(feePercent/100) || 0;

    if (isDiscountAfterTax) {
        if (elementName === 'ship') {
            let feeVat = parseInt($('#fees_vat').val()) || 0;
            feePrice = (subTotal + feeVat)*(feePercent/100) || 0;
        }
        else if (elementName === 'vat') {
            let feeShipPercent = parseInt($('#fees_ship_percent').val()) || 0;
            let feeShipPrice = parseInt($('#fees_ship').val()) || 0;
            if (feeShipPercent)
                feeShipPrice = (subTotal + feePrice)*(feeShipPercent/100) || 0;
            $('#fees_ship').val(Math.round(feeShipPrice));
        }
    }
    else {
        if (elementName === 'vat') {
            let feeShip = parseInt($('#fees_ship').val()) || 0;
            feePrice = (subTotal - feeShip)*(feePercent/100) || 0;
        }
        else if (elementName === 'ship') {
            let feeVatPercent = parseInt($('#fees_vat_percent').val()) || 0;
            let feeVatPrice = parseInt($('#fees_vat').val()) || 0;
            if (feeVatPercent)
                feeVatPrice = (subTotal - feePrice)*(feeVatPercent/100) || 0;
            $('#fees_vat').val(Math.round(feeVatPrice));
        }
    }
    $(`#fees_${elementName}`).val(Math.round(feePrice));
    calculatorTotalPriceOrder();
});

$(document).on('change', '.order-fee-price', function (e) {
    e.preventDefault();
    let subTotal = parseInt($(`#sub_total`).val()) || 0;
    let elementName = $(this).data('fee-name');
    $(`#fees_${elementName}_percent`).val(0);
    let isDiscountAfterTax = $(`#is_discount_after_tax`).prop('checked');
    let feePrice = parseInt($(this).val()) || 0;
    if (isDiscountAfterTax) {
       if (elementName === 'vat') {
            let feeShipPercent = parseInt($('#fees_ship_percent').val()) || 0;
            let feeShipPrice = parseInt($('#fees_ship').val()) || 0;
            if (feeShipPercent)
                feeShipPrice = (subTotal + feePrice)*(feeShipPercent/100) || 0;
            $('#fees_ship').val(Math.round(feeShipPrice));
        }
    }
    else {
        if (elementName === 'ship') {
            let feeVatPercent = parseInt($('#fees_vat_percent').val()) || 0;
            let feeVatPrice = parseInt($('#fees_vat').val()) || 0;
            if (feeVatPercent)
                feeVatPrice = (subTotal - feePrice)*(feeVatPercent/100) || 0;
            $('#fees_vat').val(Math.round(feeVatPrice));
        }
    }
    calculatorTotalPriceOrder();
});

$(document).on('click', '#is_discount_after_tax', function (e) {
    reCalculatorShipFeeAndVatFee();
    calculatorTotalPriceOrder();
});

function calculatorTotalPriceOrder() {
    let shipPrice = parseInt($(`#fees_ship`).val()) || 0;
    let vatPrice = parseInt($(`#fees_vat`).val()) || 0;
    let shippingPrice = parseInt($(`#fees_shipping`).val()) || 0;
    let installationFee = parseInt($(`#fees_installation`).val()) || 0;
    let subTotal = parseInt($(`#sub_total`).val()) || 0;
    let totalOrder = subTotal - shipPrice +  vatPrice + shippingPrice + installationFee;
    $(`#total_order`).val(Math.round(totalOrder));
};

function reCalculatorFeeOrder() {
    let subTotal = parseInt($(`#sub_total`).val()) || 0;
    $('.order-fee-percent').each(function () {
        let elementName = $(this).data('fee-name');
        if (elementName !== 'vat' && elementName !== 'ship') {
            let feePercent = parseFloat($(this).val()) || 0;
            let feePrice = parseInt($(`#fees_${elementName}`).val()) || 0;
            if (feePercent)
                feePrice = subTotal*(feePercent/100) || 0;
            $(`#fees_${elementName}`).val(Math.round(feePrice));
        }
        else {
            reCalculatorShipFeeAndVatFee();
        }
    });
    calculatorTotalPriceOrder();
}

function reCalculatorShipFeeAndVatFee() {
    let subTotal = parseInt($(`#sub_total`).val()) || 0;
    let isDiscountAfterTax = $(`#is_discount_after_tax`).prop('checked');
    if (isDiscountAfterTax) {
        let feeVatPercent = parseInt($('#fees_vat_percent').val()) || 0;
        let feeVatPrice = parseInt($('#fees_vat').val()) || 0;
        if (feeVatPercent)
            feeVatPrice = subTotal*(feeVatPercent/100) || 0;
        $('#fees_vat').val(Math.round(feeVatPrice));

        let feeShipPercent = parseInt($('#fees_ship_percent').val()) || 0;
        let feeShipPrice = parseInt($('#fees_ship').val()) || 0;
        if (feeShipPercent)
            feeShipPrice = (subTotal + feeVatPrice)*(feeShipPercent/100) || 0;
        $('#fees_ship').val(Math.round(feeShipPrice));
    }
    else {
        let feeShipPercent = parseInt($('#fees_ship_percent').val()) || 0;
        let feeShipPrice = parseInt($('#fees_ship').val()) || 0;
        if (feeShipPercent)
            feeShipPrice = subTotal*(feeShipPercent/100) || 0;
        $('#fees_ship').val(Math.round(feeShipPrice));

        let feeVatPercent = parseInt($('#fees_vat_percent').val()) || 0;
        let feeVatPrice = parseInt($('#fees_vat').val()) || 0;
        if (feeVatPercent)
            feeVatPrice = (subTotal - feeShipPrice)*(feeVatPercent/100) || 0;
        $('#fees_vat').val(Math.round(feeVatPrice));
    }
}