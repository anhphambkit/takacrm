<?php

namespace Core\Setting\Imports;

use Core\Setting\Models\District;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class DistrictsVNImport implements ToModel, WithProgressBar, WithHeadingRow
{
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new District([
            'code'                  => $row['code'],
            'name'                  => $row['name'],
            'english_name'          => $row['english_name'],
            'city_province_code'    => $row['city_province_code'],
            'type_level'            => $row['level']
        ]);
    }
}
