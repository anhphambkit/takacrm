import axios from 'axios';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

class Table {
    constructor(){
        // U must define correct wrapper whenever use this
        this.wrapperTable = '.b-table-custom';
        // Define options default:
        this.options = {
            "processing": false,
            "serverSide": false,
            "searching":true,
        };

        // if ($(window).width() < 692) {
        //     this.optionLanguage = {
        //         "pagingType": "simple",
        //         "language": {
        //             "info": "_START_ - _END_ of _TOTAL_",
        //             "paginate": {
        //                 "previous": "<",
        //                 "next": ">",
        //             }
        //         }
        //     };
        // }

        this.responsiveTable = false;
        // Source data mapping datatable:
        this.dataSrc = "data";
        // Data to send
        this.dataSearch = {};
        // Define other options:
        this.otherDefaultOption = {
            "drawCallback": function( settings ) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        };
        // Define Options Setup Table:
        this.initOptions = {};
        // Define columns:
        this.columns = [];
        // Url to send submit
        this.urlSearch = '//google.com';
        // Data to send cancel
        this.dataSearchDefault = {};
    }

    // /*
    //     Hooks
    //  */
    // loadingElement(element = this.wrapperTable) {
    //     elementLoading = element;
    // }

    /*
        Loading button
     */
    loadingBtn(btnLoading) {
        // $(btnLoading).buttonLoader('start');
    }

    /*
        Stop Loading Button
     */
    stopLoadingBtn(btnLoading) {
        // $(btnLoading).buttonLoader('stop');
    }

    /**
     * Prepare options for init table
     */
    prepareOptions(isFirst = true){
        let optionAjax = {
            "ajax": {
                "url": this.urlSearch,
                "dataSrc": this.dataSrc,
                "data": (isFirst) ? this.dataSearchDefault : this.dataSearch
            },
            columns: this.columns
        };
        let optionResponsive = {
            responsive: this.responsiveTable
        };
        this.initOptions = Object.assign(this.initOptions, this.options, optionResponsive, this.otherDefaultOption, optionAjax, this.optionLanguage);
        return this.initOptions;
    }

    /**
     * Destroy and empty table
     */
    destroyEmptyTable() {
        $(this.wrapperTable).DataTable().destroy();
        $(this.wrapperTable).empty();
    }

    /**
     * Refresh table:
     */
    refreshTable() {
        this.destroyEmptyTable();
        this.init(false, null, null);
    }

    /**
     * Init Table
     */
    initTable(wrapperSearchFilter = null, btnLoading = null) {
        let selfTable = this;
        $(this.wrapperTable)
            .on('processing.dt', function ( e, settings, processing ) {
            // processing
            //     selfTable.loadingElement();
            })
            .on('xhr.dt', function ( e, settings, json, xhr ) {
                // Stop Loader
                if (btnLoading !== null) selfTable.stopLoadingBtn(btnLoading);
            })
            .DataTable(this.initOptions);
        $(".col-sm-12.col-md-5").removeClass().addClass("col-6");
        $(".col-sm-12.col-md-7").removeClass().addClass("col-6");
    }

    /**
     *  Init function:
     */
    init(isFirst = true, wrapperSearchFilter = null, btnLoading = null) {
        this.prepareOptions(isFirst);
        // Loading:
        if (btnLoading !== null) this.loadingBtn(btnLoading);
        this.initTable(wrapperSearchFilter, btnLoading);
    }
}
export default Table;