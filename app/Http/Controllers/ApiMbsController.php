<?php

namespace App\Http\Controllers;

use App\Models\AgentOperation;
use App\Models\ApiMbsCall;
use App\Models\ApiMbsProduct;
use App\Models\ApiMbsOperation;
use App\Models\ServiceOperation;
use App\Models\ServiceOperator;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiMbsController extends Controller
{
	private $url  = "https://www.mbspay.it/webservicesmbspay/webservicesmbs.php";
	private $key = '!AlmjKma3Wi94w!';
	private $id_esercente = '1';
	private $codice_distributore = '1022';
	private $cab_distributore = '4b022';
	private $utente_distributore = 'almama';
	public $operation_id = '';
	public $log = '';
	public $call_id = 0;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|user|sales');
    }

	

	public function index(Request $request)
	{
		$products = ApiMbsProduct::orderBy('Operatore','ASC')->orderBy('Tipo', 'ASC')->orderBy('PrezzoUtente', 'ASC')->get();
		$providers_ricarica = [
			"DigiMobile",
			"FastWeb",
			"H3g",
			"Ho",
			"Iliad",
			"Kena",
			"Linkem",
			"Lyca",
			"PosteMobile",
			"Tim",
			"UnoMobile",
			"VeryMobile",
			"Vodafone",
			"Wind",
		];		
		return view('admin/api/mbs/command-list',compact('products','providers_ricarica'));
	}
	
	public function balance(Request $request)
	{
		$debug = [];
		$operation_name = 'Balance';
		$this->generate_operation_id (Auth::user()->id);
		$fields = [
			'Distributore' => $this->codice_distributore,
			'Utente' => $this->utente_distributore,
			'CabEsercente' => $this->cab_distributore,
			'IDOperazione' => $this->operation_id,
			'Firma' => $this->signature(Auth::user()->id),
			'Servizio' => 'Balance'
		];
		$result = $this->call($fields);
		return view('admin/api/mbs/result',compact('debug','operation_name','result'));
	}
	
	public function list_prefix(Request $request)
	{
		$debug = [];
		$operation_name = 'Lista prefissi internazionali';
		$this->generate_operation_id (Auth::user()->id);
		$fields = [
			'Distributore' => $this->codice_distributore,
			'Utente' => $this->utente_distributore,
			'CabEsercente' => $this->cab_distributore,
			'IDOperazione' => $this->operation_id,
			'Firma' => $this->signature(Auth::user()->id),
			'Servizio' => 'ListaPrefissiInternazionali'
		];
		$result = $this->call($fields);
		return view('admin/api/mbs/result',compact('debug','operation_name','result'));
	}
	
	public function beneficiario_bollettino(Request $request)
	{
		$debug = [];
		$operation_name = 'RICHIESTA BENEFICIARIO';
		$this->generate_operation_id (Auth::user()->id);
		$fields = [
			'Distributore' => $this->codice_distributore,
			'Utente' => $this->utente_distributore,
			'CabEsercente' => $this->cab_distributore,
			'IDOperazione' => $this->operation_id,
			'Firma' => $this->signature(Auth::user()->id),
			'Servizio' => 'ContoCorrenteNF',
			'ContoCorrente' => $request->ContoCorrente
		];
		$result = $this->call($fields);
		return view('admin/api/mbs/result',compact('debug','operation_name','result'));
	}
	
	public function pagamento_bollettino(Request $request)
	{
		$debug = [];
		$operation_name = 'PAGAMENTO BOLLETTINO PREMARCATO';
		$this->generate_operation_id (Auth::user()->id);
		$fields = [
			'Distributore' => $this->codice_distributore,
			'Utente' => $this->utente_distributore,
			'CabEsercente' => $this->cab_distributore,
			'IDOperazione' => $this->operation_id,
			'Firma' => $this->signature(Auth::user()->id),
			'Servizio' => 'BollettinoNF',
			'TipoContoCorrente' => $request->TipoContoCorrente,
			'ContoCorrente' => $request->ContoCorrente,
			'Beneficiario' => $request->Beneficiario,
			'Identificativo' => $request->Identificativo,
			'Importo' => $request->Importo,
			'Causale' => $request->Causale,
			'EmailOrdinante' => $request->EmailOrdinante,
			'CellulareOrdinante' => $request->CellulareOrdinante,
			'Nome' => $request->Nome,
			'Cognome' => $request->Cognome,
			'Indirizzo' => $request->Indirizzo,
			'Citta' => $request->Citta,
			'Cap' => $request->Cap,
			'NomeUtente' => $request->NomeUtente,
			'CognomeUtente' => $request->CognomeUtente,
			'CittaUtente' => $request->CittaUtente,
			'IndirizzoUtente' => $request->IndirizzoUtente,
			'RagioneSocialeMerch' => $request->RagioneSocialeMerch,
		];
		$result = $this->call($fields);
		return view('admin/api/mbs/result',compact('debug','operation_name','result'));
	}
	
	public function pagamento_bollettino_mav(Request $request)
	{
		$debug = [];
		$operation_name = 'PAGAMENTO BOLLETTINO MAV';
		$this->generate_operation_id (Auth::user()->id);
		$fields = [
			'Distributore' => $this->codice_distributore,
			'Utente' => $this->utente_distributore,
			'CabEsercente' => $this->cab_distributore,
			'IDOperazione' => $this->operation_id,
			'Firma' => $this->signature(Auth::user()->id),
			'Servizio' => 'pagaBollettinoMav',
			'Identificativo' => $request->Identificativo,
			'Importo' => $request->Importo,
			'Nome' => $request->Nome,
			'Cognome' => $request->Cognome,
			'NomeUtente' => $request->NomeUtente,
			'CognomeUtente' => $request->CognomeUtente,
			'CittaUtente' => $request->CittaUtente,
			'IndirizzoUtente' => $request->IndirizzoUtente,
			'RagioneSocialeMerch' => $request->RagioneSocialeMerch,
		];
		$result = $this->call($fields);
		return view('admin/api/mbs/result',compact('debug','operation_name','result'));
	}	
	
	public function pagamento_bollettino_rav(Request $request)
	{
		$debug = [];
		$operation_name = 'PAGAMENTO BOLLETTINO RAV';
		$this->generate_operation_id (Auth::user()->id);
		$fields = [
			'Distributore' => $this->codice_distributore,
			'Utente' => $this->utente_distributore,
			'CabEsercente' => $this->cab_distributore,
			'IDOperazione' => $this->operation_id,
			'Firma' => $this->signature(Auth::user()->id),
			'Servizio' => 'pagaBollettinoRav',
			'Identificativo' => $request->Identificativo,
			'Importo' => $request->Importo,
			'Nome' => $request->Nome,
			'Cognome' => $request->Cognome,
			'NomeUtente' => $request->NomeUtente,
			'CognomeUtente' => $request->CognomeUtente,
			'CittaUtente' => $request->CittaUtente,
			'IndirizzoUtente' => $request->IndirizzoUtente,
			'RagioneSocialeMerch' => $request->RagioneSocialeMerch,
		];
		$result = $this->call($fields);
		return view('admin/api/mbs/result',compact('debug','operation_name','result'));
	}	
	
	public function richiesta_biller(Request $request)
	{
		$debug = [];
		$operation_name = 'RICHIESTA BILLER';
		$this->generate_operation_id (Auth::user()->id);
		$fields = [
			'Distributore' => $this->codice_distributore,
			'Utente' => $this->utente_distributore,
			'CabEsercente' => $this->cab_distributore,
			'IDOperazione' => $this->operation_id,
			'Firma' => $this->signature(Auth::user()->id),
			'Servizio' => 'CercaBiller',
			'Codice' => $request->Codice
		];
		$result = $this->call($fields);
		return view('admin/api/mbs/result',compact('debug','operation_name','result'));
	}
	
	
	public function pagamento_bollettino_cbill(Request $request)
	{
		$debug = [];
		$operation_name = 'PAGAMENTO BOLLETTINO CBILL';
		$this->generate_operation_id (Auth::user()->id);
		$fields = [
			'Distributore' => $this->codice_distributore,
			'Utente' => $this->utente_distributore,
			'CabEsercente' => $this->cab_distributore,
			'IDOperazione' => $this->operation_id,
			'Firma' => $this->signature(Auth::user()->id),
			'Servizio' => 'pagaBollettinoCbill',
			'CodiceBollettino' => $request->CodiceBollettino,
			'SiaCode' => $request->SiaCode,
			'Agenzia' => $request->Agenzia,
			'CodiceFiscale' => $request->CodiceFiscale,
			'ImportoBollettino' => $request->ImportoBollettino,
			'NomeUtente' => $request->NomeUtente,
			'CognomeUtente' => $request->CognomeUtente,
			'CittaUtente' => $request->CittaUtente,
			'IndirizzoUtente' => $request->IndirizzoUtente,
			'RagioneSocialeMerch' => $request->RagioneSocialeMerch,
		];
		$result = $this->call($fields);
		return view('admin/api/mbs/result',compact('debug','operation_name','result'));
	}
	
	
	public function ricarica_telefonica(Request $request)
	{
		$debug = [];
		$operation_name = 'RICARICA TELEFONICA';
		$this->generate_operation_id (Auth::user()->id);
		$fields = [
			'Distributore' => $this->codice_distributore,
			'Utente' => $this->utente_distributore,
			'CabEsercente' => $this->cab_distributore,
			'IDOperazione' => $this->operation_id,
			'Firma' => $this->signature(Auth::user()->id),
			'Servizio' => 'RicaricaNazionale',
			'Numero' => $request->Numero,
			'Prodotto' => $request->Prodotto
		];
		$result = $this->call($fields);
		return view('admin/api/mbs/result',compact('debug','operation_name','result'));
	}
	
	public function point_ricarica_telefonica(Request $request)
	{
		$request_data = $request->session()->get('request_data');
		if (empty($request_data)) { return redirect()->route('users.reports.operations'); }
		
		$debug = [];
		$response = ['result' => 1];
		$operation_name = 'RICARICA TELEFONICA';
		$operation_id = $this->generate_operation_id (Auth::user()->id);
		$product = ApiMbsProduct::where('Prodotto',$request_data['Prodotto'])->first();
		if (!$product){
			$response['result'] = -1;
			$response['message'] = 'Product not found. Please contact administration.';
			return view('users/service/result', ['response' => $response]);
		}
		$configuration = $product->configuration(Auth::user()->group_id);
		if (!$configuration){
			$response['result'] = -1;
			$response['message'] = 'Product not configured for your user type. Please contact administration.';
			return view('users/service/result', ['response' => $response]);
		}
		$user_discount = round($product->PrezzoUtente * ($configuration->percent / 100),3);
		$user_cost = $product->PrezzoUtente - $user_discount;
		if(Auth::user()->plafond - $user_cost < Auth::user()->debt_limit){
			$response['result'] = -1;
			$response['message'] = 'Insufficient balance, please add credit to your balance to finalize operation or contact administration.';
			return view('users/service/result', ['response' => $response]);
		}
		try{
			$balance_fields = [
				'Distributore' 	=> $this->codice_distributore,
				'Utente'		=> $this->utente_distributore,
				'CabEsercente' 	=> $this->cab_distributore,
				'IDOperazione' 	=> $this->operation_id,
				'Firma' 		=> $this->signature(Auth::user()->id),
				'Servizio' 		=> 'Balance'
			];
			$platform_balance_before = round(floatval($this->call($balance_fields)),3);		
			$fields = [
				'Distributore' 	=> $this->codice_distributore,
				'Utente' 		=> $this->utente_distributore,
				'CabEsercente' 	=> $this->cab_distributore,
				'IDOperazione'	=> $this->operation_id,
				'Firma'			=> $this->signature(Auth::user()->id),
				'Servizio' 		=> 'RicaricaNazionale',
				'Numero' 		=> $request_data['Numero'],
				'Prodotto' 		=> $request_data['Prodotto']
			];
			$result = $this->call($fields);
			$result_array = explode('|',$result);		
			$platform_balance_after = round(floatval($this->call($balance_fields)),3);
		} catch (\Exception $ex) {
			$response['result'] = -1;
			$response['message'] = 'We are sorry, an error occurred:' . $ex->getMessage() . '. Please contact administration.';
			return view('users/service/result', ['response' => $response]);
		}
		if(!isset($result_array[0])||strpos($result_array[0],'OK')==false){
			$response['result'] = -1;
			$response['message'] = 'We are sorry, an error occurred: ' . ($result ?? 'call error');
			return view('users/service/result', ['response' => $response]);
		}
		$user = Auth::user();
		$user_old_plafond = $user->plafond;
		$user->plafond = Auth::user()->plafond - $user_cost;
		$user->save();
		
		if ($platform_balance_before!=0&&$platform_balance_after!=0){
			$platform_cost = $platform_balance_before - $platform_balance_after;
			$product->Costo = $platform_cost;
			$product->save();
		} elseif ( $product->Costo ) {
			$platform_cost = $product->Costo;
		} else {
			$platform_cost = $product->PrezzoUtente;
		}		
		
		$platform_commission = $product->PrezzoUtente - $platform_cost;
		$platform_total_gain = $platform_commission;
		
		$apiMbsOperation = ApiMbsOperation::create([
			'operation_id' 	=> $this->operation_id,
			'product' 		=> $request_data['Prodotto'],
			'user_id' 		=> $user->id,
			'number' 		=> $request_data['Numero'],
			'amount' 		=> $product->PrezzoUtente,
			'platform_balance_before' 	=> $platform_balance_before,
			'platform_balance_after' 	=> $platform_balance_after,
			'cost' 			=> $platform_cost,
			'response' 		=> $result_array[0],
			'ref' 			=> $result_array[1]	
		]);
		
		$serviceOperation = ServiceOperation::create([
			'provider'					=> 'mbs',
			'user_id' 					=> $user->id,
			'api_mbs_operation_id' 		=> $apiMbsOperation->id,
			'result' 					=> 1,
			'request_Prodotto' 			=> $request_data['Prodotto'],
			'request_local'	 			=> 0,
			'request_amount' 			=> $product->PrezzoUtente,
			'request_country_iso'		=> 'IT',
			'request_recipient_phone' 	=> $request_data['Numero'],
			'original_expected_destination_amount' 	=> $product->PrezzoUtente,
			'final_expected_destination_amount' 	=> $product->PrezzoUtente,
			'sent_amount' => $product->PrezzoUtente,
			'user_amount' => $product->PrezzoUtente,
			'user_gain'	=> 0,
			'final_amount' 	=> $product->PrezzoUtente,
			'user_discount' => $user_discount,
			'platform_commission' => $platform_commission,
			'user_old_plafond' => $user_old_plafond,
			'user_new_plafond' => $user->plafond,
			'user_total_gain' => $user_discount,
			'agent_commission' => 0,
			'platform_total_gain' => $platform_total_gain,
		]);
		
		if ($user->parent_id && $user->parent_id != 0){
			$agent = User::find($user->parent_id);
			if ($agent){
				$commission = $agent->agent_commission($user->group_id,1);
				if ($commission){
					if ($commission->type=='percent'){
						$agent_amount = round(($user_cost * ( $commission->amount / 100 )),3);
					} else {
						$agent_amount = $commission->amount;
					}
					AgentOperation::create([
						'user_id'				=> $agent->id,
						'service_operation_id'	=> $serviceOperation->id,
						'original_amount'		=> $user_cost,
						'applied_commission_id'	=> $commission->id,
						'commission'			=> $agent_amount,
					]);
					$serviceOperation->agent_commission = $agent_amount;
					$serviceOperation->platform_total_gain = $serviceOperation->platform_total_gain - $agent_amount;
					$serviceOperation->save();
					$agent->credit += $agent_amount;
					$agent->save();
				}
			}
		}
		
		$response = [
			'result' 							=> 1,
			'operation_id' 						=> $serviceOperation->id,
			'request_recipient_phone' 			=> $request_data['Numero'],
			'final_expected_destination_amount' => $product->PrezzoUtente,
			'final_amount' 						=> $product->PrezzoUtente,
			'user_gain' 						=> 0,
			'user_discount' 					=> $user_discount,
			'user_total_gain' 					=> $user_discount,
		];
		
		$operator = [
			'name' => $product->Operatore,
			'country_name' => 'Italy',
			'country_isoname' => 'IT',
			'currency_symbol' => '€',
		];
		
		return view('users/service/result', [
				'log' => $result, 
				'data' => $fields, 
				'response' => $response, 
				'operator' => $operator
			] );
	}
	
	public function ricarica_pin(Request $request)
	{
		$debug = [];
		$operation_name = 'RICARICA PIN';
		$this->generate_operation_id (Auth::user()->id);
		$fields = [
			'Distributore' => $this->codice_distributore,
			'Utente' => $this->utente_distributore,
			'CabEsercente' => $this->cab_distributore,
			'IDOperazione' => $this->operation_id,
			'Firma' => $this->signature(Auth::user()->id),
			'Servizio' => 'RicaricaPin',
			'Prodotto' => $request->Prodotto,
			'CodiceUtente' => $request->CodiceUtente,	//opzionale
			'ImportoPinLibero' => $request->ImportoPinLibero	//opzionale
		];
		$result = $this->call($fields);
		return view('admin/api/mbs/result',compact('debug','operation_name','result'));
	}
	
	public function point_ricarica_pin(Request $request)
	{
		$request_data = $request->session()->get('request_data');
		if (empty($request_data)) { return redirect()->route('users.reports.operations'); }
		
		$debug = [];
		$response = ['result' => 1];
		$operation_name = 'RICARICA PIN';
		$operation_id = $this->generate_operation_id (Auth::user()->id);
		$product = ApiMbsProduct::where('Prodotto',$request_data['Prodotto'])->first();
		if (!$product){
			$response['result'] = -1;
			$response['message'] = 'Product not found. Please contact administration.';
			return view('users/service/result', ['response' => $response]);
		}
		$configuration = $product->configuration(Auth::user()->group_id);
		if (!$configuration){
			$response['result'] = -1;
			$response['message'] = 'Product not configured for your user type. Please contact administration.';
			return view('users/service/result', ['response' => $response]);
		}
		$user_discount = round($product->PrezzoUtente * ($configuration->percent / 100),3);
		$user_cost = $product->PrezzoUtente - $user_discount;
		if(Auth::user()->plafond - $user_cost < Auth::user()->debt_limit){
			$response['result'] = -1;
			$response['message'] = 'Insufficient balance, please add credit to your balance to finalize operation or contact administration.';
			return view('users/service/result', ['response' => $response]);
		}
		try{
			$balance_fields = [
				'Distributore' 	=> $this->codice_distributore,
				'Utente'		=> $this->utente_distributore,
				'CabEsercente' 	=> $this->cab_distributore,
				'IDOperazione' 	=> $this->operation_id,
				'Firma' 		=> $this->signature(Auth::user()->id),
				'Servizio' 		=> 'Balance'
			];
			$platform_balance_before = round(floatval($this->call($balance_fields)),3);		
			$fields = [
				'Distributore' => $this->codice_distributore,
				'Utente' => $this->utente_distributore,
				'CabEsercente' => $this->cab_distributore,
				'IDOperazione' => $this->operation_id,
				'Firma' => $this->signature(Auth::user()->id),
				'Servizio' => 'RicaricaPin',
				'Prodotto' => $request_data['Prodotto'],
				'CodiceUtente' => $request_data['CodiceUtente'],	//opzionale
				'ImportoPinLibero' => $request_data['ImportoPinLibero']	//opzionale
			];
			$result = $this->call($fields);
			$result_array = explode('|',$result);		
			$platform_balance_after = round(floatval($this->call($balance_fields)),3);
		} catch (\Exception $ex) {
			$response['result'] = -1;
			$response['message'] = 'We are sorry, an error occurred:' . $ex->getMessage() . '. Please contact administration.';
			return view('users/service/result', ['response' => $response]);
		}
		if(!isset($result_array[0])||strpos($result_array[0],'OK')==false){
			$response['result'] = -1;
			$response['message'] = 'We are sorry, an error occurred: ' . ($result ?? 'call error');
			return view('users/service/result', ['response' => $response]);
		}
		$user = Auth::user();
		$user_old_plafond = $user->plafond;
		$user->plafond = Auth::user()->plafond - $user_cost;
		$user->save();
		
		$platform_cost = $platform_balance_before - $platform_balance_after;
		$platform_commission = $product->PrezzoUtente - $platform_cost;
		$platform_total_gain = $platform_commission;
		
		$apiMbsOperation = ApiMbsOperation::create([
			'operation_id' 	=> $this->operation_id,
			'product' 		=> $request_data['Prodotto'],
			'user_id' 		=> $user->id,
			'number' 		=> $request_data['Numero'],
			'amount' 		=> $product->PrezzoUtente,
			'platform_balance_before' 	=> $platform_balance_before,
			'platform_balance_after' 	=> $platform_balance_after,
			'cost' 			=> $platform_cost,
			'response' 		=> $result_array[0],
			'pin'			=> $result_array[1],
			'pin_serial'	=> $result_array[2],
			'pin_expiry'	=> $result_array[3]	
		]);
		
		$serviceOperation = ServiceOperation::create([
			'provider'					=> 'mbs',
			'user_id' 					=> $user->id,
			'api_mbs_operation_id' 		=> $apiMbsOperation->id,
			'result' 					=> 1,
			'request_Prodotto' 			=> $request_data['Prodotto'],
			'request_local'	 			=> 0,
			'request_amount' 			=> $product->PrezzoUtente,
			'request_country_iso'		=> 'IT',
			'request_recipient_phone' 	=> $request_data['Numero'],
			'original_expected_destination_amount' 	=> $product->PrezzoUtente,
			'final_expected_destination_amount' 	=> $product->PrezzoUtente,
			'sent_amount' => $product->PrezzoUtente,
			'user_amount' => $product->PrezzoUtente,
			'user_gain'	=> 0,
			'final_amount' 	=> $product->PrezzoUtente,
			'user_discount' => $user_discount,
			'platform_commission' => $platform_commission,
			'user_old_plafond' => $user_old_plafond,
			'user_new_plafond' => $user->plafond,
			'user_total_gain' => $user_discount,
			'agent_commission' => 0,
			'platform_total_gain' => $platform_total_gain,
			'pin' => $result_array[1]
		]);
		
		if ($user->parent_id && $user->parent_id != 0){
			$agent = User::find($user->parent_id);
			if ($agent){
				$commission = $agent->agent_commission($user->group_id,1);
				if ($commission){
					if ($commission->type=='percent'){
						$agent_amount = round(($user_cost * ( $commission->amount / 100 )),3);
					} else {
						$agent_amount = $commission->amount;
					}
					AgentOperation::create([
						'user_id'				=> $agent->id,
						'service_operation_id'	=> $serviceOperation->id,
						'original_amount'		=> $user_cost,
						'applied_commission_id'	=> $commission->id,
						'commission'			=> $agent_amount,
					]);
					$serviceOperation->agent_commission = $agent_amount;
					$serviceOperation->platform_total_gain = $serviceOperation->platform_total_gain - $agent_amount;
					$serviceOperation->save();
					$agent->credit += $agent_amount;
					$agent->save();
				}
			}
		}
		
		$response = [
			'result' 							=> 1,
			'operation_id' 						=> $serviceOperation->id,
			'request_recipient_phone' 			=> $request_data['Numero'],
			'final_expected_destination_amount' => $product->PrezzoUtente,
			'final_amount' 						=> $product->PrezzoUtente,
			'user_gain' 						=> 0,
			'user_discount' 					=> $user_discount,
			'user_total_gain' 					=> $user_discount,
			'pin'			=> $result_array[1],
			'pin_serial'	=> $result_array[2],
			'pin_expiry'	=> $result_array[3]				
		];
		
		$operator = [
			'name' => $product->Operatore,
			'country_name' => 'Italy',
			'country_isoname' => 'IT',
			'currency_symbol' => '€',
		];
		
		return view('users/service/result', [
				'log' => $result, 
				'data' => $fields, 
				'response' => $response, 
				'operator' => $operator
			] );
	}
	
	
	public function verifica_ricarica(Request $request)
	{
		$debug = [];
		$operation_name = 'VERIFICA RICARICA';
		$this->generate_operation_id (Auth::user()->id);
		$fields = [
			'Distributore' => $this->codice_distributore,
			'Utente' => $this->utente_distributore,
			'CabEsercente' => $this->cab_distributore,
			'IDOperazione' => $request->IDOperazione,
			'Firma' => $this->signature(Auth::user()->id),
			'Servizio' => 'VerificaRicarica'
		];
		$result = $this->call($fields);
		return view('admin/api/mbs/result',compact('debug','operation_name','result'));
	}
	
	
	public function verifica_ricarica_pin(Request $request)
	{
		$debug = [];
		$operation_name = 'VERIFICA RICARICA PIN';
		$this->generate_operation_id (Auth::user()->id);
		$fields = [
			'Distributore' => $this->codice_distributore,
			'Utente' => $this->utente_distributore,
			'CabEsercente' => $this->cab_distributore,
			'IDOperazione' => $request->IDOperazione,
			'Firma' => $this->signature(Auth::user()->id),
			'Servizio' => 'VerificaPin'
		];
		$result = $this->call($fields);
		return view('admin/api/mbs/result',compact('debug','operation_name','result'));
	}
	
	
	public function tagli_prefissi_internazionali(Request $request)
	{
		$debug = [];
		$operation_name = 'TAGLI PREFISSI INTERNAZIONALI';
		$this->generate_operation_id (Auth::user()->id);
		$fields = [
			'Distributore' => $this->codice_distributore,
			'Utente' => $this->utente_distributore,
			'CabEsercente' => $this->cab_distributore,
			'IDOperazione' => $this->operation_id,
			'Firma' => $this->signature(Auth::user()->id),
			'Servizio' => 'TagliPrefissiInternazionali',
			'Prefisso' => $request->Prefisso,
			'Numero' => $request->Numero,
			'Paese' => $request->Paese
		];
		$result = $this->call($fields);
		return view('admin/api/mbs/result',compact('debug','operation_name','result'));
	}
	
	
	public function ricarica_internazionale(Request $request)
	{
		$debug = [];
		$operation_name = 'RICARICA INTERNAZIONALE';
		$this->generate_operation_id (Auth::user()->id);
		$fields = [
			'Distributore' => $this->codice_distributore,
			'Utente' => $this->utente_distributore,
			'CabEsercente' => $this->cab_distributore,
			'IDOperazione' => $this->operation_id,
			'Firma' => $this->signature(Auth::user()->id),
			'Servizio' => 'RicaricaInternazionale',
			'Prefisso' => $request->Prefisso,
			'Numero' => $request->Numero,
			'Paese' => $request->Paese,
			'Prodotto' => $request->Prodotto,
			'IDProdotto' => $request->IDProdotto,
			'PrezzoUtente' => $request->PrezzoUtente,
		];
		$result = $this->call($fields);
		return view('admin/api/mbs/result',compact('debug','operation_name','result'));
	}
	
	
	public function pagamento_visura(Request $request)
	{
		$debug = [];
		$operation_name = 'VISURE';
		$this->generate_operation_id (Auth::user()->id);
		$fields = [
			'Distributore' => $this->codice_distributore,
			'Utente' => $this->utente_distributore,
			'CabEsercente' => $this->cab_distributore,
			'IDOperazione' => $this->operation_id,
			'Firma' => $this->signature(Auth::user()->id),
			'Servizio' => 'Visure',
			'TipoVisura' => $request->TipoVisura, //Camerale,Protesti,Targa,Immobile
			'Prodotto' => $request->Prodotto,
			'TipoAzienda' => $request->TipoAzienda, //camerale
			'Richiedente' => $request->Richiedente,
			'RagioneSociale' => $request->RagioneSociale, //camerale,protesti
			'CodiceFiscale' => $request->CodiceFiscale, //camerale
			'PartitaIVA' => $request->PartitaIVA, //camerale
			'TipoRicerca' => $request->TipoRicerca, //camerale
			'DataNascita' => $request->DataNascita, //protesti
			'Targa' => $request->Targa, //targa
			'TipoVeicolo' => $request->TipoVeicolo, //targa
			'TipoImmobile' => $request->TipoImmobile, //immobile
			'Provincia' => $request->Provincia, //immobile
			'Foglio' => $request->Foglio, //immobile
			'Particella' => $request->Particella, //immobile
			'Subalterno' => $request->Subalterno, //immobile
			'Zona' => $request->Zona, //immobile
			'Comune' => $request->Comune //immobile
		];
		$result = $this->call($fields);
		return view('admin/api/mbs/result',compact('debug','operation_name','result'));
	}
	
	
	public function verifica_visura(Request $request)
	{
		$debug = [];
		$operation_name = 'VERIFICA VISURE';
		$this->generate_operation_id (Auth::user()->id);
		$fields = [
			'Distributore' => $this->codice_distributore,
			'Utente' => $this->utente_distributore,
			'CabEsercente' => $this->cab_distributore,
			'IDOperazione' => $request->IDOperazione,
			'Firma' => $this->signature(Auth::user()->id),
			'Servizio' => 'VerificaVisure',
			'ftp_user' => $request->ftp_user,
			'ftp_pass' => $request->ftp_pass,
			'ftp_host' => $request->ftp_host,
			'uploaddir' => $request->uploaddir
		];
		$result = $this->call($fields);
		return view('admin/api/mbs/result',compact('debug','operation_name','result'));
	}
	
	
	public function spedizione(Request $request)
	{
		$debug = [];
		$operation_name = 'SPEDIZIONI';
		$this->generate_operation_id (Auth::user()->id);
		$fields = [
			'Distributore' => $this->codice_distributore,
			'Utente' => $this->utente_distributore,
			'CabEsercente' => $this->cab_distributore,
			'IDOperazione' => $this->operation_id,
			'Firma' => $this->signature(Auth::user()->id),
			'Servizio' => 'Spedizioni',
			'Peso' => $request->Peso,
			'Altezza' => $request->Altezza,
			'Profondita' => $request->Profondita,
			'Lunghezza' => $request->Lunghezza,
			'Prodotto' => $request->Prodotto,
			'RitiroRagione' => $request->RitiroRagione,
			'RitiroIndirizzo' => $request->RitiroIndirizzo,
			'RitiroCivico' => $request->RitiroCivico,
			'RitiroCap' => $request->RitiroCap,
			'RitiroComune' => $request->RitiroComune,
			'RitiroProvincia' => $request->RitiroProvincia,
			'RitiroEmail' => $request->RitiroEmail,
			'ConsegnaRagione' => $request->ConsegnaRagione,
			'ConsegnaIndirizzo' => $request->ConsegnaIndirizzo,
			'ConsegnaCivico' => $request->ConsegnaCivico,
			'ConsegnaCap' => $request->ConsegnaCap,
			'ConsegnaComune' => $request->ConsegnaComune,
			'ConsegnaProvincia' => $request->ConsegnaProvincia,
			'ConsegnaEmail' => $request->ConsegnaEmail,
			'ConsegnaCellulare' => $request->ConsegnaCellulare,
		];
		$result = $this->call($fields);
		return view('admin/api/mbs/result',compact('debug','operation_name','result'));
	}
	
	
	public function verifica_spedizione(Request $request)
	{
		$debug = [];
		$operation_name = 'VERIFICA SPEDIZIONI';
		$this->generate_operation_id (Auth::user()->id);
		$fields = [
			'Distributore' => $this->codice_distributore,
			'Utente' => $this->utente_distributore,
			'CabEsercente' => $this->cab_distributore,
			'IDOperazione' => $request->IDOperazione,
			'Firma' => $this->signature(Auth::user()->id),
			'Servizio' => 'VerificaVisure',
			'ftp_user' => $request->ftp_user,
			'ftp_pass' => $request->ftp_pass,
			'ftp_host' => $request->ftp_host,
			'uploaddir' => $request->uploaddir
		];
		$result = $this->call($fields);
		return view('admin/api/mbs/result',compact('debug','operation_name','result'));
	}
	
	
	public function ricarica_postepay(Request $request)
	{
		$debug = [];
		$operation_name = 'RICARICA PREPAGATA - POSTEPAY';
		$this->generate_operation_id (Auth::user()->id);
		$fields = [
			'Distributore' => $this->codice_distributore,
			'Utente' => $this->utente_distributore,
			'CabEsercente' => $this->cab_distributore,
			'IDOperazione' => $this->operation_id,
			'Firma' => $this->signature(Auth::user()->id),
			'Servizio' => 'PostePayVincitu',
			'Prodotto' => $request->Prodotto,
			'NumeroCarta' => $request->NumeroCarta,
			'Intestatario' => $request->Intestatario,
			'CFIntestatario' => $request->CFIntestatario,
			'Ordinante' => $request->Ordinante,
			'CFOrdinante' => $request->CFOrdinante,
			'Importo' => $request->Importo,
			'Up' => 'true',
		];
		$result = $this->call($fields);
		return view('admin/api/mbs/result',compact('debug','operation_name','result'));
	}
	
	
	private function call($fields)
	{		
		$data = '';
		foreach ($fields as $k => $v)
		{
			$data .= $k . '=' . $v . '&';
		}
		rtrim($data, '&');
		$headers = array("Content-type: application/x-www-form-urlencoded");
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		$this->record(Auth::user()->id,$fields,$result);
		return $result;	   
	}
	
	private function signature ($user_id)
	{		
		$string = $this->operation_id;
		$string .= $this->codice_distributore;
		$string .= $this->key;
		return md5($string);
	}
	
	private function generate_operation_id ($user_id)
	{
		$operation_id = '';		
		$operation_id .= $user_id;
		$operation_id .= date('Y');
		$operation_id .= date('m');
		$operation_id .= date('d');
		$operation_id .= date('H');
		$operation_id .= date('i');
		$operation_id .= date('s');
		$operation_id .= str_pad(rand(0, pow(10, 3)-1), 3, '0', STR_PAD_LEFT);
		$this->operation_id = $operation_id;
		return $this->operation_id;
	}
	
	private function record($user_id,$fields,$raw_answer){
		ApiMbsCall::create([
			'user_id'		=> $user_id,
			'operation_id'	=> $fields['IDOperazione'],
			'fields'		=> json_encode($fields),
			'raw_answer'	=> json_encode($raw_answer),
		]);
	}
	
}