<?php

namespace App\Http\Livewire;

use App\Models\ApiReloadlyOperatorCountry;
use App\Models\ServiceOperation;
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


    public $totalOperationsCount;

    public function render()
    {
        $users = User::pluck('name', 'id');
        $user_name = "All users";
        $user_id = 0;
        if ($this->userSelected !== 0 && !is_null($this->userSelected)) {
            $user = User::findOrFail($this->userSelected);
            $user_name = $user->name;
            $user_id = $user->id;
        }

        $date_begin = ($this->from && !is_null($this->from)) ? $this->from . ' 00:00:00' : date("Y-m-d") . ' 00:00:00';
        $date_end = ($this->to && !is_null($this->to)) ? $this->to . ' 23:59:59' : date("Y-m-d") . ' 23:59:59';
        $operations = ServiceOperation::when(date('d m Y',strtotime($date_begin)) == date('d m Y',strtotime($date_end)), function ($query) use ($date_begin, $date_end) {
                $query->where('created_at', '>=', $date_begin)->where('created_at', '<=', $date_end);
            })->when($this->sortField, function ($query) {
            $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })->when($this->selectedCountry, function ($query) {
	    $query->where('request_country_iso', '=', $this->selectedCountry);
        })->when($this->selectedOperator, function ($query) {
            $query->where('request_operatorId', '=', $this->selectedOperator);
        });
        $this->totalOperationsCount = $operations->count();
        if ($user_id != 0) {
            $operations->where('user_id', $user_id);
            $this->totalOperationsCount = $operations->count();
        }
        $operations = $operations->paginate(10);
        return view('livewire.operation', compact('operations','users', 'user_name', 'date_begin', 'date_end', 'user_id'));
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

    public function commit() {
        if ($this->userSelected == 0) {
            $this->userSelected = null;
        }
    }
}
