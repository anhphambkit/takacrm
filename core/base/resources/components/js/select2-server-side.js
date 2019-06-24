/*=========================================================================================
    File Name: select2-server-side.js
    ----------------------------------------------------------------------------------------
    Author: Anh Pham
==========================================================================================*/
class Select2ServerSide {
    constructor(){
        // U must define correct wrapper whenever use this
        this.wrapperSelect = '#select2-server-side';
        this.urlAjax = 'https://api.github.com/search/repositories';
        this.method = 'GET';
        this.dataType = 'json';
        this.deplay = '250';
        this.numberOnePage = 30;
        this.paramResultKey = "items";
        this.paramTotalCountKey = "total_count";
        this.isCache = true;
        this.allowClear = true;
        this.placeholder = 'Input any key to search';
        this.minimumInputLength = 1;
        this.isInit = true;
    }

    /**
     *
     * @param _this
     * @param params
     * @returns {{limit: number, searchKey: *, page: *}}
     */
    formatDataRequest(_this, params) {
        return {
            searchKey: params.term, // search term
            page: params.page,
            limit: this.numberOnePage
        };
    }

    /**
     *
     * @param _this
     * @param data
     * @param params
     * @returns {{pagination: {more: boolean}, results: *}}
     */
    processResults(_this, data, params){
        // parse the results into the format expected by Select2
        // since we are using custom formatting functions we do not need to
        // alter the remote JSON data, except to indicate that infinite
        // scrolling can be used
        params.page = params.page || 1;

        return {
            results: data.items,
            pagination: {
                more: (params.page * 30) < data.total
            }
        };
    };

    /**
     *
     * @param _this
     * @param markup
     * @returns {*}
     */
    escapeMarkup(_this, markup) {
        return markup;
    };

    /**
     *
     * @param _this
     * @param data
     * @returns {*}
     */
    formatDataResult(_this, data){
        return data.full_name || data.id;
    };

    /**
     *
     * @param _this
     * @param data
     * @returns {*}
     */
    formatInitDataResult(_this, data){
        return data.full_name || data.id;
    };

    /**
     *
     * @param _this
     * @param data
     * @returns {*}
     */
    formatDataSelection(_this, data){
        return data.full_name || data.id;
    };

    /**
     *
     * @param _this
     * @param data
     * @returns {*}
     */
    formatInitDataSelection(_this, data){
        return data.full_name || data.id;
    };

    /**
     *  Init function:
     */
    init() {
        let _this = this;
        $(this.wrapperSelect).select2({
            ajax: {
                method: _this.method,
                url: _this.urlAjax,
                dataType: _this.dataType,
                delay: _this.deplay,
                data: function (params) {
                    return _this.formatDataRequest(_this, params)
                },
                processResults: function (data, params) {
                    return _this.processResults(_this, data, params);
                },
                cache: _this.isCache
            },
            placeholder: _this.placeholder,
            allowClear: _this.allowClear,
            escapeMarkup: function (markup) {
                return _this.escapeMarkup(_this, markup); // let our custom formatter work
            },
            minimumInputLength: _this.minimumInputLength,
            templateResult: function (data) {
                if (_this.isInit)
                    return _this.formatInitDataResult(_this, data);
                return _this.formatDataResult(_this, data);
            },
            templateSelection: function (data) {
                if (_this.isInit)
                    return _this.formatInitDataSelection(_this, data);
                return _this.formatDataSelection(_this, data);
            }
        });
        this.isInit = false;
    }
}
export default Select2ServerSide;