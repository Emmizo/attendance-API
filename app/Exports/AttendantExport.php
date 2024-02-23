<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Attendant;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendantExport implements FromCollection,WithHeadings
{

    public function headings():array{
        return[
            'Id',
            'first name',
            'Last name',
            'Email',
            'Identity',
            'Phone Number',
            'Entry',
            'Exit' 
        ];
    } 
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Attendant::join('users','users.id','attendants.user_id')
        ->join('employees','employees.id','attendants.emp_id')
        ->select('attendants.id as attendant_id','employees.*','users.name as created_by' ,'attendants.started_at','attendants.ended_at','attendants.status')
        ->orderBy('attendants.updated_at','desc')->get();
        //
    }
}