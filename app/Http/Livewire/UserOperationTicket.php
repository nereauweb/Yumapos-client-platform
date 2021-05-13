<?php

namespace App\Http\Livewire;

use App\Models\ApiReloadlyOperatorCountry;
use App\Models\ServiceOperation;
use App\Models\ServiceOperator;
use App\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserOperationTicket extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $sortField;
    public $sortAsc = true;

    public $to;
    public $from;

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
        $date_begin = ($this->from && !is_null($this->from)) ? $this->from . ' 00:00:00' : date("Y-m-d") . ' 00:00:00';
        $date_end = ($this->to && !is_null($this->to)) ? $this->to . ' 23:59:59' : date("Y-m-d") . ' 23:59:59';
            $operations = ServiceOperation::when(date('d m Y',strtotime($date_begin)) == date('d m Y',strtotime($date_begin)), function ($query) use ($date_begin, $date_end) {
                $query->where('created_at', '>=', $date_begin);
            })->when($this->sortField, function ($query) {
            $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })->when($this->selectedCountry, function ($query) {
	        $query->where('request_country_iso', '=', $this->selectedCountry);
        })->where('created_at', '>=', $date_begin)->where('created_at', '<=', $date_end);

        if ($this->operationId) {
            $operations = ServiceOperation::where('id', $this->operationId);
        } else {
			$operations = ServiceOperation::whereNotNull('report_status');
		}
        
		$operations->where('user_id', \Auth::user()->id);
		$this->totalOperationsCount = $operations->count();
			
        $this->operationsSum = $operations->sum('user_discount');
        $this->totalCommissions = $operations->sum('platform_commission');
        $this->totalGrossPlatformGain = $operations->sum('platform_total_gain');
        $this->totalNetPlatformGains = $operations->sum('platform_total_gain') - $operations->sum('user_discount');
        $this->sentAmount = $operations->sum('sent_amount');
        $this->platformTotalGain = $operations->sum('platform_total_gain') - $operations->sum('user_discount');
        $operations = $operations->paginate(10);
        return view('livewire.user-operation-ticket', compact('operations', 'date_begin','date_end'));
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

    // searchById is bind to button inside view: livewire/operation.blade.php to the search by id input
    public function searchById() {}	
}
