<?php

namespace Core\Base\Providers;

use Form;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{

    /**
     * Boot the service provider.
     * @return void
     * @author TrinhLe
     */
    public function boot()
    {
        Form::component('mediaImage', 'core-base::elements.forms.image', [
            'name',
            'value' => null,
            'attributes' => [],
        ]);

        Form::component('modalAction', 'core-base::elements.forms.modal', [
            'name',
            'title',
            'type' => null,
            'content' => null,
            'action_id' => null,
            'action_name' => null,
        ]);

        Form::component('error', 'core-base::elements.forms.error', [
            'name',
            'errors' => null,
        ]);

        Form::component('onOff', 'core-base::elements.forms.on-off', [
            'name',
            'value' => false,
            'attributes' => [],
        ]);

        Form::component('onOffPretty', 'core-base::elements.forms.on-off-pretty', [
            'name',
            'value' => false,
            'attributes' => [],
            'classSwitch' => '',
        ]);
        
        Form::component('radioPretty', 'core-base::elements.forms.radio-pretty', [
            'name',
            'value'      => false,
            'title'      => '',
            'attributes' => [],
            'default'    => 0
        ]);

        /**
         * Custom checkbox
         * Every checkbox will not have the same name
         */
        Form::component('customCheckbox', 'core-base::elements.custom-checkbox', [
            /**
             * @var array $values
             * @template: [
             *      [string $name, string $value, string $label, bool $selected, bool $disabled],
             *      [string $name, string $value, string $label, bool $selected, bool $disabled],
             *      [string $name, string $value, string $label, bool $selected, bool $disabled],
             * ]
             */
            'values',
        ]);

        Form::component('lookBookImage', 'core-base::elements.forms.image-look-book', [
            'name',
            'value' => null,
            'tags' => [],
            'typeLayout' => 'normal',
            'attributes' => [],
        ]);

        Form::component('mediaGallery', 'core-base::elements.forms.gallery', [
            'name',
            'value' => null,
            'attributes' => [],
        ]);
    }
}
