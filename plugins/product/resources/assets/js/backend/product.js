import axios from 'axios'
import {MessageService} from "../../../../../../core/media/resources/assets/js/development/App/Services/MessageService";

/** download template action **/
$(document).on('click', '.downloadSample', function () {
    axios.get(API.IMPORT.DOWNLOAD).then((response)=>{
        window.location.href = window.location.origin+'/download/template/products/'+ response.data
    }).catch((error)=>{
        console.log(error)
    })
})

/** import product template action **/
var $files = [];
$('#uploadfile').on('change', function (event) {
    let $file = event.target.files[0];
    /* file size <= 5M */
    if($file.size/1000 > 5000){
        MessageService.showMessage('error', 'Kích thước tiệp tin quá lớn!', 'Lỗi')
        return false;
    }

    let maxId = 0;
    $files.map(function(obj){ if(obj.id > maxId){ maxId = obj.id} });
    $files.push({ id: (maxId+1), file: $file })
    console.log($files)

    let wrapper = $('#list_file_upload');
    let item = `
        <div class="item-file">
            <div>${ $file.name } (${ ($file.size/1000).toFixed(2) } kB) 
                <a href="javascript:;" class="text-danger" onclick="removeFile(${(maxId+1)}, this)">
                    <i class="fa fa-trash gf-icon-del gf-icon-hover ml5" data-id="${(maxId+1)}"></i>
                </a>
            </div>
       </div>`;
    wrapper.append(item)
})

window.removeFile = (id, element)=>{
    $(element).closest('.item-file').remove()
    $files = $files.filter(function (obj) {
        return obj.id != id
    })
    console.log($files)
}


$('#btnUploadFile').click(function () {
    if($files === undefined || $files.length == 0){
        MessageService.showMessage('error', 'Vui lòng chọn file upload!', 'Lỗi')
        return false;
    }
    let formData = new FormData()
    $files.forEach((item)=>{
        formData.append('templates[]', item.file)
    })

    axios.post(API.IMPORT.PROCESS, formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then((response)=>{
        MessageService.showMessage('success', response.message, 'Hoàn Thành')
    }).catch((error)=>{
        MessageService.showMessage('error', error.message, 'Lỗi')
    })

})
