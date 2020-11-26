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

//    public $countries;
//    public $operators;

    private $operations;


    public function render()
    {
        $this->load();
        $operators = ServiceOperator::orderBy('name', 'asc')->get();
        return view('livewire.user-operation', ['operations' => $this->operations, 'operatorsData' => $operators]);
    }

    public function load()
    {
        $date_begin = ($this->from && !is_null($this->from)) ? $this->from . ' 00:00:00' : date('Y-m-d').' 00:00:00';
        $date_end = ($this->to && !is_null($this->to)) ? $this->to . ' 23:59:59' : date('Y-m-d').' 23:59:59';
        $this->operations = auth()->user()->serviceOperations()->where('created_at', '>=', $date_begin)->where('created_at', '<=', $date_end)
            ->when(date('d m Y',strtotime($date_begin)) == date('d m Y',strtotime($date_begin)), function ($query) use ($date_begin, $date_end) {
                $query->where('created_at', '>=', $date_begin);
            })
        ->when($this->selectedCountry, function ($query) {
            $query->where('request_country_iso', $this->selectedCountry);
        })->when($this->selectedOperator, function ($query) {
//            implement logic to fetch data related to selected query
            $query->where('request_operatorId', $this->selectedOperator);
        });

        $this->totalOperations = $this->operations->count();
        $this->finalAmount = $this->operations->sum('final_amount');
        $this->userDiscount = $this->operations->sum('user_discount');
        $this->userGain = $this->operations->sum('user_gain');
        $this->userTotalGain = $this->operations->sum('user_total_gain');

        $this->operations = $this->operations->paginate(10);
    }
}
