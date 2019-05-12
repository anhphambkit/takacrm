<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-29
 * Time: 17:51
 */

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Core\Setting\Contracts\ReferenceConfig;

class DataSettingReferenceSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Database\Eloquent\Model::unguard();

        $now = Carbon::now();

        // Delete + Insert Type Gender:
        $genders =[
            [
                'value' => ReferenceConfig::REFERENCE_MALE_GENDER,
                'slug' => str_slug(ReferenceConfig::REFERENCE_MALE_GENDER),
                'type' => ReferenceConfig::REFERENCE_TYPE_GENDER,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'value' => ReferenceConfig::REFERENCE_FEMALE_GENDER,
                'slug' => str_slug(ReferenceConfig::REFERENCE_FEMALE_GENDER),
                'type' => ReferenceConfig::REFERENCE_TYPE_GENDER,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('references')->where('type', ReferenceConfig::REFERENCE_TYPE_GENDER)->delete();
        DB::table('references')->insert($genders);

        // Delete + Insert Reference Data:
        $referenceDataCustomer = [
            [
                'value' => ReferenceConfig::REFERENCE_USER_DATA,
                'slug' => str_slug(ReferenceConfig::REFERENCE_USER_DATA),
                'type' => ReferenceConfig::REFERENCE_TYPE_CUSTOMER_DATA,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'value' => ReferenceConfig::REFERENCE_CUSTOMER_DATA,
                'slug' => str_slug(ReferenceConfig::REFERENCE_CUSTOMER_DATA),
                'type' => ReferenceConfig::REFERENCE_TYPE_CUSTOMER_DATA,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];
        DB::table('references')->where('type', ReferenceConfig::REFERENCE_TYPE_CUSTOMER_DATA)->delete();
        DB::table('references')->insert($referenceDataCustomer);
    }
}
