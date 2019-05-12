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
    }
}
