<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentsExport implements FromCollection, WithHeadings
{
    public function __construct(\Illuminate\Database\Eloquent\Collection $payments, $type = null)
    {
        $this->payments = $payments;
        $this->type = $type;
    }

    public function collection()
    {
        return $this->payments;
    }

	public function headings(): array
    {
        if ($this->type == 'user') {
            return [
                'id', 'date', 'amount', 'type', 'details', 'approved', 'created_at', 'updated_at'
            ];
        }

        return [
            "id","date","user_id","user name","provider company name","amount","details","created_at","updated_at"
        ];
    }

}
