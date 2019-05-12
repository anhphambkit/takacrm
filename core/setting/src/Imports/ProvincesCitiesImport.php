<?php

namespace Core\Setting\Imports;

use Core\Setting\Models\ProvinceCity;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class ProvincesCitiesImport implements ToModel, WithProgressBar, WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ProvinceCity([
            'code'          => $row['code'],
            'name'          => $row['name'],
            'english_name'  => $row['english_name'],
//            'country_code'  => $row[''],
            'type_level'    => $row['level'],
            'order'    => $row['order'],
        ]);
    }
}
