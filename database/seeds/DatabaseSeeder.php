<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(DataReferenceOrderSeeder::class);
         $this->call(CreateReferenceHistorySeeder::class);
         $this->call(DataCustomAttributesReferenceSeeder::class);
         $this->call(DataSettingReferenceSeeder::class);
    }
}
