<?php

namespace Core\Setting\Commands\Scripts;

use Core\Setting\Imports\DistrictsVNImport;
use Core\Setting\Imports\WardsVNImport;
use Core\Setting\Imports\ProvincesCitiesImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportDataCityWardVietNam extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:city-ward-vn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /*
        |--------------------------------------------------------------------------
        | Import City Provinces VN:
        |--------------------------------------------------------------------------
        |
        |
        */

        // Truncate DB before import:
        $replace = $this->ask('Do you want replace all data of ProvincesCities Table? (y/n)');
        if ($replace == 'n' || $replace == 'N' || $replace == 'no' || $replace == 'No' || $replace == 'NO'){
            $isReplace = false;
        }
        else $isReplace = true;

        if ($isReplace) {
            DB::table('provinces_cities')->truncate();
        }
        // End truncate DB:

        $cityFilePath = public_path('storage/imports/provinces_vn.xls');
        $this->output->title('Starting import provinces and cities of VN:');
        (new ProvincesCitiesImport())->withOutput($this->output)->import($cityFilePath);
        $this->output->success('Import provinces and cities of VN successful');
        /*
        |============================ END Import City Provinces VN: ========================
        */


        /*
        |--------------------------------------------------------------------------
        | Import Districts VN:
        |--------------------------------------------------------------------------
        |
        |
        */

        // Truncate DB before import:
        $replace = $this->ask('Do you want replace all data of Districts Table? (y/n)');
        if ($replace == 'n' || $replace == 'N' || $replace == 'no' || $replace == 'No' || $replace == 'NO'){
            $isReplace = false;
        }
        else $isReplace = true;

        if ($isReplace) {
            DB::table('districts')->truncate();
        }
        // End truncate DB:
        $districtFilePath = public_path('storage/imports/districts_vn.xls');
        $this->output->title('Starting import districts of VN:');
        (new DistrictsVNImport())->withOutput($this->output)->import($districtFilePath);
        $this->output->success('Import districts of VN successful');
        /*
         |============================ END Import Districts VN: ========================
         */

        /*
        |--------------------------------------------------------------------------
        | Import Wards VN:
        |--------------------------------------------------------------------------
        |
        |
        */

        // Truncate DB before import:
        $replace = $this->ask('Do you want replace all data of Wards Table? (y/n)');
        if ($replace == 'n' || $replace == 'N' || $replace == 'no' || $replace == 'No' || $replace == 'NO'){
            $isReplace = false;
        }
        else $isReplace = true;

        if ($isReplace) {
            DB::table('wards')->truncate();
        }
        // End truncate DB:
        $wardFilePath = public_path('storage/imports/wards_vn.xls');
        $this->output->title('Starting import wards of VN:');
        (new WardsVNImport())->withOutput($this->output)->import($wardFilePath);
        $this->output->success('Import wards of VN successful');
        /*
        |============================ END Import Wards VN: ========================
        */
    }
}
