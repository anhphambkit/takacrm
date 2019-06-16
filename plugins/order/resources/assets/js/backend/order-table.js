import Helper from '@coreComponents/base/js/helper';
import SearchTable from '@coreComponents/base/js/search-table';
import axios from 'axios';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let manageOrder = new SearchTable();
manageOrder.wrapperTable = '#order-table';
manageOrder.options = {
    "processing": true,
    "serverSide": true,
    "searching": true,
    "scrollX": true,
    "autoWidth": true,
    dom: 'lBfrtipF',
    buttons: [ 'print', 'csv', 'excel' ],
};
manageOrder.otherDefaultOption = {
    "drawCallback": function( settings ) {
        $('[data-toggle="tooltip"]').tooltip();
    },
};
manageOrder.columns = [
    {
        title: "ID",
        name: "id",
        data: 'id',
    },

    {
        title: "Order Date",
        data: 'order_date',
        name: 'order_date',
        searchable: false,
    },
    {
        title: "Order Code",
        data: null,
        name: 'order_code',
        render(data) {
            return `<a href="${API.DETAIL_ORDER}/${data.id}" class="link-order-detail">${data.order_code}</a>`;
        }
    },
    {
        title: "Customer Code",
        data: 'customer_code',
        name: 'customer_code',
    },
    {
        title: "Customer Name",
        data: 'customer_name',
        name: 'customer_name',
    },
    {
        title: "Customer Address",
        data: 'customer_address',
        name: 'customer_address',
    },
    {
        title: "Sales",
        data: 'sale_order',
        name: 'sale_order',
        searchable: false,
    },
    {
        title: "VAT",
        data: 'vat_order',
        name: 'vat_order',
        searchable: false,
    },
    {
        title: "Discount",
        data: 'discount_order',
        name: 'discount_order',
        searchable: false,
    },
    {
        title: "Revenue",
        data: 'total_order',
        name: 'total_order',
        searchable: false,
    },
    {
        title: "Paid",
        data: 'id',
        name: 'id',
        searchable: false,
    },
    {
        title: "Remaining Amount",
        data: 'id',
        name: 'id',
        searchable: false,
    },
    {
        title: "Profit",
        data: 'id',
        name: 'id',
        searchable: false,
    },
    {
        title: "Lading Code",
        data: 'lading_code',
        name: 'lading_code',
    },
    {
        title: "Created by",
        data: 'created_by_instance',
        name: 'created_by',
        searchable: false,
        render(data) {
            if (data === null || data === "")
                return "";
            let img = data.avatar ? data.avatar : '/vendor/core/images/default-avatar.jpg';
            let name = data.full_name ? data.full_name : '';
            return Helper.renderImageWithNameTable(img, name);
        }
    },
    {
        title: "Created at",
        data: 'created_at',
        name: 'created_at',
        searchable: false,
    },
];
manageOrder.urlSearch = API.GET_LIST_ORDER;
manageOrder.init();
manageOrder.handleSearchBtn();
manageOrder.handleClearBtn();
manageOrder.handleFilterStatus();

window.getDataFormSearchOrderTable = function () {
    manageOrder.prepareDataSearch();
    return manageOrder.dataSearch;
};

window.parseNewDataFormSearchOrderTable = function (data) {
    manageOrder.parseDataFormSearch(data);
};

window.clearFormSearchOrderTable = function () {
    manageOrder.resetDataSearch();
};