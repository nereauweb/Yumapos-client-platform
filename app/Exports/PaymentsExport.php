<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentsExport implements FromCollection, WithHeadings
{
    public function __construct(\Illuminate\Database\Eloquent\Collection $payments)
    {
        $this->payments = $payments;
    }
	
    public function collection()
    {
        return $this->payments;
    }
	
	public function headings(): array
    {
        return [
            "id","date","user_id","user name","amount","details","created_at","updated_at"
        ];
    }
	
}
