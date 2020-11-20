<?php

namespace App\Http\Controllers;

use App\Models\AgentOperation;
use App\Models\ApiReloadlyCall;
use App\Models\ApiReloadlyOperation;
use App\Models\ApiReloadlyOperator;
use App\Models\ServiceOperation;
use Auth;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ApiReloadlyController extends Controller
{
	private $environment = 'live';

	private $balanceString;

	private $token = '';
	private $testing = "https://topups-sandbox.reloadly.com";
	private $live = "https://topups.reloadly.com";

	private $credentials = [
		"live" => [
			"client_id" => "CdQTK1X20YI5V42C214WwUKhn6FIxm05",
			"client_secret" => "Bt1HtopMSkRv2oU_mRRp6Jhy0MfeN9UT1VOvbKE0KzqNTvDQ5QxCFwpx-4rHRQVo",
		],
		"testing" => [
			"client_id" => "7WZ8Ku4wEj0cthKH0ZZPwNa9snudG0Jw",
			"client_secret" => "gFOejv65pH6OmcW_7TN1J366F-NwsOxxXOfwVxDA3wSksfl7kEfRLcZC_Ct2EBZn",
		]
	];

	public $log = '';
	public $call_id = 0;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|user|sales');

        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://auth.reloadly.com/oauth/token");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		$requestBody = json_encode([
		  "client_id" => $this->environment_credentials("client_id"),
		  "client_secret" => $this->environment_credentials("client_secret"),
		  "grant_type" => "client_credentials",
		  "audience" => $this->environment()
		]);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
		  "Content-Type: application/json",
		  "Accept: application/json"
		]);
		$response = curl_exec($ch);
		if (curl_errno($ch)) {	$this->log .= 'Init error 1: ' . curl_error($ch); return false; }
		if (curl_getinfo($ch, CURLINFO_HTTP_CODE)!=200){ $this->log = 'Init error, response code: ' . curl_getinfo($ch, CURLINFO_HTTP_CODE); return false; }
		curl_close($ch);
		$response = json_decode($response, true);
		if(isset($response['access_token'])){
			$this->token = $response['access_token'];
			$this->log .= 'Init OK';
			return true;
		}
		$this->log .= 'Init error 3';
		return false;
    }

	private function environment(){
		if ($this->environment=="live"){
			return $this->live;
		}
		return $this->testing;
	}

	private function environment_credentials($field){
		if ($this->environment=="live"){
			return $this->credentials["live"][$field];
		}
		return $this->credentials["testing"][$field];
	}

	private function get_call($path, $return_data = false){
		$full_path = $this->environment() . $path;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $full_path);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		  "Accept: application/com.reloadly.topups-v1+json",
		  "Authorization: Bearer " . $this->token
		));
		$response = curl_exec($ch);
		$data = [];
		if (curl_errno($ch)) {
			$this->log .= '<br>Call '.$path.' failed: ' . curl_error($ch);
			$this->log_call('get',$full_path);
			return view('admin/api/reloadly/dump', ['log' => $this->log, 'data' => $data] );
		}
		$this->log .= curl_getinfo($ch, CURLINFO_HTTP_CODE)==200 ? '<br>Call '.$path.' OK' : '<br>Response '.$path.' error: ' . curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		$this->call_id = $this->log_call('get',$full_path,'',$response);
        $data = json_decode($response, true);
		if ($return_data) { return $data; }
		return view('admin/api/reloadly/dump', ['log' => $this->log, 'data' => $data] );
	}

	private function post_call($path, $parameters, $return_data = false){
		$full_path = $this->environment() . $path;
		$first = true;
		$parameter_string = '{';
		foreach ($parameters as $parameter_index => $parameter_value) {
			if (!$first){ $parameter_string .= ','; }
			if ($first){ $first = false; }
			$parameter_string .= '"'.$parameter_index.'":'.$parameter_value;
		}
		$parameter_string .= '}';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $full_path);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $parameter_string );
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		  "Content-Type: application/json",
		  "Accept: application/com.reloadly.topups-v1+json",
		  "Authorization: Bearer " . $this->token
		));
		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			$this->log .= '<br>Call '.$path.' failed: ' . curl_error($ch);
			$this->log_call('post',$full_path,$parameter_string);
			return view('admin/api/reloadly/dump', ['log' => $this->log, 'data' => $data] );
		}
		$data = [];
		$this->log .= curl_getinfo($ch, CURLINFO_HTTP_CODE)==200 ? '<br>Call '.$path.' OK' : '<br>Response '.$path.' error: ' . curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		$this->call_id = $this->log_call('post',$full_path,$parameter_string,$response);
		$data = json_decode($response, true);
		if ($return_data) { return $data; }
		return view('admin/api/reloadly/dump', ['log' => $this->log, 'data' => $data] );
	}

	public function log_call($type,$path,$parameters = '',$response = ''){
		$call = ApiReloadlyCall::create([
			'user_id' => Auth::user()->id,
			'type' => $type,
			'path' => $path,
			'parameters' => $parameters,
			'log' => $this->log,
			'raw_answer' => $response,
		]);
		return $call->id;
	}

	public function index(Request $request)
	{
		return view('admin/api/reloadly/command-list', ['log' => $this->log] );
	}



    public function balance(Request $request)
    {
		$call = $this->get_call('/accounts/balance');
		if (isset($call['data']['balance'])){
			if (Cache::has('reloadly_cache_balance_'.date('w'))) {
				Cache::forget('reloadly_cache_balance_'.date('w'));
			}
			Cache::forever('reloadly_cache_balance_'.date('w'), $call['data']['balance']);
		}
		return $call;
    }

	public function get_cache_balance(){
		try{
			$call = $this->get_call('/accounts/balance');
			if (isset($call['data']['balance'])){
				if (Cache::has('reloadly_cache_balance_'.date('w'))) {
					Cache::forget('reloadly_cache_balance_'.date('w'));
				}
				Cache::forever('reloadly_cache_balance_'.date('w'), $call['data']['balance']);
				return response()->json($call['data']['balance'], 200);
			}
			return 'error';
		} catch (Exception $ex){
			$call = $ex->getMessage();
			return 'error';
		}
	}

    public function discounts(Request $request)
    {
		// by op id:  /operators/{{$op_id}}/commissions
		return $this->get_call('/operators/commissions?page=1&size=3');
    }

    public function fx_rates(Request $request)
    {
		return $this->post_call('/operators/fx-rate', [
			'operatorId' => $request->input('operator_id'),
			'amount' => $request->input('amount'),
		]);
    }

    public function countries(Request $request)
    {
		// by iso code:  /countries/{{$country_iso_code}}
		return $this->get_call('/countries');
    }

    public function operators(Request $request)
    {
		// by op id:  /operators/{{$op_id}}
		// by phone number:  /operators/auto-detect/phone/{{$phone_number}}/countries/{{$country_code}}?&includeBundles=true
		// by country:  /operators/countries/{{$country_iso_code}}
		//return $this->get_call('/operators/289');
		return $this->get_call('/operators/');
    }

	public function operator(Request $request)
    {
		// by op id:  /operators/{{$op_id}}
		// by phone number:  /operators/auto-detect/phone/{{$phone_number}}/countries/{{$country_code}}?&includeBundles=true
		// by country:  /operators/countries/{{$country_iso_code}}
		return $this->get_call('/operators/'.$request->input('operator_id'));
    }

    public function promotions(Request $request)
    {
		// by prom id:  /promotions/{{$prom_id}}
		// by op id:  /promotions//operators/{{$op_id}}
		// by country code:  /promotions/country-code/{{$country_code}}
		return $this->get_call('/promotions');
    }

    public function transactions(Request $request)
    {
		// by prom id:  /promotions/{{$prom_id}}
		// by op id:  /promotions//operators/{{$op_id}}
		// by country code:  /promotions/country-code/{{$country_code}}
		return $this->get_call('/reports/transactions');
    }

	public function user_operator_selected($id)
    {
		$data = $this->get_call('/operators/'.$id,true);
		$operator = isset($data['operatorId']) ? $this->save_operator_data($data,0,true) : false;
		return view('users/service/preview', ['log' => $this->log, 'data' => $data, 'operator' => $operator ]);

    }

    public function user_input_phone_number(Request $request)
    {
		$full_number = '+'.$request->input('prefix').str_replace(' ', '', $request->input('number'));
		$data = $this->get_call('/operators/auto-detect/phone/'.$full_number.'/countries/'.strtoupper($request->input('country')),true);
		$operator = isset($data['operatorId']) ? $this->save_operator_data($data,0,true) : false;
		return view('users/service/preview', ['log' => $this->log, 'data' => $data, 'operator' => $operator, 'phone_number' => $full_number] );
    }

	/*
	public function user_recharge_request(Request $request){
		$request_data = [
			'request_local' 					=> $request->input('local') ? $request->input('local') : 0,
			'request_operator_id' 				=> $request->input('operator_id'),
			'request_amount' 					=> $request->input('amount'),
			'request_country_iso' 				=> $request->input('country_iso'),
			'request_recipient_phone' 			=> $request->input('recipient_phone'),
			'user_gain' 						=> $request->input('gain'),
			'final_amount' 						=> $request->input('final_amount'),
			'final_expected_destination_amount' => $request->input('final_amount_destination'),
		];
		$request->session()->flash('request_data', $request_data);
		return redirect()->route('users.services.reloadly.transaction.result');
	}
	*/

	// two distinct functions passing data through session to avoid multiple submits...

	public function user_recharge(Request $request)
    {
		$request_data = $request->session()->get('request_data');

		if (empty($request_data)) { return redirect()->route('users.reports.operations'); }

		$request_local 						= $request_data['request_local'];
		$request_operator_id 				= $request_data['request_operator_id'];
		$request_amount 					= $request_data['request_amount'];
		$request_country_iso 				= $request_data['request_country_iso'];
		$request_recipient_phone 			= $request_data['request_recipient_phone'];
		$user_gain 							= $request_data['user_gain'];
		$final_amount 						= $request_data['final_amount'];
		$final_expected_destination_amount 	= $request_data['final_expected_destination_amount'];

		$operator = ApiReloadlyOperator::where('operatorId',$request_operator_id)->first();
		//$original_expected_destination_amount = $request_amount * $operator->fx->rate;

		$configuration = $operator->configuration(Auth::user()->group_id);

		$user_amount = $final_amount - $user_gain;

		if ($operator->denominationType=="FIXED"){
			if($request_local==1){
				$sent_amount = $user_amount; // temporary, to be overwritten before saving
				if ($configuration) {
					$config_amount = $configuration->local_amount($request_amount);
					$user_discount = $config_amount && $config_amount->discount > 0 ? round(($config_amount->discount/100)*$config_amount->final_amount,2) : 0;
					$platform_gain = 0;
				} else {
					$user_discount = 0;
					$platform_gain = 0;
				}
			} else {
				$sent_amount = $request_amount;
				if ($configuration) {
					$config_amount = $configuration->amount($request_amount);
					$user_discount = $config_amount && $config_amount->discount > 0 ? round(($config_amount->discount/100)*$request_amount,2) : 0;
					$platform_gain = $config_amount && $config_amount->final_amount > 0 ? $config_amount->final_amount - $config_amount->original_amount : 0;
				} else {
					$user_discount = 0;
					$platform_gain = 0;
				}
			}
		}
		if ($operator->denominationType=="RANGE"){
			$user_discount = $configuration ? round(($configuration->discount_percent/100) * $request_amount,3) : 0;
			$sent_amount = round($final_expected_destination_amount / $operator->fx->rate,3);
			$platform_gain = $request_amount - $sent_amount;
		}

		$user_total_gain = $user_discount + $user_gain;

		$response = [
			'provider' => 'reloadly',
			'user_id' => Auth::user()->id,
			'request_operatorId' => $request_operator_id,
			'request_amount' => $request_amount,
			'request_local' => $request_local,
			'request_country_iso' => $request_country_iso,
			'request_recipient_phone' => $request_recipient_phone,
			//'original_expected_destination_amount' => $original_expected_destination_amount,
			'final_expected_destination_amount' => $final_expected_destination_amount,
			'user_discount' => $user_discount,
			'user_amount' => $user_amount,
			'sent_amount' => $sent_amount,
			'platform_gain' => $platform_gain,
			'user_gain' => $user_gain,
			'final_amount' => $final_amount,
			'user_total_gain' => $user_total_gain,
		];

		if(Auth::user()->plafond - $user_amount < Auth::user()->debt_limit){
			$response['result'] = -1;
			$response['message'] = 'Insufficient balance, please add credit to your balance to finalize operation or contact administration.';
			return view('users/service/result', ['response' => $response]);
		}

		if($request_local==1){
			$data = $this->post_call('/topups', [
				'operatorId' => $request_operator_id,
				'amount' => $request_amount,
				'useLocalAmount' => 'true',
				'recipientPhone' => "{
					\"countryCode\": \"".$request_country_iso."\",
					\"number\": \"".$request_recipient_phone."\"
				  }"
			], true);
		} else {
			$data = $this->post_call('/topups', [
				'operatorId' => $request_operator_id,
				'amount' => $sent_amount,
				'recipientPhone' => "{
					\"countryCode\": \"".$request_country_iso."\",
					\"number\": \"".$request_recipient_phone."\"
				  }"
			], true);
		}
		$response['api_reloadly_calls_id'] = $this->call_id;
		if (isset($data['deliveredAmount'])&&isset($data['operatorId'])){
			if (isset($data['balanceInfo'])){
				if (isset($data['balanceInfo']['oldBalance'])){
					$data['balance_oldBalance'] = $data['balanceInfo']['oldBalance'];
				}
				if (isset($data['balanceInfo']['newBalance'])){
					$data['balance_newBalance'] = $data['balanceInfo']['newBalance'];
				}
				if (isset($data['balanceInfo']['currencyCode'])){
					$data['balance_currencyCode'] = $data['balanceInfo']['currencyCode'];
				}
				if (isset($data['balanceInfo']['currencyName'])){
					$data['balance_currencyName'] = $data['balanceInfo']['currencyName'];
				}
				if (isset($data['balanceInfo']['updatedAt'])){
					$data['balance_updatedAt'] = $data['balanceInfo']['updatedAt'];
				}
				unset($data['balanceInfo']);
			}
			$reloadlyOperation = ApiReloadlyOperation::create($data);
			$response['api_reloadly_operations_id'] = $reloadlyOperation->id;
			$response['reloadly_transactionId'] = $reloadlyOperation->transactionId;

			$response['platform_commission'] = $reloadlyOperation->discount;
			if($request_local==1){
				$response['sent_amount'] = $reloadlyOperation->balance_oldBalance - $reloadlyOperation->balance_newBalance + $reloadlyOperation->discount;
				$response['platform_gain'] = $user_amount - $response['sent_amount'];
			}
			$response['platform_total_gain'] = $response['platform_gain'] + $response['platform_commission'];

			$user = Auth::user();
			$response['user_old_plafond'] = $user->plafond;
			$user_cost = $user_amount - $user_discount;
			$user->plafond = Auth::user()->plafond - $user_cost;
			$user->save();
			$response['user_new_plafond'] = $user->plafond;
			$response['result'] = 1;
			$operation = ServiceOperation::create($response);
			$response['operation_id'] = $operation->id;
			if ($user->parent_id && $user->parent_id != 0){
				AgentOperation::create([
					'user_id'				=> $user->parent_id,
					'service_operation_id'	=> $operation->id,
					'original_amount'		=> $user_cost,
					'applied percentage'	=> $user->parent_percent,
					'commission'			=> round(($user_cost * ( $user->parent_percent / 100 )),2),
				]);
			}
		} else {
			$response['result'] = 0;
		}
		return view('users/service/result', ['log' => $this->log, 'data' => $data, 'response' => $response, 'operator' => $operator] );
    }

	public function recharge(Request $request)
    {
		return $this->post_call('/topups', [
			'operatorId' => $request->input('operator_id'),
			'amount' => $request->input('amount'),
			'recipientPhone' => "{
				\"countryCode\": \"".$request->input('country_iso')."\",
				\"number\": \"".$request->input('recipient_phone')."\"
			  }"
		]);
    }

	public function save_operator($id)
    {
		$data = $this->get_call('/operators/'.$id, true);
		return $this->save_operator_data($data,0);
    }

	public function save_operators(Request $request)
    {
		$page=1;
		$last=false;
		$count = 0;
		while($last==false||$page==100){
			$data = $this->get_call('/operators?page='.$page.'&size=100&suggestedAmounts=true&suggestedAmountsMap=true', true);
			if (!isset($data['content'])){
				$this->log .= '<br>NO $data[content]';
				return view('admin/api/reloadly/result', ['log' => $this->log, 'count' => $count, 'data' => $data] );
			}
			$this->log .= "<br>Elaborazione pagina $page ...<br>";
			$count = $this->save_operators_data($data['content'],$count);
			$last = $data['last'];
			$page++;
		}
		return view('admin/api/reloadly/result', ['log' => $this->log, 'count' => $count] );
    }

	private function save_operators_data($data,$count=0){
		foreach ($data as $operator_data){
			$count = $this->save_operator_data($operator_data,$count);
		}
		return $count;
	}

	private function save_operator_data($operator_data,$count = 0, $return_operator = false){
		if (!isset($operator_data['operatorId'])){ return $return_operator ? false : $count; }
		try {
			$operator = ApiReloadlyOperator::updateOrCreate(
					[ 'operatorId' => $operator_data['operatorId'] ],
					[
					'name' => $operator_data['name'],
					'bundle' => $operator_data['bundle'],
					'data' => $operator_data['data'],
					'pin' => $operator_data['pin'],
					'supportsLocalAmounts' => $operator_data['supportsLocalAmounts'],
					'denominationType' => $operator_data['denominationType'],
					'senderCurrencyCode' => $operator_data['senderCurrencyCode'],
					'senderCurrencySymbol' => $operator_data['senderCurrencySymbol'],
					'destinationCurrencyCode' => $operator_data['destinationCurrencyCode'],
					'destinationCurrencySymbol' => $operator_data['destinationCurrencySymbol'],
					'commission' => $operator_data['commission'],
					'internationalDiscount' => $operator_data['internationalDiscount'],
					'localDiscount' => $operator_data['localDiscount'],
					'mostPopularAmount' => $operator_data['mostPopularAmount'],
					'minAmount' => $operator_data['minAmount'],
					'maxAmount' => $operator_data['maxAmount'],
					'localMinAmount' => $operator_data['localMinAmount'],
					'localMaxAmount' => $operator_data['localMaxAmount'],
					]
				);
			$count++;
			if (isset($operator_data['country'])&&!empty($operator_data['country'])){
				$operator->country()->updateOrCreate(
					['parent_id' => $operator->id],
					[
						'isoName' => $operator_data['country']['isoName'] ,
						'name' => $operator_data['country']['name']
					]
				);
			}
			if (isset($operator_data['fx'])&&!empty($operator_data['fx'])){
				$operator->fx()->updateOrCreate(
					['parent_id' => $operator->id],
					[
						'rate' => $operator_data['fx']['rate'] ,
						'currencyCode' => $operator_data['fx']['currencyCode']
					]
				);
			}
			if (isset($operator_data['logoUrls'])&&!empty($operator_data['logoUrls'])){
				$operator->logoUrls()->delete();
				foreach ($operator_data['logoUrls'] as $logoUrl){
					$operator->logoUrls()->create(
						['url' => $logoUrl ]
					);
				}
			}
			if (isset($operator_data['fixedAmounts'])&&!empty($operator_data['fixedAmounts'])){
				$operator->fixedAmounts()->delete();
				foreach ($operator_data['fixedAmounts'] as $fixedAmont){
					$operator->fixedAmounts()->create(
						['amount' => $fixedAmont ]
					);
				}
			}
			if (isset($operator_data['fixedAmountsDescriptions'])&&!empty($operator_data['fixedAmountsDescriptions'])){
				$operator->fixedAmountsDescriptions()->delete();
				foreach ($operator_data['fixedAmountsDescriptions'] as $fixedAmontDescription_amount => $fixedAmontDescription_description){
					$operator->fixedAmountsDescriptions()->create(
						[
							'amount' => $fixedAmontDescription_amount,
							'description' => $fixedAmontDescription_description,
						]
					);
				}
			}
			if (isset($operator_data['localFixedAmounts'])&&!empty($operator_data['localFixedAmounts'])){
				$operator->localFixedAmounts()->delete();
				foreach ($operator_data['localFixedAmounts'] as $localFixedAmont){
					$operator->localFixedAmounts()->create(
						['amount' => $localFixedAmont ]
					);
				}
			}
			if (isset($operator_data['localFixedAmountsDescriptions'])&&!empty($operator_data['localFixedAmountsDescriptions'])){
				$operator->localFixedAmountsDescriptions()->delete();
				foreach ($operator_data['localFixedAmountsDescriptions'] as $localFixedAmontDescription_amount => $localFixedAmontDescription_description){
					$operator->localFixedAmountsDescriptions()->create(
						[
							'amount' => $localFixedAmontDescription_amount,
							'description' => $localFixedAmontDescription_description,
						]
					);
				}
			}
			if (isset($operator_data['suggestedAmounts'])&&!empty($operator_data['suggestedAmounts'])){
				$operator->suggestedAmounts()->delete();
				foreach ($operator_data['suggestedAmounts'] as $suggestedAmount){
					$operator->suggestedAmounts()->create(
						['amount' => $suggestedAmount ]
					);
				}
			}
			if (isset($operator_data['suggestedAmountsMap'])&&!empty($operator_data['suggestedAmountsMap'])){
				$operator->suggestedAmountsMap()->delete();
				foreach ($operator_data['suggestedAmountsMap'] as $suggestedAmountMap_sender => $suggestedAmountMap_recipient){
					$operator->suggestedAmountsMap()->create(
						[
							'amount_sender' => $suggestedAmountMap_sender,
							'amount_recipient' => $suggestedAmountMap_recipient,
						]
					);
				}
			}
		} catch (Exception $e) {
			$this->log .= '<br>[!] Errore [loop/$count]: ' . $e->getMessage();
		}
		return $return_operator ? ( isset($operator) ? $operator : false ) : $count;
	}

	public function graph_data()
    {
        if (Cache::has('reloadly_cache_balance_graph_'.date('w'))) {
            $key = Cache::get('reloadly_cache_balance_graph_'.date('w'));
            $key[date('w')] = "1540";;
            $key[date('w',strtotime("-1 day"))] = "1551";
            $key[date('w',strtotime("-2 days"))] = "1300";
            $key[date('w',strtotime("-3 days"))] = "1450";
            $key[date('w',strtotime("-4 days"))] = "1420";
            $key[date('w',strtotime("-5 days"))] = "1200";
            $key[date('w',strtotime("-6 days"))] = "1100";
            Cache::forever('reloadly_cache_balance_graph_'.date('w'), $key);
        } else {
            Cache::forever('reloadly_cache_balance_graph_'.date('w'), [date('w') => '1540']);
        }

        return response()->json(['graph_data' => Cache::get('reloadly_cache_balance_graph_'.date('w'))], 200);
    }


}
