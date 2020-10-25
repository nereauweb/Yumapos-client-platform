<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserOperationsExport implements FromCollection, WithHeadings, WithMapping
{
    private $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->collection;
    }

    public function headings(): array
    {
        return [
            "Operatore","Numero Ricaricato","Importo Ricarica", "Sovrapprezzo al cliente", "Totale Ricarica", "Sconto piattaforma", "Guadagno totale", "data"
        ];
    }

    public function map($row): array
    {
        return [
            $row->operator->name.' ('.$row->operator->country->name.')',
            $row->request_recipient_phone,
            $row->user_amount,
            $row->user_gain,
            $row->final_amount,
            $row->user_discount,
            $row->user_total_gain,
            date('d/m/Y H:i', strtotime($row->created_at)),
        ];
    }
}

