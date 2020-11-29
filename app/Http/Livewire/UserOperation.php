<?php

namespace App\Http\Livewire;

use App\Models\ApiReloadlyOperator;
use App\Models\ApiReloadlyOperatorCountry;
use App\Models\ServiceCountry;
use App\Models\ServiceOperator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class UserOperation extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $to;
    public $from;

    public $totalOperations;
    public $finalAmount;
    public $userDiscount;
    public $userGain;
    public $userTotalGain;

    public $selectedCountry;
    public $selectedOperator;

    public $operationId;

//    public $countries;
//    public $operators;

    private $operations;
    private $usedOperators;

    public function render()
    {
        $this->load();
        $operators = auth()->user()->serviceOperations;
        return view('livewire.user-operation', ['operations' => $this->operations, 'operatorsData' => $this->usedOperators]);
    }

    public function load()
    {

        $this->usedOperators = ServiceOperator::orderBy('name', 'asc')->pluck('name','id');

        $date_begin = ($this->from && !is_null($this->from)) ? $this->from . ' 00:00:00' : date('Y-m-d').' 00:00:00';
        $date_end = ($this->to && !is_null($this->to)) ? $this->to . ' 23:59:59' : date('Y-m-d').' 23:59:59';
        $this->operations = auth()->user()->serviceOperations()->where('created_at', '>=', $date_begin)->where('created_at', '<=', $date_end)
            ->when(date('d m Y',strtotime($date_begin)) == date('d m Y',strtotime($date_begin)), function ($query) use ($date_begin, $date_end) {
                $query->where('created_at', '>=', $date_begin);
            })
        ->when($this->selectedCountry, function ($query) {
            $query->where('request_country_iso', $this->selectedCountry);
        })->when($this->selectedOperator, function ($query) {
            $selectedOperator = ServiceOperator::findOrFail($this->selectedOperator);
            if (is_null($selectedOperator->reloadly_operatorId) && !is_null($selectedOperator->ding_ProviderCode)) {
                $query->where('request_ProviderCode', $selectedOperator->ding_ProviderCode);
            } else if (is_null($selectedOperator->ding_ProviderCode) && !is_null($selectedOperator->reloadly_operatorId)) {
                $query->where('request_operatorId', $selectedOperator->reloadly_operatorId);
            } else {
                $query->where('request_operatorId', $selectedOperator->reloadly_operatorId)->orWhere('request_ProviderCode', $selectedOperator->ding_ProviderCode);
            }
        });

        if ($this->operationId) {
            $this->operations = auth()->user()->serviceOperations()->where('id', $this->operationId);
        }

        $this->totalOperations = $this->operations->count();
        $this->finalAmount = $this->operations->sum('final_amount');
        $this->userDiscount = $this->operations->sum('user_discount');
        $this->userGain = $this->operations->sum('user_gain');
        $this->userTotalGain = $this->operations->sum('user_total_gain');

        $this->operations = $this->operations->paginate(10);
    }

    public function searchById() {}
}
