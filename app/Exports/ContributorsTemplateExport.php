<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Override;

class ContributorsTemplateExport implements FromArray, WithHeadings
{
    public function array():array
    {
        return [
            ['John Doe', '255710101010', 2, 'invited'],
        ];
    }

    public function headings(): array
    {
        return ['name','phone_no', 'assigned_seats', 'status'];        
    }
}
