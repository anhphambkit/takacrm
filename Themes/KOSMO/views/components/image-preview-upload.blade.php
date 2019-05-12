<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 9/6/18
 * Time: 00:55
 */
?>
<?php
$title = isset($title) ? $title : 'Upload';
$classWrap = isset($classWrap) ? $classWrap : '';
$classInputFile = isset($classInputFile) ? $classInputFile : '';
$classLabel = isset($classLabel) ? $classLabel : '';
$classPreviewImage = isset($classPreviewImage) ? $classPreviewImage : '';
$btnUploadClass = isset($btnUploadClass) ? $btnUploadClass : '';
$textBtnUpload = isset($textBtnUpload) ? $textBtnUpload : 'Upload';
$iconBtnUpload = isset($iconBtnUpload) ? $iconBtnUpload : 'la la-cloud-upload';
$name = isset($name) ? $name : 'file';
$attributes = isset($attributes) ? $attributes : [];
$disabled = !empty($disabled) ? true : false;
$parseErrorLaravel = !empty($parseErrorLaravel) ? $parseErrorLaravel : false;
$parseErrorForm = !empty($parseErrorForm) ? $parseErrorForm : false;
$classError = isset($classError) ? $classError : '';
$defaultPreviewImage = isset($defaultPreviewImage) ? $defaultPreviewImage : showImgStorage(false);
?>
<div class="img-preview-upload-wrapper {{ $classWrap }}" @if(isset($idWrap)) id="{{ $idWrap }}" @endif>
    <div class="preview-logo-wrapper d-inline-block">
        <label class="{{ $classLabel }}">{{ $title }}</label>
        <img @if(isset($idPreviewImage)) id="{{ $idPreviewImage }}" @endif class="preview-img-custom {{ $classPreviewImage }}" src="{{ $defaultPreviewImage }}" alt="your image">
    </div>
    <div class="wrapper-upload-action d-inline-block">
        <div class="btn-upload-logo-wraper">
            <button class="btn btn-primary ks-btn-file {{ $btnUploadClass }}">
                <span class="ks-icon icon-upload-custom {{ $iconBtnUpload }}"></span>
                <span class="ks-text">{{ $textBtnUpload }}</span>
                <input @if(isset($idInputFile)) id="{{ $idInputFile }}" @endif type="file" onchange="window.readURL(this);"
                       class="filestyle input-file-upload-custom {{ $classInputFile }}" data-btnclass="btn-primary" name="{{ $name }}"
                       accept="image/*"
                    @foreach($attributes as $key => $val)
                        {{ $key. '='. $val. ' ' }}
                    @endforeach
                >
            </button>
        </div>
    </div>
    @if($parseErrorLaravel)
        @if ($errors->has($name))
            <ul class="{{$classError}}" data-validation="eden-validation" data-field="{{ isset($validateName) ? $validateName : $name }}">
                <li><strong>{{ $errors->first($name) }}</strong></li>
            </ul>
        @endif
    @endif
    @if($parseErrorForm)
        <ul class="{{$classError}}" data-validation="eden-validation" data-field="{{ isset($validateName) ? $validateName : $name }}"></ul>
    @endif
</div>
