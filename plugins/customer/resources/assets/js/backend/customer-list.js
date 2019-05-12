/*=========================================================================================
    File Name: customer-list.js
    ----------------------------------------------------------------------------------------
    Version: 1.0
    Author: AnhPham
==========================================================================================*/
import Address from '@coreComponents/setting/js/address';
import axios from 'axios';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

(function(window, document, $) {
    let addressNewRegister = new Address();
    addressNewRegister.wrapperProvinceCity = '#select-province_city_code-list';
    addressNewRegister.wrapperDistrict = '#select-district_code-list';
    addressNewRegister.wrapperWard = '#select-ward_code-list';
    addressNewRegister.wrapperMobilePhone = '#mobile_phone';
    addressNewRegister.setInitValue = false;
    addressNewRegister.allowClear = true;
    addressNewRegister.apiRefreshDistricts = API_ADDRESS.REFRESH_DISTRICTS;
    addressNewRegister.apiRefreshWards = API_ADDRESS.REFRESH_WARDS;
    addressNewRegister.init();

    // Re init query list select
    function reInitQueryListSelect(defaultVal, list) {
        // Customer Query select:
        $(`.select-query-customer-list`).empty();
        $(`.select-query-customer-list`).select2({
            placeholder: "Select a query",
            allowClear: true,
            data: list,
        });
        $(`.select-query-customer-list`).val(defaultVal).trigger('change');
    }
    // Format icon
    function iconFormat(item) {
        let avatar = '/vendor/core/images/default-avatar.jpg';
        if (item.avatar !== undefined && item.avatar !== null && item.avatar !== '')
            avatar = item.avatar;
        return `<img class="image-item-select" src="${avatar}" />${item.text}`;
    }
    // Format color:
    function colorFormat(item) {
        let html = `<span class="minicolor-preview">
                       <span class="minicolor-square-box" style="background-color: ${item.code};"></span>
                   </span>
                   <span class="customer-color-attr">${item.text}</span>`;
        return html;
    }

    // Change customer query:
    $(document).on("change", '.select-query-customer-list', function(e) {
        // Do something
        e.preventDefault();
        let currentQuery = $(this).val();
        let data = {
            "query_customer" : currentQuery
        };

        if (currentQuery !== null && currentQuery !== '') {
            let request = axios.get(API_QUERY_LIST.GET_DATA_QUERY, { params: data});

            return request
                .then(function(data){
                    parseNewDataFormSearchConsumerTable(data.data);
                    $('.btn-update-query').show();
                    $('.btn-delete-query').show();
                })
                .catch(function(data){
                    console.log("error", data);
                })
                .then(function(data){

                });
        }
        else {
            clearFormSearchConsumerTable()
            $('.btn-update-query').hide();
            $('.btn-delete-query').hide();
        }
    });

    // Basic date
    $('.pickadate').pickadate({
        format: 'dd/mm/yyyy',
        formatSubmit: 'yyyy-mm-dd',
    });

    // Status select:
    $(`.select-status-list`).select2({
        placeholder: "Select a status",
        allowClear: true,
    });

    // Type data select:
    $(`.type_reference_data-list`).select2({
        placeholder: "Select a type data",
        allowClear: true,
    });

    // Type data select:
    $(`.select-gender-list`).select2({
        placeholder: "Select a gender",
        allowClear: true,
    });

    // Customer group select:
    $(`.customer_group-list`).select2({
        placeholder: "Select a group",
        allowClear: true,
    });

    // Customer source select:
    $(`.customer_source-list`).select2({
        placeholder: "Select a source",
        allowClear: true,
    });

    // Customer Job select:
    $(`.customer_job-list`).select2({
        placeholder: "Select a job",
        allowClear: true,
    });

    // Customer Query select:
    $(`.select-query-customer-list`).select2({
        placeholder: "Select a query",
        allowClear: true,
    });

    // Relation select
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
        allowClear: true,
        data: listCustomerRelation,
        templateResult: colorFormat,
        templateSelection: colorFormat,
        escapeMarkup: function(es) { return es; }
    });

    // Assign User Manage
    let listUser = $.map(USER_LIST, function(item) {
        return {
            id : item.id,
            text: item.text,
            avatar: item.avatar,
        };
    });
    $(`.user_manage_id-list`).empty();
    $(`.user_manage_id-list`).select2({
        placeholder: "Select a user",
        allowClear: true,
        data: listUser,
        templateResult: iconFormat,
        templateSelection: iconFormat,
        escapeMarkup: function(es) { return es; }
    });

    $(`.created_by-list`).empty();
    $(`.created_by-list`).select2({
        placeholder: "Select a user",
        allowClear: true,
        data: listUser,
        templateResult: iconFormat,
        templateSelection: iconFormat,
        escapeMarkup: function(es) { return es; }
    });

    // Init select:
    $('.select-status-list').val("").trigger('change');
    $('.select-gender-list').val("").trigger('change');
    $('.customer_relationship_id-list').val("").trigger('change');
    $('.type_reference_data-list').val("").trigger('change');
    $('.introduce_person_id-list').val("").trigger('change');
    $('.customer_group-list').val("").trigger('change');
    $('.customer_source-list').val("").trigger('change');
    $('.customer_job-list').val("").trigger('change');
    $('.user_manage_id-list').val("").trigger('change');
    $('.created_by-list').val("").trigger('change');
    $('.select-query-customer-list').val("").trigger('change');

    $(document).on('click', '.open-advanced-search', function () {
        $('#advanced-search-panel').collapse('show');
        $('.open-advanced-search').hide();
        $('.close-advanced-search').show();
    });

    $(document).on('click', '.close-advanced-search', function () {
        $('.advanced-form').val("").trigger('change');
        $('#advanced-search-panel').collapse('hide');
        $('.open-advanced-search').show();
        $('.close-advanced-search').hide();
    });

    // Query List:
    $(document).on('click', '.new-query-btn-modal', function (e) {
        e.preventDefault();
        let dataConditions = getDataFormSearchConsumerTable();
        let name = $('#query_name').val();
        let request = axios.post(API_QUERY_LIST.CREATE_QUERY, { 'name' : name, 'conditions' : dataConditions });

        return request
            .then(function(data){
                $('#new-query-modal').modal('hide');
                $('#query_name').val("");
                reInitQueryListSelect(data.data.id, data.data.list);
                Lcms.showNotice('success', "Create customer query success!", Lcms.languages.notices_msg.success);
            })
            .catch(function(data){
                console.log("error", data);
                Lcms.showNotice('error', data.message, Lcms.languages.notices_msg.error);
            })
            .then(function(data){
            });
    });

    // Update Query:
    $(document).on("click", '.btn-update-query', function(e) {
        // Do something
        e.preventDefault();
        let name = $('#select-query-customer :selected').text();
        $('#update_query_name').val(name);
    });

    // Update Query:
    $(document).on("click", '.update-query-btn-modal', function(e) {
        // Do something
        e.preventDefault();
        let currentQuery = $('#select-query-customer').val();
        let dataConditions = getDataFormSearchConsumerTable();
        let name = $('#update_query_name').val();

        $('#update_query_name').val(name);
        let request = axios.post(API_QUERY_LIST.UPDATE_QUERY, { 'query_customer' : currentQuery, 'name' : name, 'conditions' : dataConditions });

        return request
            .then(function(data){
                $('#update-query-modal').modal('hide');
                $('#update_query_name').val("");
                reInitQueryListSelect(currentQuery, data.data);
                Lcms.showNotice('success', "Create customer query success!", Lcms.languages.notices_msg.success);
            })
            .catch(function(data){
                console.log("error", data);
                Lcms.showNotice('error', data.message, Lcms.languages.notices_msg.error);
            })
            .then(function(data){

            });
    });

    // Delete Query:
    $(document).on('click', '#delete-query-customer-entry', function (event) {
        event.preventDefault();
        $('#delete-query-customer-modal').modal('hide');

        let currentQuery = $('#select-query-customer').val();
        let deleteURL = API_QUERY_LIST.DELETE_QUERY + '/' + currentQuery;

        $.ajax({
            url: deleteURL,
            type: 'GET',
            success: function (data) {
                if (data.error) {
                    Lcms.showNotice('error', data.message, Lcms.languages.notices_msg.error);
                } else {
                    reInitQueryListSelect(null, data.list);
                    Lcms.showNotice('success', data.message, Lcms.languages.notices_msg.success);
                }
            },
            error: function (data) {
                Lcms.handleError(data);
            }
        });
    })
})(window, document, jQuery);
