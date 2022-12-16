<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect([[
            'Symbol' => 'bitcoin',
            'Buy/Sell' => 'buy',
            'Units' => '0',
            'Price per unit' => '17450',
            'Purchase Date' => '2022/12/16'
        ]]);
    }
    public function headings(): array
    {
        return [
            'Symbol',
            'Buy/Sell',
            'Units',
            'Price per unit',
            'Purchase Date'
        ];
    }
}
