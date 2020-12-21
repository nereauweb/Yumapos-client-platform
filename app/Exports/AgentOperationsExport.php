<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AgentOperationsExport implements FromCollection, WithHeadings, WithMapping
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

    // map function holds format of what to show in the data cells below headings
    public function map($row): array
    {
        return [
            $row->pointOperation->created_at,
            $row->pointOperation->user->company_data->company_name ?? 'Not set',
            $row->pointOperation->user->name ?? 'Not set',
            $row->pointOperation->user->company_data->operative_seat_city ?? 'Not set',
            $row->pointOperation->user->group->name ?? 'Not set',
            $row->pointOperation->request_recipent_phone,
            $row->pointOperation->operator->name ?? 'Not set',
            $row->pointOperation->user_old_plafond - $row->pointOperation->user_new_plafond + $row->pointOperation->user_discount,
            $row->pointOperation->user_discount,
            $row->pointOperation->user_gain,
            $row->pointOperation->user_total_gain,
            $row->pointOperation->user->final_amount ?? 'Not set',
            $row->pointOperation->sent_amount,
            $row->pointOperation->platform_commission,
            $row->pointOperation->platform_total_gain,
            $row->pointOperation->platform_total_gain - $row->pointOperation->user_discount
        ];
    }
}
