<?php

namespace Core\Setting\Imports;

use Core\Setting\Models\Ward;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class WardsVNImport implements ToModel, WithHeadingRow, WithProgressBar
{
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Ward([
            'code'          => $row['code'],
            'name'          => $row['name'],
            'english_name'  => $row['english_name'],
            'district_code' => $row['district_code'],
            'type_level'    => $row['level']
        ]);
    }
}
