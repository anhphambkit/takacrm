<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-09
 * Time: 08:32
 */
?>
<div class="card">
    <div class="card-content collpase show">
        <div class="card-body">
            <div class="btn-set">
                @php do_action(BASE_ACTION_FORM_ACTIONS, 'default') @endphp
                <button type="submit" name="submit" value="save" class="btn btn-info">
                    <i class="fa fa-save"></i> {{ trans('core-base::forms.save') }}
                </button>
                @if (!isset($only_save) || $only_save == false)
                    <button type="submit" name="submit" value="apply" class="btn btn-success">
                        <i class="fa fa-check-circle"></i> {{ trans('core-base::forms.save_and_continue') }}
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
