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
            "Date","Nome Commerciale","Nome Utente","Città","Nome Listino","Numero Ricaricato","Operatore Mobile","Importo Ricarica Euro","Sconto utente","Sovrapprezzo applicato da utente","Guadagno totale utente","Vendita finale ricarica","Costo ricarica a Yuma","Sconto fornitore","Profitto Lordo Yuma","Profitto Netto Yuma"
        ];
    }

    public function map($row): array
    {
        return [
            $row->created_at,
            $row->user->company_data->company_name,
            $row->user->name,
            $row->user->company_data->operative_seat_city,
            $row->user->group->name,
            $row->request_recipent_phone,
            $row->operator->name,
            $row->user_old_plafond - $row->user_new_plafond + $row->user_discount,
            $row->user_discount,
            $row->user_gain,
            $row->user_total_gain,
            $row->user->final_amount,
            $row->sent_amount,
            $row->platform_commission,
            $row->platform_total_gain,
            $row->platform_total_gain - $row->user_discount
        ];
    }
}

