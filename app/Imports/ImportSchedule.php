<?php

namespace App\Imports;

use App\Schedule;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportSchedule implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Schedule([
            //
        ]);
    }
}
