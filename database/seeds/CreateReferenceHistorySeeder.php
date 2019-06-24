<?php

use Illuminate\Database\Seeder;
use Plugins\History\Contracts\HistoryReferenceConfig;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CreateReferenceHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		\Illuminate\Database\Eloquent\Model::unguard();

        $references = [
        	HistoryReferenceConfig::REFERENCE_HISTORY_ACTION_CREATE,
			HistoryReferenceConfig::REFERENCE_HISTORY_ACTION_UPDATE,
			HistoryReferenceConfig::REFERENCE_HISTORY_ACTION_DELETE
        ];

        foreach ($references as $reference) {
        	$exists = DB::table('references')
        		->where('type', HistoryReferenceConfig::REFERENCE_HISTORY_ACTION)
        		->where('value', $reference)
        		->exists();

        	if(!$exists){
        		DB::table('references')->insert([
					'type'       => HistoryReferenceConfig::REFERENCE_HISTORY_ACTION,
					'value'      => $reference,
					'slug'       => str_slug($reference),
					'order'      => 0,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now(),
        		]);
        		print_r("\nInsert new reference with value : {$reference}");
        	}
        }
        print_r("\n");
    }
}
