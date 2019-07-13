import axios from 'axios';
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

