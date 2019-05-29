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
    }

    /**
     *
     * @param params
     * @returns {{q: *, page: *}}
     */
    formatDataRequest(params) {
        return {
            searchKey: params.term, // search term
            page: params.page,
            limit: this.numberOnePage
        };
    }

    /**
     *
     * @param data
     * @param params
     * @returns {{pagination: {more: boolean}, results: *}}
     */
    processResults(data, params){
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
     * @param markup
     * @returns {*}
     */
    escapeMarkup(markup) {
        return markup;
    };

    /**
     *
     * @param data
     * @returns {*}
     */
    formatDataResult(data){
        return data.full_name || data.id;
    };

    /**
     *
     * @param data
     * @returns {*}
     */
    formatDataSelection(data){
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
                    return _this.formatDataRequest(params)
                },
                processResults: function (data, params) {
                    return _this.processResults(data, params);
                },
                cache: _this.isCache
            },
            placeholder: _this.placeholder,
            allowClear: _this.allowClear,
            escapeMarkup: function (markup) {
                return _this.escapeMarkup(markup); // let our custom formatter work
            },
            minimumInputLength: _this.minimumInputLength,
            templateResult: function (data) {
                return _this.formatDataResult(data);
            },
            templateSelection: function (data) {
                return _this.formatDataSelection(data);
            }
        });
    }
}
export default Select2ServerSide;