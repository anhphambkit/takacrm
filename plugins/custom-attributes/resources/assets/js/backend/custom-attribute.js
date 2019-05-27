/*=========================================================================================
    File Name: custom-attribute.js
    ----------------------------------------------------------------------------------------
    Author: Anh Pham
==========================================================================================*/

import axios from 'axios';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Change type render:
$(document).on('change', '#select-type-render-list', function () {
    let typeRender = $(this).val();
    $('.options-area').html('');
    if (typeRender === 'checkbox' || typeRender === 'radio' || typeRender === 'single_select' || typeRender === 'multiple_select') {
        let option = parseOptionAttribue(optionIndex);
        optionIndex++;
        $('.options-area').append(option);
        $('.list-option-area').show();
    }
    else {
        $('.list-option-area').hide();
    }
});

// add option
$(document).on('click', '.action-option-attribute.add-option', function () {
    let option = parseOptionAttribue(optionIndex);
    optionIndex++;
    $('.options-area').append(option);
    $('.list-option-area').show();
});

// delete option
$(document).on('click', '.delete-option-action.delete-option', function () {
    let index = $(this).data('option-index');
    $(`.option-attribute.option-attribute-${index}`).remove();
});

function parseOptionAttribue(optionIndex) {
    let option = `<div class="row option-attribute option-attribute-${optionIndex}">
                    <div class="form-group col-md-6">
                        <label class="control-label required" for="role">Option</label>
                        <input type="text" class="form-control option-attribute-name option-attribute-${optionIndex}" id="option-attribute-${optionIndex}" name="attribute_options[${optionIndex}]" placeholder="Name" data-counter="150">
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label" for="action-delete-option">Action</label>
                        <div class="action-option-area">
                            <a class="action-option delete-option-action delete-option delete-option-${optionIndex}" data-option-index="${optionIndex}">
                                <i class="far fa-trash-alt icon-option-delete"></i>
                                Delete
                            </a>
                        </div>
                    </div>
                </div>`;
    return option;
}