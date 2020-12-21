<?php

namespace App\Exports;

use App\Models\ServiceOperation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SimpleOperationsExport implements FromCollection, WithHeadings
{
    public function __construct(\Illuminate\Support\Collection $operations)
    {
        $this->operations = $operations;
    }

    public function collection()
    {
        return $this->operations;
    }

	public function headings(): array
    {
        return [
			"Data","Nome Commerciale","Id utente","Nome Utente","Città","Nome Listino","Numero Ricaricato","Operatore Mobile","Importo Ricarica Euro","Sconto utente","Sovrapprezzo applicato da utente","Guadagno totale utente","Vendita finale ricarica","Costo ricarica a Yuma","Sconto fornitore","Profitto Lordo Yuma","Profitto Netto Yuma","Nuovo plafond utente"
        ];
    }

}
