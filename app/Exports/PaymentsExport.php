<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PaymentsExport implements FromCollection, WithHeadings, WithMapping
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
                'date', 'amount', 'type', 'details', 'is approved', 'created_at', 'updated_at'
            ];
        }

        return [
            "id","date","user_id","user name","provider company name","is approved","amount","details","created_at","updated_at"
        ];
    }

    // map function returns the data needed to be shown below the headings
    // here are two conditions which would return an excel file differently, based on the role of user
    public function map($row): array
    {
        if ($this->type == 'user') {
            return [
                $row->date,
                $row->amount,
                $row->type == 1 ? 'Approved' : 'Not Approved',
                $row->details,
                date('d/m/Y H:i', strtotime($row->created_at)),
                date('d/m/Y H:i', strtotime($row->updated_at)),
            ];
        } else {
            return [
                $row->id,
                $row->date,
                $row->user_id,
                $row->name,
                $row->company_name,
                $row->type == 1 ? 'Approved' : 'Not Approved',
                $row->amount,
                $row->details,
                date('d/m/Y H:i', strtotime($row->created_at)),
                date('d/m/Y H:i', strtotime($row->updated_at)),
            ];
        }
    }

}
