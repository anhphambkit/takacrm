import axios from 'axios';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

class AddressForm {
    constructor(){
        // U must define correct wrapper whenever use this
        this.wrapperProvinceCity = '#province_city';
        this.wrapperDistrict = '#district';
        this.wrapperWard = '#ward';
        this.wrapperMobilePhone = '#mobile_phone';
        this.apiRefreshDistricts = "#";
        this.apiRefreshWards = "#";
        this.isInit = false;
        this.setInitValue = true;
        this.allowClear = false;
    }

    // /*
    //    Hooks
    //  */
    // loadingElement(element = this.wrapperTable) {
    //     elementLoading = element;
    // }

    handleDistrictData(districtDefault = null) {
        let addressForm = this;
        $(this.wrapperProvinceCity).on('change', function(e) {
            e.preventDefault();
            let data = {
                "province_city_code" : $(this).val()
            };
            addressForm.requestGetNewData(addressForm.wrapperDistrict, addressForm.apiRefreshDistricts, data, districtDefault);
        });
    }

    handleWardData(wardDefault = null) {
        let addressForm = this;
        $(this.wrapperDistrict).on('change', function(e) {
            e.preventDefault();
            let data = {
                "district_code" : $(this).val()
            };
            addressForm.requestGetNewData(addressForm.wrapperWard, addressForm.apiRefreshWards, data, wardDefault);
        });
    }

    requestGetNewData(element, api, data, defaultValue = null) {
        let request = axios.get(api, { params: data});
        let _this = this;
        return request
        .then(function(data){
            $(element).empty();
            $(element).select2({
                width: '100%',
                placeholder: "Select a option",
                allowClear: _this.allowClear,
                data: data.data
            });
            if (defaultValue !== null && !_this.isInit)
                $(element).val(defaultValue).trigger('change')
            else
                $(element).trigger('change')
            _this.isInit = true;
            return data;
        })
        .catch(function(data){
            console.log("error", data);
        })
        .then(function(data){

        });
    }

    resetDefaultData() {
        $(this.wrapperProvinceCity).val($(this.wrapperProvinceCity + ' option:eq(0)').val()).trigger('change');
    }

    /**
     *  Init function:
     */
    init(districtDefault = null, wardDefault = null) {
        let defaults = {
            width: '100%',
            placeholder: "Select a province/city",
            allowClear: this.allowClear
        }
        let addressForm = this;
        $(document).ready(function() {
            let config = Object.assign(defaults);
            $(addressForm.wrapperProvinceCity).select2(config);
        });
        this.handleDistrictData(districtDefault);
        this.handleWardData(wardDefault);
        if (this.setInitValue)
            $(this.wrapperProvinceCity).trigger('change');
        else
            $(this.wrapperProvinceCity).val("").trigger('change');
        $(this.wrapperMobilePhone).mask("(000) 000-0000");
    }
}
export default AddressForm;