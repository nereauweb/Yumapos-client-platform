<?php

namespace App\Http\Livewire;

use App\Models\ApiReloadlyOperator;
use App\Models\ApiReloadlyOperatorCountry;
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

    public function mount()
    {
        $this->totalOperations = auth()->user()->serviceOperations()->count();
        $this->finalAmount = auth()->user()->serviceOperations()->sum('final_amount');
        $this->userDiscount = auth()->user()->serviceOperations()->sum('user_discount');
        $this->userGain = auth()->user()->serviceOperations()->sum('user_gain');
        $this->userTotalGain = auth()->user()->serviceOperations()->sum('user_total_gain');
    }

    public function render()
    {
        $this->load();
        return view('livewire.user-operation', ['operations' => $this->operations]);
    }

    public function load()
    {
//        $this->countries = ApiReloadlyOperatorCountry::select('name', 'isoName')->groupBy('name', 'isoName')->get();
//        $this->operators = ApiReloadlyOperator::all();
        $this->operations = auth()->user()->serviceOperations()->when(($this->from !== null && !empty($this->from)), function ($query) {
            $query->where('created_at', '>=', $this->from);
        })->when(($this->to !== null && !empty($this->to)), function ($query) {
            $query->where('created_at', '<=', $this->to);
        })->when($this->selectedCountry, function ($query) {
            $query->where('request_country_iso', $this->selectedCountry);
        })->when($this->selectedOperator, function ($query) {
            $query->where('request_operatorId', $this->selectedOperator);
        })->paginate(10);
    }
}
