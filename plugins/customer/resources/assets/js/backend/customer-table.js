import Helper from '@coreComponents/base/js/helper';
import SearchTable from '@coreComponents/base/js/search-table';
import axios from 'axios';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


if ($('body').hasClass('vertical-layout')) {
    var menuWidth = $('.main-menu').outerWidth();
    $('.fixedHeader-floating').css('margin-left',menuWidth+'px');
}

let manageConsumer = new SearchTable();
manageConsumer.wrapperTable = '#customer-table';
manageConsumer.options = {
    "processing": true,
    "serverSide": false,
    "searching": true,
    "scrollX": true,
    "autoWidth": true,
    fixedColumns: {
        leftColumns: 3
    },
    // fixedHeader: {
    //     header: true,
    //     headerOffset: $('.header-navbar.navbar-fixed').outerHeight(),
    // },
    dom: 'lBfrtipF',
    buttons: [ 'print', 'csv', 'excel' ],
    rowCallback: function (row, data, index) {
        var color = data.customer_relation_color_code;
        $('td:eq(0)', row).css('background', color);
    },
};
manageConsumer.otherDefaultOption = {
    "drawCallback": function( settings ) {
        $('[data-toggle="tooltip"]').tooltip();
    },
};
manageConsumer.columns = [
    {
        orderable: false,
        render() {
            return `<input type="checkbox" class="input-chk check">`;
        }
    },
    {
        title: "Actions",
        data: 'id',
        orderable: false,
        render(data) {
            let linkView = `/admin/customer/detail/${data}`;
            let linkEdit = `/admin/customer/edit/${data}`;
            let linkDelete = `/admin/customer/delete/${data}`;
            return Helper.renderActionsTableBasic(linkView, linkEdit, linkDelete);
        }
    },
    {
        title: "Status",
        data: 'status',
        orderable: false,
        render(data) {
            return Helper.renderStatusBasic(data);
        }
    },
    {
        title: "ID",
        data: 'id',
    },
    {
        title: "Customer",
        data: null,
        render(data) {
            let img = data.avatar ? data.avatar : '/vendor/core/images/default-avatar.jpg';
            let link = `/admin/customer/detail/${data.id}`;
            let name = data.full_name;
            return Helper.renderImageWithNameTable(img, name, link);
        }
    },
    {
        title: "Gender",
        data: 'gender'
    },
    {
        title: "Customer Code",
        data: 'customer_code'
    },
    {
        title: "Phone",
        data: 'phone'
    },
    {
        title: "Fax",
        data: 'fax'
    },
    {
        title: "Email",
        data: 'email'
    },
    {
        title: "Relation Customer",
        data: null,
        render(data) {
            return Helper.renderColorNameTable(data.customer_relation_color_code, data.customer_relation_name);
        }
    },
    {
        title: "Customer Group",
        data: 'customer_group_name',
    },
    {
        title: "Customer Job",
        data: 'customer_job_name',
    },
    {
        title: "Customer Source",
        data: 'customer_source_name',
    },
    {
        title: "Value",
        data: 'value'
    },
    {
        title: "Birthday",
        data: 'dob'
    },
    {
        title: "Address",
        data: 'address'
    },
    {
        title: "Ward",
        data: 'ward_data'
    },
    {
        title: "District",
        data: 'district_data'
    },
    {
        title: "Province/City",
        data: 'province_data'
    },
    {
        title: "Website",
        data: 'website'
    },
    {
        title: "Facebook",
        data: 'facebook'
    },
    {
        title: "Note",
        data: 'note'
    },
    {
        title: "Introduce Person",
        data: 'introduce_person_instance',
        render(data) {
            if (data === null || data === "")
                return "";
            let img = data.avatar ? data.avatar : '/vendor/core/images/default-avatar.jpg';
            let name = data.full_name ? data.full_name : '';
            return Helper.renderImageWithNameTable(img, name);
        }
    },
    {
        title: "Personal Manage",
        data: 'user_manage_instance',
        render(data) {
            if (data === null || data === "")
                return "";
            let img = data.avatar ? data.avatar : '/vendor/core/images/default-avatar.jpg';
            let name = data.full_name ? data.full_name : '';
            return Helper.renderImageWithNameTable(img, name);
        }
    },
    {
        title: "Created by",
        data: 'created_by_instance',
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
        data: 'created_at'
    },
];
manageConsumer.urlSearch = API.GET_LIST_CUSTOMER;
manageConsumer.init();
manageConsumer.handleSearchBtn();
manageConsumer.handleClearBtn();

// Delete:
$(document).on('click', '.deleteDialog', function (event) {
    event.preventDefault();
    $('#delete-crud-entry').data('section', $(this).data('section'));
    $('#delete-crud-modal').modal('show');
});

$(document).on('click', '#delete-crud-entry', function (event) {
    event.preventDefault();
    $('#delete-crud-modal').modal('hide');

    let deleteURL = $(this).data('section');

    $.ajax({
        url: deleteURL,
        type: 'GET',
        success: function (data) {
            if (data.error) {
                Lcms.showNotice('error', data.message, Lcms.languages.notices_msg.error);
            } else {
                window.location.replace(API.LIST_CUSTOMER_URL);
                Lcms.showNotice('success', data.message, Lcms.languages.notices_msg.success);
            }
        },
        error: function (data) {
            Lcms.handleError(data);
        }
    });
})

window.getDataFormSearchConsumerTable = function () {
    manageConsumer.prepareDataSearch();
    return manageConsumer.dataSearch;
};

window.parseNewDataFormSearchConsumerTable = function (data) {
    manageConsumer.parseDataFormSearch(data);
};

window.clearFormSearchConsumerTable = function () {
    manageConsumer.resetDataSearch();
};