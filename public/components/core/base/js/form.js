import axios from 'axios';
//import JSLib from '@helper/util/js-lib';
//import message from '@helper/config/messages';
//import responeForm from '@supportResources/respone-form';
//import toastrAlert from '@supportResources/toastr-alert';
//import helper from "@/helper/js/helper";

class Form {
    constructor(){
        // U must define correct wrapper whenever use this
        this.wrapper = '.kc-form';
        // Submit button selector
        this.submitBtn = '[data-control="submit"]';
        // Cancel button selector
        this.cancelBtn = '[data-control="cancel"]';
        // Attach token when submit
        this.token = '';
        // method to submit POST / GET / PUT / DELETE ...
        this.method = 'POST';
        this.methodCancel = 'GET';
        // Url to send submit
        this.url = '#';
        // Url to send cancel (restore old data)
        this.urlCancel = '#';
        // Has alert when update/create success/fail:
        this.hasSwal = true;
        // Has toastr when update/create success/fail:
        this.hasToastr = true;
        // Default message success:
        this.successMessage = '';
        // Default Error message:
        this.errorMessage = null;
        // Data to send
        this.data = {};
        // Data to send cancel
        this.dataCancel = {};
        // Restore old data when click cancel
        this.restoreWhenCancel = true;
        // Default reload page when success:
        this.isReload = true;
        // Set attribute to get data null placeholder
        this.attrNullPlacholder = 'null-placeholder';
    }

    // Hooks
    beforeSubmit(){};
    done(data){};
    afterDone(data){};
    fail(data){};
    afterFail(data){};
    final(data){};

    // Hooks
    beforeCancel(){};
    afterCancel(data){};
    failCancel(data){};
    finalCancel(data){};

    /* loading */
    setloading(){};
    loading()
    {
        elementLoading = this.setloading();
    }

    /**
     * Reset data
     */
    clearForm(isRefreshTable = true, isCloseModal = true) {
        let self = this;
        $(this.wrapper).find('select, input, textarea').each(function(item){
            let nullPlaceholder = $(this).attr(self.attrNullPlacholder) || '';
            let idElement = $(this).attr('id');
            switch ($(this).data('plugin')) {
                case 'ckeditor':
                    let editor = CKEDITOR.instances[idElement];
                    if (!editor)
                        core.initCkEditor4(idElement);
                    CKEDITOR.instances[idElement].setData("");
                    break;

                case 'switchery':
                    let defaultValue = $(this).data('default');
                    helper.resetDefaultDataSwitchery('#' + idElement, defaultValue)
                    break;

                case 'select2':
                    $('#' + idElement).val(null).trigger('change');
                    break;

                case 'bb-file-upload-item':
                    let idElementPlugin = $(this).data('element-plugin');
                    helper.removeElements(`${idElementPlugin} .bb-file`);
                    break;

                default:
                    if ($(this).is('select')) $(this).val(0);
                    else $(this).val(nullPlaceholder);
            }
        });

        let keys = Object.keys(this.data);
        let reuseForm = this;
        keys.forEach( (field) => {
            let ctl = $(reuseForm.wrapper + ' ' + '[name="' + field + '"]');
            if(ctl.length > 0){
                let idElement = ctl.attr('id');
                let nullPlaceholder = ctl.attr(self.attrNullPlacholder) || '';
                switch (ctl.data('plugin')) {
                    case 'ckeditor':
                        let editor = CKEDITOR.instances[idElement];
                        if (!editor)
                            core.initCkEditor4(idElement);
                        CKEDITOR.instances[idElement].setData("");
                        break;

                    case 'switchery':
                        let defaultValue = ctl.data('default');
                        helper.resetDefaultDataSwitchery('#' + idElement, defaultValue)
                        break;

                    case 'select2':
                        $('#' + idElement).val(null).trigger('change');
                        break;

                    case 'bb-file-upload-item':
                        let idElementPlugin = ctl.data('element-plugin');
                        helper.removeElements(`${idElementPlugin} .bb-file`);
                        break;

                    default:
                        $('#' + idElement).val(nullPlaceholder);
                }
            }
        });

        this.data = {};

        if(typeof refreshTable === 'function' && isRefreshTable){
            refreshTable();
        }

        if(typeof closeModal === 'function' && isCloseModal){
            closeModal();
        }
    }

    /**
     * Parse validation errors object from Laravel
     * @param errors (Object)
     */

    parseValidateErrors (errors) {
        let form = this
        $(this.wrapper +' [data-validation="data-validation"]').each(function(index){
            var is = $(this);
            var errorField = is.attr('data-field');

            if(index == 0){
                form.scrollToError(errorField);
            }

            if (errors[errorField] != null){
                is.slideDown();
                for(var i = 0; i < errors[errorField].length; i++){
                    is.append('<li class="help-block">' + errors[errorField][i] + '</li>');
                }
                is.closest('.form-custom-validate-js').addClass('has-error');
            }
        });
    }

    /**
     * Remove all errors were parsed before
     */

    resetErrors () {
        $(this.wrapper +' .form-custom-validate-js').removeClass('has-error');
        $(this.wrapper +' [data-validation="data-validation"]').empty();
    }

    /**
     * Field name that will be detected by "[data-validation="data-validation"][data-field="{field}"]"
     * @returns {*}
     */
    scrollToError(field){
        $('html, body').animate({
            scrollTop: Math.abs($(this.wrapper + ' [data-validation="data-validation"][data-field="' + field + '"]').offset().top - 210)
        }, 1000);
    }

    /**
     * Prepare data from Form => Json. Send it to server
     */
    prepareData(){
        this.data = $(this.wrapper).serializeJSON({
            useIntKeysAsArrayIndex: true,
            parseNulls: true,
            parseAll: true,
            parseWithFunction: (val, inputName) => {
                if(val === ''){
                    return null;
                }
                return val;
            }
        });

        let self = this;
        $(this.wrapper).find('select, input, textarea').each(function(item){
            let idElement = $(this)[0].id;
            let name = $(this).attr('name');
            if ($(this).data('plugin') === 'ckeditor') {
                let editor = CKEDITOR.instances[idElement];
                if (!editor)
                    core.initCkEditor4(idElement);
                self.data[name] = CKEDITOR.instances[idElement].getData();
            }

            if ($(this).data('plugin') === 'switchery' || $(this).attr('type') === 'checkbox') {
                self.data[name] = $('#' + idElement)[0].checked;
            }

            if ($(this).data('plugin') === 'select2') {
                self.data[name] = $('#' + idElement).val();
            }
        });
    }

    submit() {
        this.prepareData();
        this.beforeSubmit();
        // $(this.wrapper + ' ' + this.submitBtn).loading();
        $(this.wrapper + ' ' + this.submitBtn).buttonLoader('start');

        this.resetErrors();
        let request = null;
        switch (this.method) {
            case 'POST':
                request = axios.post(this.url, this.data);
                break;
            default:
                request = axios.get(this.url, this.data);
        }

        let reuseForm = this;
        return request
            .then(function(data){
                reuseForm.done(data);
                let errorMessage = reuseForm.errorMessage || data.data.message;
                if (reuseForm.hasSwal) {
                    let successForm = new responeForm();
                    successForm.init(data.data.status, reuseForm.successMessage, errorMessage)
                }
                if (reuseForm.hasToastr) {
                    let toastrSuccessAlert = new toastrAlert();
                    toastrSuccessAlert.init(data.data.status, reuseForm.successMessage, errorMessage)
                }
                reuseForm.afterDone(data);
                reuseForm.clearForm()
                return data;
            })
            .catch(function(data){
                /**
                 * Do some hook -> parse validation error -> scroll screen to element
                 */
                $(reuseForm.wrapper + ' ' + reuseForm.submitBtn).buttonLoader('stop')
                let dataRespone = data.response;
                reuseForm.fail(dataRespone);
                let errorMessage = reuseForm.errorMessage || data.message;
                if (reuseForm.hasSwal) {
                    let errorForm = new responeForm();
                    errorForm.init(dataRespone.status, reuseForm.successMessage, errorMessage)
                }
                if (reuseForm.hasToastr) {
                    let toastrErrorAlert = new toastrAlert();
                    toastrErrorAlert.init(dataRespone.status, reuseForm.successMessage, errorMessage)
                }
                if(dataRespone.data != null && dataRespone.data.status == CONFIG.HTTP_CODE.VALIDATE_ERROR ){
                    reuseForm.parseValidateErrors(dataRespone.data.data);
                }
                reuseForm.afterFail(data);
                return data;
            })
            .then(function(data){ // Finally
                if(data.response != undefined){
                    reuseForm.final(data.response.data);
                } else {
                    reuseForm.final(data.data);
                }
                $(reuseForm.wrapper + ' ' + reuseForm.submitBtn).buttonLoader('stop');
            });
    }

    /**
     * Auto handle event click on Cancel
     */
    handleCancel(){
        let reuseForm = this;
        $(this.wrapper + ' ' + this.cancelBtn).on('click', function(e) {
            e.preventDefault();
            reuseForm.cancel();
        });
    }

    /**
     * Auto handle event click on Submit
     */
    handleSubmit(){
        let reuseForm = this;
        $(this.wrapper + ' ' + this.submitBtn).on('click', function(e) {
            e.preventDefault();
            reuseForm.submit();
        });
    }

    /**
     * Auto push data from object _data to input / select / ...
     * @param _data
     */
    mapField(_data){
        let keys = Object.keys(_data);
        let reuseForm = this;
        keys.forEach( (field) => {
            let ctl = $(reuseForm.wrapper + ' ' + '[name="' + field + '"]');
            if(ctl.length > 0){
                ctl.val(_data[field]);
                // Check ctl is type checkbox:
                let typeCtl = ctl.attr("type");
                if (typeCtl === "checkbox")
                    ctl.prop('checked', _data[field]);

                let idElement = ctl.attr('id');
                switch (ctl.data('plugin')) {
                    case 'ckeditor':
                        let editor = CKEDITOR.instances[idElement];
                        if (!editor)
                            core.initCkEditor4(idElement);
                        CKEDITOR.instances[idElement].setData(_data[field]);
                        break;

                    case 'switchery':
                        helper.resetDefaultDataSwitchery('#' + idElement, _data[field])
                        break;

                    case 'select2':
                        $('#' + idElement).val(_data[field]).trigger('change')
                        break;

                    default:
                        $('#' + idElement).val(_data[field]);
                }
            }
            else {
                // Check element has name array:
                let ctlArray = $(reuseForm.wrapper + ' ' + '[name="' + field + '[]"]');
                if (ctlArray.length > 0) {
                    let element = ctlArray.data('wrap-plugin');
                    let nameInput = ctlArray.data('name-file-item');
                    switch (ctlArray.data('plugin')) {
                        case 'bb-file-upload':
                            _data[field].forEach( (item) => {
                                let src = helper.showImgStorage(item.path_org);
                                let uploadedFileInfo = `<li class="bb-file bb-file-${name}">
                                                <input type="text" hidden data-plugin="bb-file-upload-item" data-element-plugin="${element}" value="${item.id}" name="${nameInput}[]" />
                                                <img class="bb-thumb" src="${src}" />
                                                <a class="bb-icon la la-trash bb-remove"></a>
                                            </li>`;
                                $(uploadedFileInfo).appendTo($(element + ' .bb-files ul'));
                            })
                            break;
                    }
                }
            }
        });
    }

    /**
     * Handle cancel click
     */
    cancel(){
        this.beforeCancel();
        if(!this.restoreWhenCancel){
            this.resetErrors();
            this.afterCancel(null);
            this.finalCancel(null);
            return;
        }
        $(this.wrapper + ' ' + this.cancelBtn).loading();
        this.resetErrors();
        let request = null;
        switch (this.methodCancel) {
            case 'POST':
                request = axios.post(this.urlCancel, this.dataCancel);
                break;
            default:
                request = axios.get(this.urlCancel, this.dataCancel);
        }

        let reuseForm = this;
        return request
            .then(function(data){
                reuseForm.afterCancel(data.data);
                reuseForm.mapField(data.data.data);
                $(reuseForm.wrapper).closest('.eden-card').find('.control-panel .switch-panel-mode').trigger('click');
                return data;
            })
            .catch(function(data){
                /**
                 * Do some hook -> parse validation error -> scroll screen to element
                 */
                reuseForm.failCancel(data.response.data);
                return data;
            })
            .then(function(data){
                if(data.response != undefined){
                    reuseForm.finalCancel(data.response.data);
                } else {
                    reuseForm.finalCancel(data.data);
                }
                $(reuseForm.wrapper + ' ' + reuseForm.cancelBtn).loading();
                reuseForm.clearForm()
            });
    }
}
export default Form;
