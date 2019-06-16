import Table from '@coreComponents/base/js/table';
import axios from 'axios';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

class SearchTable extends Table{
    constructor () {
        super();
        // U must define correct wrapper whenever use this | wrapper search filter
        this.wrapperSearchFilter = '.search-form';
        // U must define correct wrapper whenever use filter search (filter status, filter date time,...)
        this.elementFilterSearch = '.btn-filter-search';
        this.filterTypeData = 'filter-type';
        this.filterTypeGroupData = 'filter-type-group';
        this.signalFilterActiceData = 'filter-active';
        this.filterValueData = 'filter-value';
        this.classFilterInactive = 'btn-light';
        this.classFilterActive = 'btn-dark active';
        // Search button selector
        this.searchBtn = '[data-search-control="search"]';
        // Clear button selector
        this.clearBtn = '[data-search-control="clear"]';
    }

    /**
     * Hooks
     */
    beforeSearch(){}
    afterParseDataSearch(){}

    /**
     * Reset data for search table
     */
    resetDataSearch() {
        $(this.wrapperSearchFilter)[0].reset();
        this.clearForm();
    }

    /**
     * Reset data
     */
    clearForm() {
        let self = this;
        $(this.wrapperSearchFilter).find('select, input, textarea').each(function(item){
            let idElement = $(this).attr('id');
            let name = $(this).attr('name');
            // if ($(this).data('plugin') === 'ckeditor') {
            //     let editor = CKEDITOR.instances[idElement];
            //     if (!editor)
            //         core.initCkEditor4(idElement);
            //     self.data[name] = CKEDITOR.instances[idElement].getData();
            // }

            // if ($(this).data('plugin') === 'switchery' || $(this).attr('type') === 'checkbox') {
            //     self.dataSearch[name] = $('#' + idElement)[0].checked;
            // }

            if ($(this).data('plugin') === 'select2') {
                $('#' + idElement).val(null).trigger('change');
                self.dataSearch[name] = $('#' + idElement).val();
            }
        });
    }

    /**
     * Auto push data from object _data to input / select / ...
     * @param _data
     */
    parseDataFormSearch(_data){
        let keys = Object.keys(_data);
        let _this = this;
        keys.forEach( (field) => {
            let ctl = $(_this.wrapperSearchFilter + ' ' + '[name="' + field + '"]');
            if(ctl.length > 0){
                ctl.val(_data[field]);
                // Check ctl is type checkbox:
                let typeCtl = ctl.attr("type");
                if (typeCtl === "checkbox")
                    ctl.prop('checked', _data[field]);

                let idElement = ctl.attr('id');
                switch (ctl.data('plugin')) {
                    case 'select2':
                        $('#' + idElement).val(_data[field]).trigger('change')
                        break;

                    default:
                        $('#' + idElement).val(_data[field]);
                }
            }
        });
    }

    /**
     * Set data for search table
     */
    prepareDataSearch() {
        this.dataSearch = $(this.wrapperSearchFilter).serializeJSON({
            useIntKeysAsArrayIndex: true,
            parseNulls: true,
            parseNumbers: false,
            parseAll: false,
            parseWithFunction: (val, inputName) => {
                if(val === ''){
                    return null;
                }
                return val;
            }
        });

        let self = this;
        $(this.wrapperSearchFilter).find('select, input, textarea').each(function(item){
            let idElement = $(this)[0].id;
            let name = $(this).attr('name');
            // if ($(this).data('plugin') === 'ckeditor') {
            //     let editor = CKEDITOR.instances[idElement];
            //     if (!editor)
            //         core.initCkEditor4(idElement);
            //     self.data[name] = CKEDITOR.instances[idElement].getData();
            // }

            if ($(this).data('plugin') === 'switchery' || $(this).attr('type') === 'checkbox') {
                self.dataSearch[name] = $('#' + idElement)[0].checked;
            }

            if ($(this).data('plugin') === 'select2') {
                self.dataSearch[name] = $('#' + idElement).val();
            }
        });

        let dataFilter = {};
        $(`${self.elementFilterSearch}.active[data-${self.filterValueData}!="ALL"]`).each(function () {
            let type = $(this).data(self.filterTypeData);
            let value = $(this).data(self.filterValueData);
            let obj = {};
            obj[type] = value;
            dataFilter = Object.assign(dataFilter, obj);
        });

        this.dataSearch = Object.assign(this.dataSearch, dataFilter);

        this.afterParseDataSearch();
    }

    /**
     * Refresh table:
     */
    refreshTable() {
        this.destroyEmptyTable();
        this.prepareDataSearch();
        this.init(false, null, null);
    }

    /**
     * Action Search:
     */
    searchAction(){
        this.destroyEmptyTable();
        this.prepareDataSearch();
        this.beforeSearch();
        let btnLoading = this.wrapperSearchFilter + ' ' + this.searchBtn;
        this.init(false, this.wrapperSearchFilter, btnLoading);
    }

    /**
     * Action Clear:
     */
    clearAction(){
        this.destroyEmptyTable();
        this.resetDataSearch();
        let btnLoading = this.wrapperSearchFilter + ' ' + this.clearBtn;
        this.init(true, this.wrapperSearchFilter, btnLoading);
    }

    /**
     * Disable all input when loading
     */
    disableFieldsWhenLoading() {
        $(this.wrapperSearchFilter + ' input').data('disabled', true);
    }

    /**
     * Event On Search Button
     */
    handleSearchBtn() {
        let selfSearch = this;
        $(this.wrapperSearchFilter + ' ' + this.searchBtn).on('click', function(e) {
            e.preventDefault();
            selfSearch.searchAction();
        });
        this.disableFieldsWhenLoading();
    }

    /**
     * Event On Clear Button
     */
    handleClearBtn() {
        let selfSearch = this;
        $(this.wrapperSearchFilter + ' ' + this.clearBtn).on('click', function(e) {
            e.preventDefault();
            selfSearch.clearAction();
        });
    }

    handleFilterStatus() {
        let _this = this;
        $(document).on('click', _this.elementFilterSearch, function (e) {
            let type = $(this).data(_this.filterTypeData);
            let typeGroup = $(this).data(_this.filterTypeGroupData);
            let value = $(this).data(_this.filterValueData);

            if (value !== 'ALL') {
                if ($(this).data(_this.signalFilterActiceData)) {
                    $(this).addClass(_this.classFilterInactive);
                    $(this).removeClass(_this.classFilterActive);
                    $(this).data(_this.signalFilterActiceData, false);
                }
                else {
                    $(this).removeClass(_this.classFilterInactive);
                    $(this).addClass(_this.classFilterActive);
                    $(this).data(_this.signalFilterActiceData, true);
                }

                $(`${_this.elementFilterSearch}[data-${_this.filterTypeGroupData}="${typeGroup}"][data-${_this.filterTypeData}="${type}"][data-${_this.filterValueData}!="${value}"]`).removeClass(_this.classFilterActive).addClass(_this.classFilterInactive).data(_this.signalFilterActiceData, false);
                $(`${_this.elementFilterSearch}-all[data-${_this.filterTypeGroupData}="${typeGroup}"]`).removeClass(_this.classFilterActive).addClass(_this.classFilterInactive).data(_this.signalFilterActiceData, false);
            }
            else {
                $(`${_this.elementFilterSearch}[data-${_this.filterTypeGroupData}="${typeGroup}"]`).removeClass(_this.classFilterActive).addClass(_this.classFilterInactive).data(_this.signalFilterActiceData, false);
                $(this).removeClass(_this.classFilterInactive);
                $(this).addClass(_this.classFilterActive);
            }

            if ($(`${_this.elementFilterSearch}.btn-dark.active[data-${_this.filterTypeGroupData}="${typeGroup}"]`).length === 0) {
                $(`${_this.elementFilterSearch}-all[data-${_this.filterTypeGroupData}="${typeGroup}"]`).removeClass(_this.classFilterInactive);
                $(`${_this.elementFilterSearch}-all[data-${_this.filterTypeGroupData}="${typeGroup}"]`).addClass(_this.classFilterActive);
            }
            _this.searchAction();
        });
    }

    /**
     *  Init function:
     */
    init(isFirst = true, wrapperSearchFilter = null, btnLoading = null) {
        if(!isFirst) {
            this.prepareDataSearch();
        }
        this.prepareOptions(isFirst);
        // Loading:
        if (btnLoading !== null) this.loadingBtn(btnLoading);
        this.initTable(wrapperSearchFilter, btnLoading);
    }
}
export default SearchTable;