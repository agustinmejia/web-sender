<?php

namespace App\Imports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\ToModel;

class ContactsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $phone = strlen($row[1]) == 8 ? '591'.$row[1] : $row[1];
        $contact = Contact::where('phone', $phone)->first();
        if(!$contact && $phone){
            return Contact::create([
                'full_name' => $row[0],
                'phone' => $phone
            ]);
        }
    }
}
