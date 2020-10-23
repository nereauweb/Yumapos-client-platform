<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    private $users;

    public function __construct(Collection $users)
    {
        $this->users = $users;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->users;
    }

    public function headings(): array
    {
        return [
            'Shop sign', 'Company name', 'VAT', 'Operative seat address', 'ZIP', 'City', 'Email', 'Phone'
        ];
    }

}
