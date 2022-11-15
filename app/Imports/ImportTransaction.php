<?php

namespace App\Imports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportTransaction implements ToCollection
{
    public function collection(Collection $row)
    {
        return $row;
    }
}
