<?php

namespace App\Http\Livewire;

use App\Models\ApiReloadlyCall;
use Livewire\Component;
use Livewire\WithPagination;

class ApiCall extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $sortField;
    public $sortAsc = true;
    
    public $date_begin;
    public $date_end;

    public function render()
    {
        $date_begin = ($this->date_begin && !is_null($this->date_begin)) ? $this->date_begin . ' 00:00:00' : date("Y-m-d") . ' 00:00:00';
		$date_end = ($this->date_end && !is_null($this->date_end)) ? $this->date_end . ' 23:59:59' : date("Y-m-d") . ' 23:59:59';
        $operations = ApiReloadlyCall::where('created_at','>=',$date_begin)->where('created_at','<=',$date_end)->when($this->sortField, function ($query) {
            $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })->paginate(10);

        return view('livewire.api-call', compact('operations', 'date_begin', 'date_end'));
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
}
