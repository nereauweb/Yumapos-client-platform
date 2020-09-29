<?php

namespace App\Http\Controllers;

use App\Models\ApiReloadlyCall;
use App\Models\ServiceOperation;
use App\User;
use Auth;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OperationsExport;
use App\Exports\SimpleOperationsExport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function operations(Request $request)
    {
		$users = User::pluck('name','id');
		$user_name = "All users";
		$user_id = 0;
		if ($request->input('user') && $request->input('user')!=0){
			$user = User::find($request->input('user'));			
			$user_name = $user->name;
			$user_id = $user->id;
		}	
		$date_begin = $request->input('date_begin') ? $request->input('date_begin') . ' 00:00:00' : date("Y-m-d") . ' 00:00:00';
		$date_end = $request->input('date_end') ? $request->input('date_end') . ' 23:59:59' : date("Y-m-d") . ' 23:59:59';
		$operations = ServiceOperation::where('created_at','>=',$date_begin)->where('created_at','<=',$date_end);
		if($user_id!=0){
			$operations->where('user_id',$user_id);
		}
		$operations = $operations->get();	
        return view('admin/report/operations',compact('operations','date_begin','date_end','users','user_name','user_id'));
    }
	
	public function export_operations(Request $request)
    {
		$date_begin = $request->input('date_begin') ? $request->input('date_begin') . ' 00:00:00' : date("Y-m-d") . ' 00:00:00';
		$date_end = $request->input('date_end') ? $request->input('date_end') . ' 23:59:59' : date("Y-m-d") . ' 23:59:59';
		$operations = ServiceOperation::select("id","user_id","api_reloadly_calls_id","api_reloadly_operations_id","reloadly_transactionId","result","request_operatorId","request_amount","request_local","request_country_iso","request_recipient_phone","original_expected_destination_amount","final_expected_destination_amount","sent_amount","user_amount","user_gain","final_amount","user_discount","platform_commission","user_old_plafond","user_new_plafond","user_total_gain","platform_total_gain","created_at")->where('created_at','>=',$date_begin)->where('created_at','<=',$date_end)->get();
        return Excel::download(new OperationsExport($operations), 'operations.xlsx');
    }
		
	
	public function export_operations_simple(Request $request)
    {
		$date_begin = $request->input('date_begin') ? $request->input('date_begin') . ' 00:00:00' : date("Y-m-d") . ' 00:00:00';
		$date_end = $request->input('date_end') ? $request->input('date_end') . ' 23:59:59' : date("Y-m-d") . ' 23:59:59';
		$operations = DB::table('service_operations')		
					->join('users', 'users.id', '=', 'service_operations.user_id')
					->join('users_company_data as companies', 'companies.user_id', '=', 'service_operations.user_id')
					->join('api_reloadly_operators as operators', 'operators.operatorId', '=', 'service_operations.request_operatorId')
					->join('users_groups as groups', 'groups.id', '=', 'users.group_id')
					->selectRaw('
						service_operations.created_at,
						companies.company_name,
						users.name as user_name,
						companies.operative_seat_city,
						groups.name as group_name,
						service_operations.request_recipient_phone,
						operators.name as operator_name,
						(service_operations.user_old_plafond - service_operations.user_new_plafond + service_operations.user_discount) as user_amount,				
						service_operations.user_discount,
						service_operations.user_gain,
						service_operations.user_total_gain,	
						service_operations.final_amount,						
						service_operations.sent_amount,						
						service_operations.platform_commission,			
						service_operations.platform_total_gain,
						(service_operations.platform_total_gain - service_operations.user_discount) as platform_net_total_gain
						')									
					->where('service_operations.created_at','>=',$date_begin)
					->where('service_operations.created_at','<=',$date_end);
		if($request->input('user')){
			$operations->where('service_operations.user_id',$request->input('user'));
		}
		$operations = $operations->get();
        return Excel::download(new SimpleOperationsExport($operations), 'operations.xlsx');
		
		//"Data","Nome Commerciale","Nome Utente","Città","Nome Listino","Numero Ricaricato","Operatore Mobile","Importo Ricarica Euro","Sconto utente","Sovrapprezzo applicato da utente","Guadagno totale utente","Vendita finale ricarica","Costo ricarica a Yuma","Sconto fornitore","Profitto Lordo Yuma","Profitto Netto Yuma"
		//"Costo Netto a Yuma","Incasso da Utente","Provvigione Commerciale","Fee da Utente","Provvigione per Utente","Profitto Utente","Vendita finale ricarica"
		
    }
	
    public function calls(Request $request)
    {
		$date_begin = $request->input('date_begin') ? $request->input('date_begin') . ' 00:00:00' : date("Y-m-d") . ' 00:00:00';
		$date_end = $request->input('date_end') ? $request->input('date_end') . ' 23:59:59' : date("Y-m-d") . ' 23:59:59';
		$operations = ApiReloadlyCall::where('created_at','>=',$date_begin)->where('created_at','<=',$date_end)->get();
        return view('admin/report/calls',compact('operations','date_begin','date_end'));
    }
	
}
