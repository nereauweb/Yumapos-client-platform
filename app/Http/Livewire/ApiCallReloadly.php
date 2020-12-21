<?php

namespace App\Http\Livewire;

use App\Models\ApiReloadlyCall;
use Livewire\Component;
use Livewire\WithPagination;

class ApiCallReloadly extends Component
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
        /*
         * Get list of api calls limited to the api of Ding
         * the query that returns results is $operations variable
         * view that gets returned is located in livewire/api-call-ding.blade.php
         * */
        $date_begin = ($this->from && !is_null($this->from)) ? $this->from . ' 00:00:00' : date("Y") . '-01-01 00:00:00';
        $date_end = ($this->to && !is_null($this->to)) ? $this->to . ' 23:59:59' : date("Y") . '-12-31 23:59:59';
        $operations = ApiReloadlyCall::where('created_at','>=',$date_begin)->where('created_at','<=',$date_end)->when($this->sortField, function ($query) {
            $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })->when($this->userSelected, function($query) {
            $query->where('user_id', $this->userSelected);
        })->orderBy('id', 'desc');

        $this->operationsCount = $operations->count();

        if ($this->operationId !== 0 && !is_null($this->operationId)) {
            $operations = $operations->where('id', $this->operationId);
        }

        $operations = $operations->paginate(10);

        $users = \App\User::role('user')->get();


        return view('livewire.api-call-reloadly', compact('operations', 'date_begin', 'date_end', 'users'));
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

    /*
     * commit function serves solely to trigger the button in interface,
     * meaning we don't trigger anything unless button is clicked,
     * when button gets clicked this function gets called,
     * which triggers the load of render function with the applied filters
     * */
    public function commit() {}
    /*
     * searchById function serves for purpose of filtering by:
     * id table, meaning it refreshes the render operation which makes available the query to filter by id
     * */
    public function searchById() {}
}
