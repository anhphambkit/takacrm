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
                'value' => CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_STRING,
                'slug' => str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_STRING, '_'),
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
