<?php

namespace App\Http\Livewire;

use App\Models\ApiReloadlyOperatorCountry;
use App\Models\ServiceOperation;
use App\Models\ServiceOperator;
use App\User;
use Livewire\Component;
use Livewire\WithPagination;

class Operation extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $sortField;
    public $sortAsc = true;

    public $to;
    public $from;
    public $userSelected;

    public $selectedCountry;
    public $selectedOperator;

    public $operationsSum;
    public $totalCommissions;
    public $totalGrossPlatformGain;
    public $totalNetPlatformGains;
    public $sentAmount;
    public $platformTotalGain;

    public $operationId;


    public $totalOperationsCount;

    /*
     * render function loads service_operations table with its data
     * the public variables are filled with the bindings done inside the view: livewire/operation.blade.php
     * */
    public function render()
    {
        $users = User::pluck('name', 'id');
        $usedOperators = ServiceOperator::orderBy('name', 'asc')->pluck('name','id');
        $user_name = "All users";
        $user_id = 0;
        if ($this->userSelected !== 0 && !is_null($this->userSelected)) {
            $user = User::findOrFail($this->userSelected);
            $user_name = $user->name;
            $user_id = $user->id;
        }

        $date_begin = ($this->from && !is_null($this->from)) ? $this->from . ' 00:00:00' : date("Y-m-d") . ' 00:00:00';
        $date_end = ($this->to && !is_null($this->to)) ? $this->to . ' 23:59:59' : date("Y-m-d") . ' 23:59:59';
            $operations = ServiceOperation::when(date('d m Y',strtotime($date_begin)) == date('d m Y',strtotime($date_begin)), function ($query) use ($date_begin, $date_end) {
                $query->where('created_at', '>=', $date_begin);
            })->when($this->sortField, function ($query) {
            $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })->when($this->selectedCountry, function ($query) {
	        $query->where('request_country_iso', '=', $this->selectedCountry);
        })->when($this->selectedOperator, function ($query) {
            $selectedOperator = ServiceOperator::findOrFail($this->selectedOperator);
            if (is_null($selectedOperator->reloadly_operatorId) && !is_null($selectedOperator->ding_ProviderCode)) {
                $query->where('request_ProviderCode', $selectedOperator->ding_ProviderCode);
            } else if (is_null($selectedOperator->ding_ProviderCode) && !is_null($selectedOperator->reloadly_operatorId)) {
                $query->where('request_operatorId', $selectedOperator->reloadly_operatorId);
            } else {
                $query->where('request_operatorId', $selectedOperator->reloadly_operatorId)->orWhere('request_ProviderCode', $selectedOperator->ding_ProviderCode);
            }
        })->where('created_at', '>=', $date_begin)->where('created_at', '<=', $date_end);

        if ($this->operationId) {
            $operations = ServiceOperation::where('id', $this->operationId);
        }
        
        if ($user_id != 0) {
            $operations->where('user_id', $user_id);
            $this->totalOperationsCount = $operations->count();
        } else {
			$this->totalOperationsCount = $operations->count();
		}
		
		$report_operations = $operations;
		$operations = $operations->paginate(10);
		
		$report_operations->where(function ($query) {
				$query->whereNull('report_status')->orWhere('report_status','!=','refunded');
			});
		
        $this->operationsSum = $report_operations->sum('user_discount');
        $this->totalCommissions = $report_operations->sum('platform_commission');
        $this->totalGrossPlatformGain = $report_operations->sum('platform_total_gain');
        $this->totalNetPlatformGains = $report_operations->sum('platform_total_gain') - $report_operations->sum('user_discount');
        $this->sentAmount = $report_operations->sum('sent_amount');
        $this->platformTotalGain = $report_operations->sum('platform_total_gain') - $report_operations->sum('user_discount');
        
        return view('livewire.operation', compact('operations','users', 'user_name', 'date_begin', 'date_end', 'user_id', 'usedOperators'));
    }

    /*
     * sortBy function filters based on the column clicked inside view!
     * */
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    /*
     * commit function is used when the combinations of filters inside livewire/operation.blade.php are submited
     * */
    public function commit() {
        if ($this->userSelected == 0) {
            $this->userSelected = null;
        }
    }

    // searchById is bind to button inside view: livewire/operation.blade.php to the search by id input
    public function searchById() {}	
	
	public function manage_ticket($id,$status) {
        $operation = ServiceOperation::find($id);
        $operation->update(['report_status' => $status]);
		if ($status == 'refunded'){
			$operation_cost = $operation->user_old_plafond - $operation->user_new_plafond;
			$user= $operation->user;
			$user->plafond = $user->plafond + $operation_cost;
			$user->save();
			if ($operation->agent_operation){
				$agent = $operation->agent_operation->user;
				$agent->credit = $agent->credit - $operation->agent_operation->commission;
				$agent->save();
			}
		}
    }
}
