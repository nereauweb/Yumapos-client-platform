<?php

namespace App\Http\Livewire;

use App\Models\Payment as ModelsPayment;
use Livewire\Component;
use Livewire\WithPagination;

class Payment extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $sortField;
    public $sortAsc = true;
    public $userSelected;
    public $from;
    public $to;

    public $amount;

    private $bothDatesSet = false;

    public $filterByModel;

    public $unapprovedPayments;
    public $textBeforeAmount;
    public $positiveBalance;
    public $negativeBalance;
    public $diffBalance;

    public $typeSelected;
    public $stateSelected = null;

    public function render()
    {
        $this->unapprovedPayments = ModelsPayment::where('approved', 0)->count();
        $date_begin = ($this->from && !is_null($this->from)) ? $this->from . ' 00:00:00' : date("Y") . '-01-01 00:00:00';
		$date_end = ($this->to && !is_null($this->to)) ? $this->to . ' 23:59:59' : date("Y") . '-12-31 23:59:59';
		$payments = ModelsPayment::leftJoin('users as u', 'u.id', '=', 'payments.user_id')->where('payments.date', '>=', $date_begin)->where('payments.date', '<=', $date_end)
                                    ->leftJoin('providers as p', 'p.id', '=', 'payments.provider_id')
                                    ->when($this->sortField, function ($query) {
                                        $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
                                    })->when(($this->filterByModel && !is_null($this->filterByModel) && is_null($this->sortField)) && $this->filterByModel == 'users.name', function ($query) {
                                        $query->orderBy('u.name', $this->sortAsc ? 'asc' : 'desc');
                                    })->when($this->userSelected, function ($query) {
                                        $query->where('u.id', $this->userSelected);
                                    })->when($this->typeSelected, function ($query) {
                                        $query->where('payments.type', $this->typeSelected);
                                    })->when(!is_null($this->stateSelected), function ($query) {
                                        $query->where('payments.approved', $this->stateSelected);
            })->select('payments.*');

        $this->amount = $payments->sum('payments.amount');
        $this->positiveBalance = ModelsPayment::where('type', 1)->where('created_at', '>=', $date_begin)->where('created_at', '<=', $date_end)->where('approved', 1)->sum('amount');
        $this->positiveBalance -= ModelsPayment::where('type',3)->where('created_at', '>=', $date_begin)->where('created_at', '<=', $date_end)->where('approved', 1)->sum('amount');
        $this->negativeBalance = ModelsPayment::where('type', 2)->orWhere('type', 3)->where('approved', 1)->where('created_at', '>=', $date_begin)->where('created_at', '<=', $date_end)->sum('amount');
        $this->diffBalance = $this->positiveBalance - $this->negativeBalance;
        $payments = $payments->paginate(10);
        $users = \App\User::orderBy('name', 'asc')->get();
        return view('livewire.payment', compact('payments', 'users'));
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function filterBy($tableColumn) {
        $this->sortField = null;
        switch ($tableColumn) {
            case 'users.name':
                $this->filterByModel = 'users.name';
                $this->sortAsc = !$this->sortAsc;
                break;
            default:
                # code...
                break;
        }

        // $this->customSort = $tableColumn
    }

    function commit() {
        if ($this->stateSelected == 'null') {
            $this->textBeforeAmount = 'Total';
            $this->stateSelected = null;
        } else if ($this->stateSelected == -1) {
            $this->textBeforeAmount = 'Canceled Total';
        } else if ($this->stateSelected == 0) {
            $this->textBeforeAmount = 'Pending Total';
        } else if($this->stateSelected == 1) {
            $this->textBeforeAmount = 'Approved Total';
        }
    }
}
