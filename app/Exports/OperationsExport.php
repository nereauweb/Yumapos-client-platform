<?php

namespace App\Exports;

use App\Models\ServiceOperation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OperationsExport implements FromCollection, WithHeadings
{
    public function __construct(\Illuminate\Database\Eloquent\Collection $operations)
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
            "id","user_id","api_reloadly_calls_id","api_reloadly_operations_id","reloadly_transactionId","result","request_operatorId","request_amount","request_local","request_country_iso","request_recipient_phone","original_expected_destination_amount","final_expected_destination_amount","sent_amount","user_amount","user_gain","final_amount","user_discount","platform_commission","user_old_plafond","user_new_plafond","user_total_gain","platform_total_gain","created_at"
        ];
    }
	
}
