/*=========================================================================================
    File Name: customer.js
    ----------------------------------------------------------------------------------------
    Version: 1.0
    Author: AnhPham
==========================================================================================*/
import Address from '@coreComponents/base/js/address';
import axios from 'axios';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

(function(window, document, $) {
    'use strict';

    /*******	Pick-a-date Picker	*****/
    // Basic date
    $('.pickadate').pickadate({
        format: 'dd/mm/yyyy',
        formatSubmit: 'yyyy-mm-dd',
    });

    let addressNewRegister = new Address();
    addressNewRegister.wrapperProvinceCity = '#select-province_city_code-list';
    addressNewRegister.wrapperDistrict = '#select-district_code-list';
    addressNewRegister.wrapperWard = '#select-ward_code-list';
    addressNewRegister.wrapperMobilePhone = '#mobile_phone';
    addressNewRegister.apiRefreshDistricts = API_ADDRESS.REFRESH_DISTRICTS;
    addressNewRegister.apiRefreshWards = API_ADDRESS.REFRESH_WARDS;
    addressNewRegister.init(DISTRICT_CODE_DEFAULT, WARD_CODE_DEFAULT);

    let index = CARD_CONTACT_INDEX;
    // Card Contact:
    let cardContact = `<div class="card card-contact">
                            <div class="card-header">
                                <h4 class="card-title" id="from-actions-bottom-right">Contact</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="remove"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collpase show">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="contact-customer contact-customer-${index}">
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-2">
                                                    <label for="full_name">Full Name</label>
                                                    <input type="text" class="form-control" id="full-name-contact-${index}" data-counter=255 placeholder="Full name" name="customer_contact[${index}][full_name]" />
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-2">
                                                    <label for="job_position">Job Position</label>
                                                    <input type="text" class="form-control" id="job-position-contact-${index}" data-counter=255 placeholder="Job Position" name="customer_contact[${index}][job_position]" />
                                                </div>
                                            </div>
                    
                                            <div class="row">
                                                <div class="form-group col-md-4 mb-2">
                                                    <label class="control-label required" for="role">Gender</label>
                                                    <select class="select2-placeholder-multiple form-control gender-list" id="select-gender-list-contact-${index}" name="customer_contact[${index}][gender]">
                                                    </select>
                                                </div>
                    
                                                <div class="form-group col-md-8 mb-2">
                                                    <label for="dob">Birth Day</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <span class="la la-calendar-o"></span>
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control pickadate" id="dob-contact-${index}" placeholder="Birth Day" name="customer_contact[${index}][dob]" />
                                                    </div>
                                                </div>
                                            </div>
                    
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-2">
                                                    <label for="phone">Phone</label>
                                                    <input type="text" class="form-control" id="phone-contact-${index}" data-counter=50 placeholder="Phone" name="customer_contact[${index}][phone]" />
                                                </div>
                                            </div>
                    
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-2">
                                                    <label for="email">Email</label>
                                                    <input type="text" class="form-control" id="email-contact-${index}" data-counter=120 placeholder="Email" name="customer_contact[${index}][email]" />
                                                </div>
                                            </div>
                    
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-2">
                                                    <label for="note">Note</label>
                                                    <textarea class="form-control" id="note-contact-${index}" data-counter=255 placeholder="Full name" name="customer_contact[${index}][note]" cols="50" rows="10"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;

    let listGender = $.map(LIST_GENDER, function(key, value) {
        return {
            id : value,
            text: key
        };
    });

    // Add Contact:
    $(document).on("click", ".action-add-contact", function(event) {
        $('.list-contacts').append(cardContact);

        $(`.pickadate#dob-contact-${index}`).pickadate({
            format: 'dd/mm/yyyy',
            formatSubmit: 'yyyy-mm-dd',
        });

        $(`.gender-list#select-gender-list-contact-${index}`).select2({
            placeholder: "Select a gender",
            data: listGender,
        });

        index++;
    });

    // Change Type data reference:
    $(document).on("change", '.type_reference_data-list', function(e) {
        // Do something
        e.preventDefault();
        let data = {
            "type_reference_data" : $(this).val()
        };
        let request = axios.get(API.GET_INTRODUCE_PERSON, { params: data});

        return request
            .then(function(data){
                $(`.introduce_person_id-list`).empty();
                $(`.introduce_person_id-list`).select2({
                    placeholder: "Select a person",
                    minimumResultsForSearch: Infinity,
                    data: data.data,
                    templateResult: iconFormat,
                    templateSelection: iconFormat,
                    escapeMarkup: function(es) { return es; }
                });
                if (mode === "EDIT" && INTRODUCE_PERSON_ID !== "") {
                    $(`.introduce_person_id-list`).val(INTRODUCE_PERSON_ID).trigger('change');
                    mode = "edit-updated";
                }
            })
            .catch(function(data){
                console.log("error", data);
            })
            .then(function(data){

            });
    });

    $('.type_reference_data-list').trigger('change');

    // Format icon
    function iconFormat(item) {
        let avatar = '/vendor/core/images/default-avatar.jpg';
        if (item.avatar !== null && item.avatar !== '')
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

    if (CUSTOMER_RELATION_ID !== "")
        $('.customer_relationship_id-list').val(CUSTOMER_RELATION_ID).trigger('change');
    else
        $('.customer_relationship_id-list').trigger('change');

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
        minimumResultsForSearch: Infinity,
        data: listUser,
        templateResult: iconFormat,
        templateSelection: iconFormat,
        escapeMarkup: function(es) { return es; }
    });

    $('.user_manage_id-list').trigger('change');

})(window, document, jQuery);