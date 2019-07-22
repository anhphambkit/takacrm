import Form from '@coreComponents/base/js/form';
import Helper from '@coreComponents/base/js/helper';
import axios from 'axios';
import {MessageService} from "../../../../../../core/media/resources/assets/js/development/App/Services/MessageService";

axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


$(document).ready(function () {
    $.fn.select2.defaults.set( "theme", "bootstrap" );
})

$(document).on('click', '#pnQuickAddResource button#btnAddResource', function (event) {
    event.preventDefault();
    let resource_name = $('#pnQuickAddResource').find('input#resourceName');
    if(!$.trim(resource_name.val())){
        resource_name.focus()
        return false;
    };
    let data = {
        name : $.trim(resource_name.val())
    }
    let request = axios.post(API.QUICK_ADD.ORDER_RESOURCE, data);
    return request.then((response)=>{
        $('#select-source-order-list').append($('<option>', {value: response.data.id, text: response.data.name}).attr('selected', true))
        resource_name.val('')
    }).catch((error)=>{
        console.log(error)
    });
    return false
})

$(document).on('click', '#btnQuickAddCustomerGroup', function (event) {
    event.preventDefault();
    let customer_group = $('#pnQuickAddCustomerGroup').find('input#customerGroupName');
    if(!$.trim(customer_group.val())){
        customer_group.focus()
        return false;
    };
    let data = {
        name : $.trim(customer_group.val())
    }
    let request = axios.post(API.QUICK_ADD.CUSTOMER_GROUP, data);
    return request.then((response)=>{
        let $element = $("#select-customer_group-list"); // the element that Select2 is initialized on
        let $option = $("<option selected></option>"); // the new base option
        $option.val(response.data.id); // set the id
        $option.text(response.data.name); // set the text
        $element.append($option); // add it to the list of selections
        $element.trigger("change"); // tell Select2 to update
    }).catch((error)=>{
        console.log(error)
    })
    return false
})

$(document).on('click', '#btnQuickAddCustomerSource', function (event) {
    event.preventDefault();
    let customer_group = $('#pnQuickAddCustomerSource').find('input#customerSourceName');
    if(!$.trim(customer_group.val())){
        customer_group.focus()
        return false;
    };
    let data = {
        name : $.trim(customer_group.val())
    }
    let request = axios.post(API.QUICK_ADD.CUSTOMER_SOURCE, data);
    return request.then((response)=>{
        let $element = $("#select-customer_source-list"); // the element that Select2 is initialized on
        let $option = $("<option selected></option>"); // the new base option
        $option.val(response.data.id); // set the id
        $option.text(response.data.name); // set the text
        $element.append($option); // add it to the list of selections
        $element.trigger("change"); // tell Select2 to update
    }).catch((error)=>{
        console.log(error)
    })
    return false
})


$(document).on('click', '#btnQuickAddCustomerJob', function (event) {
    event.preventDefault();
    let customer_job = $('#pnQuickAddCustomerJob').find('input#customerJobName');
    if(!$.trim(customer_job.val())){
        customer_job.focus()
        return false;
    };
    let data = {
        name : $.trim(customer_job.val())
    }
    let request = axios.post(API.QUICK_ADD.CUSTOMER_JOB, data);
    return request.then((response)=>{
        let $element = $("#select-customer_job-list"); // the element that Select2 is initialized on
        let $option = $("<option selected></option>"); // the new base option
        $option.val(response.data.id); // set the id
        $option.text(response.data.name); // set the text
        $element.append($option); // add it to the list of selections
        $element.trigger("change"); // tell Select2 to update
    }).catch((error)=>{
        console.log(error)
    })
    return false
})


let index = CARD_CONTACT_INDEX;
let listGender = $.map(LIST_GENDER, function(key, value) {
    return {
        id : value,
        text: key
    };
});
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




let customerForm = new Form
customerForm.wrapper = '#form-quick-add-customer';
customerForm.url = API.QUICK_ADD.CUSTOMER;
customerForm.hasSwal = false;
customerForm.hasToastr = false
customerForm.beforeSubmit = (data)=>{}
customerForm.afterDone = (response)=>{
    $('#customer_name').val(response.data.full_name)
    $('#customer_code').val(response.data.customer_code)
    $('#customer_phone').val(response.data.phone)
    $('#customer_email').val(response.data.email)
    $('#customer_address').val(response.data.address_full)
    $('#customer_id').val(response.data.id)
    $('#modQuickAddCustomer').modal('hide')
    // $('#select-customer-list').select2({
    //     templateResult: function (response){
    //         return Helper.formatDataResultCustomerSelect2(this, response.data)
    //     },
    //     escapeMarkup: function (markup) {
    //         return markup; // let our custom formatter work
    //     },
    //     templateSelection: function (data) {
    //         return Helper.formatInitDataSelectionCustomerSelect2(this.response.data)
    //     }
    // });
}

customerForm.afterCancel = (data) => {
};
customerForm.afterFail = (data)=>{
    MessageService.showMessage('error', 'Please enter required fields', 'Error!')
}
// Handle event on form
customerForm.handleSubmit();
customerForm.handleCancel();
