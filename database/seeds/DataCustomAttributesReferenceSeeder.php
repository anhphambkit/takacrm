<?php

use Illuminate\Database\Seeder;
use Plugins\CustomAttributes\Contracts\CustomAttributeConfig;

class DataCustomAttributesReferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();

        // Delete + Insert Type Custom Attributes Layout:
        \Illuminate\Support\Facades\DB::table('references')
            ->where('type', CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER)
            ->where('value', 'String')
            ->delete();

        $references =[
            [
                'value' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_PRODUCT,
                'slug' => str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_PRODUCT, '_'),
                'type' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY,
                'order' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'value' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_CUSTOMER,
                'slug' => str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_CUSTOMER, '_'),
                'type' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY,
                'order' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'value' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_ORDER,
                'slug' => str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY_ORDER, '_'),
                'type' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY,
                'order' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],


            [
                'value' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_TEXT_INPUT,
                'slug' => str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_TEXT_INPUT, '_'),
                'type' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER,
                'order' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'value' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_TEXTAREA,
                'slug' => str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_TEXTAREA, '_'),
                'type' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER,
                'order' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'value' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_NUMBER_INPUT,
                'slug' => str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_NUMBER_INPUT, '_'),
                'type' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER,
                'order' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'value' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_CHECKBOX,
                'slug' => str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_CHECKBOX, '_'),
                'type' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER,
                'order' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'value' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_RADIO,
                'slug' => str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_RADIO, '_'),
                'type' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER,
                'order' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'value' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_SINGLE_SELECT,
                'slug' => str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_SINGLE_SELECT, '_'),
                'type' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER,
                'order' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'value' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_MULTIPLE_SELECT,
                'slug' => str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_MULTIPLE_SELECT, '_'),
                'type' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER,
                'order' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'value' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_URL_INPUT,
                'slug' => str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_URL_INPUT, '_'),
                'type' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER,
                'order' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'value' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_DATE_TIME_INPUT,
                'slug' => str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_DATE_TIME_INPUT, '_'),
                'type' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER,
                'order' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'value' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_COLOR_PICKER,
                'slug' => str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_COLOR_PICKER, '_'),
                'type' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER,
                'order' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        foreach ($references as $reference) {
            \Core\Setting\Models\Reference::updateOrCreate(
                [
                    'value' => $reference['value'],
                    'type' => $reference['type']
                ],
                [
                    'slug' => $reference['slug'],
                ]
            );
        }
    }
}
