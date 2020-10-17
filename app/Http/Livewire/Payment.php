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

    public function render()
    {

        $date_begin = ($this->from && !is_null($this->from)) ? $this->from . ' 00:00:00' : date("Y") . '-01-01 00:00:00';
		$date_end = ($this->to && !is_null($this->to)) ? $this->to . ' 23:59:59' : date("Y") . '-12-31 23:59:59';
		$payments = ModelsPayment::join('users as u', 'u.id', '=', 'payments.user_id')->where('payments.created_at', '>=', $date_begin)->where('payments.created_at', '<=', $date_end)
                                    ->when($this->sortField, function ($query) {
                                        $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
                                    })->when(($this->filterByModel && !is_null($this->filterByModel) && is_null($this->sortField)) && $this->filterByModel == 'users.name', function ($query) {
                                        $query->orderBy('u.name', $this->sortAsc ? 'asc' : 'desc');
                                    })->when($this->userSelected, function ($query) {
                                        $query->where('u.id', $this->userSelected);
            })->select('payments.*');
        $this->amount = $payments->sum('amount');
        $payments = $payments->paginate(10);
        $users = \App\User::role('user')->get();
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
        if (!is_null($this->userSelected) && $this->userSelected > 0) {
            $this->userIsSelected = true;
        }
    }
}
