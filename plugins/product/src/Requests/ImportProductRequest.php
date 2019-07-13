<?php
    namespace Plugins\Product\Requests;
    use Core\Master\Requests\CoreRequest;
    class ImportProductRequest extends CoreRequest
    {
        public function rules(){
            return [
                'templates'     => 'required', #|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ];
        }
    }
?>
