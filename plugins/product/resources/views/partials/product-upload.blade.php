<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    <i class="fa fa-upload"></i> @lang('plugins-product::product.upload_product')
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase blue mb10 font20 mg0" id="exampleModalLabel">Tải lên danh sách sản phẩm</h5>
                <!--button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button-->
                <a href="https://www.google.com" target="_blank" class="blue"> Bạn cần hướng dẫn? </a>
            </div>
            <div class="modal-body">
                <div class="col-md-12 p-0">
                    <p class="m-0"><strong>TakaCRM</strong> sẽ giúp bạn tải lên dữ liệu chỉ với một thao tác đơn giản.</p>
                    <p>Vui lòng <a class="blue bold downloadSample">NHẬP THEO MẪU DỮ LIỆU NÀY</a> và chọn tải lên danh sách.</p>
                </div>
                <div class="col-md-12 p-1 mt10" style="border:dashed red 1px">
                    <p class="red bold m-0">Chú ý:</p>
                    <p class="red m-0"> - Các luật Automation sẽ KHÔNG ĐƯỢC thực hiện khi upload dữ liệu</p>
                    <p class="red m-0"> - Giới hạn mỗi lần upload tối đa <strong>1000</strong> Sản phẩm</p>
                </div>
                <div id="modal_upload_frm" class="col-md-12 p-0 pt10 mt-1">
                    <label class="btn btn-file mr5 btn-success btn-sm" style="">
                        <i class="fa fa-cloud-upload-alt" aria-hidden="true"></i>&nbsp;Tải lên danh sách
                        <input type="file" name="userfile" id="uploadfile" multiple="" style="display:none" accept=".xlsx,.xls">
                    </label>
                    <div class="progress mb0 mt5 hidden-content hidden">
                        <div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="min-width:2em;width:2%">0%</div>
                    </div>
                    <div id="list_file_upload"></div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="col-md-8 p-0 tl mt10">
                    <div class="checkbox">
                        <label><input type="checkbox" value="">&nbsp;Ghi đè dữ liệu nếu trùng mã</label>
                    </div>
                </div>
                <div class="col-md-4 p-0 tr text-right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('plugins-product::product.close')</button>
                    <button type="button" class="btn btn-primary" id="btnUploadFile">@lang('plugins-product::product.upload')</button>
                </div>

            </div>
        </div>
    </div>
</div>
