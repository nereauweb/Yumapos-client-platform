<?php

namespace App\Http\Livewire;

use App\Models\ApiDingCall;
use Livewire\Component;
use Livewire\WithPagination;

class ApiCallDing extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $sortField;
    public $sortAsc = true;

    public $from;
    public $to;

    public $operationId;

    public $userSelected;

    public $operationsCount;

    public function render()
    {
        $date_begin = ($this->from && !is_null($this->from)) ? $this->from . ' 00:00:00' : date("Y") . '-01-01 00:00:00';
        $date_end = ($this->to && !is_null($this->to)) ? $this->to . ' 23:59:59' : date("Y") . '-12-31 23:59:59';
        $operations = ApiDingCall::where('created_at','>=',$date_begin)->where('created_at','<=',$date_end)->when($this->sortField, function ($query) {
            $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })->when($this->userSelected, function($query) {
            $query->where('user_id', $this->userSelected);
        });

        if ($this->operationId !== 0 && !is_null($this->operationId)) {
            $operations = $operations->where('id', '=', $this->operationId);
        }

        $this->operationsCount = $operations->count();

        $operations = $operations->paginate(10);

        $users = \App\User::role('user')->get();

        return view('livewire.api-call-ding', compact('operations', 'date_begin', 'date_end', 'users'));
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

    public function commit() {}

    public function searchById() {}
}
