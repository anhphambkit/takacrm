/*=========================================================================================
    File Name: detail-customer.js
    ----------------------------------------------------------------------------------------
    Version: 1.0
    Author: AnhPham
==========================================================================================*/
import axios from 'axios';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

(function(window, document, $) {
    'use strict';
    // Table Customer Introduce Person:
    $(document).ready(function() {
        $('#customer-introduce-person-table').DataTable({
                "responsive": true,
                "processing": true,
                "serverSide": false,
                "searching": true,
                "autoWidth": true,
            }
        );
    });

    // Change Relation:
    let firstLoad = true;
    $(document).on("change", '.customer_relationship_id-list', function(e) {
        // Do something
        e.preventDefault();
        if (!firstLoad) {
            let customerRelation = $(this).val();
            let customerId = CUSTOMER_ID;

            let request = axios.post(API.UPDATE_CUSTOMER, { 'customer_id' : customerId, 'customer_relationship_id' : customerRelation });

            return request
                .then(function(data){
                    Lcms.showNotice('success', "Update customer success!", Lcms.languages.notices_msg.success);
                })
                .catch(function(data){
                    console.log("error", data);
                    Lcms.showNotice('error', data.message, Lcms.languages.notices_msg.error);
                })
                .then(function(data){

                });
        }
        firstLoad = false;
    });

    // Format color:
    function colorFormat(item) {
        let html = `<span class="minicolor-preview">
                       <span class="minicolor-square-box" style="background-color: ${item.code};"></span>
                   </span>
                   <span class="customer-color-attr">${item.text}</span>`;
        return html;
    }

    let listCustomerRelation = $.map(CUSTOMER_RELATION_LIST, function(item) {
        return {
            id : item.id,
            text: item.name,
            code: item.color_code,
        };
    });

    $(`.customer_relationship_id-list`).empty();
    $(`.customer_relationship_id-list`).select2({
        placeholder: "Select a relation",
        minimumResultsForSearch: Infinity,
        data: listCustomerRelation,
        templateResult: colorFormat,
        templateSelection: colorFormat,
        escapeMarkup: function(es) { return es; }
    });

    $('.customer_relationship_id-list').val(CUSTOMER_RELATION_ID).trigger('change');

})(window, document, jQuery);