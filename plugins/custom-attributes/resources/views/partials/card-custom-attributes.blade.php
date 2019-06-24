<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-15
 * Time: 11:18
 */
$entityId = !empty($entityId) ? $entityId : null;
$classFieldWrapper = !empty($classFieldWrapper) ? $classFieldWrapper : 'form-group col-md-12 mb-2';
?>
{{--Custom Attribute--}}
<div class="card">
    <div class="card-header">
        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-custom-attributes::custom-attributes.name') }}</h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse show">
        <div class="card-body">
            <div class="form-body">
                <div class="row">
                    @foreach($allCustomAttributes as $allCustomAttribute)
                            @component('plugins-custom-attributes::components.custom-field')
                                @slot('customAttributeEntity', $allCustomAttribute)
                                @slot('entityId', $entityId)
                                @slot('classFieldWrapper', $classFieldWrapper)
                            @endcomponent
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
{{--End Custom Attribute--}}
