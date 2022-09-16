<?php

namespace App\Imports;

use App\Models\Enquiry;
use App\Models\Dealer;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportEnquiries implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $Dealer = Dealer::where('name','=',$row[0])->first();
        $dealer_id = $Dealer == null ? 0: $Dealer->id;
        //dd($Dealer);
        return new Enquiry([
            'dealer_id' => $dealer_id,
            'name' => $row[1],
            'contact_no' => $row[2],
            'status' => 2,
            'date' => date('Y-m-d')
        ]);
    }
}
