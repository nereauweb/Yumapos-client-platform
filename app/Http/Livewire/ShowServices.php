<?php

namespace App\Http\Livewire;

use App\Models\ApiReloadlyOperator;
use Livewire\Component;
use Livewire\WithPagination;

class ShowServices extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $sortField;
    public $start;
    public $end;
    public $sortAsc = true;

    public function render()
    {
        $operators = ApiReloadlyOperator::where(function ($query) {
            $query->where('operatorId', 'like', '%'.$this->search.'%')
                ->orWhere('name', 'like', '%'.$this->search.'%');
        })->when($this->sortField, function ($query) {
                $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        });
        
        if ($this->start && $this->end) {
            $operators = $operators->where('created_at','>=',$this->start)->where('created_at','<=',$this->end);
        }

        $operators = $operators->paginate(10);

        return view('livewire.show-services', [
            'operators' => $operators
        ]);
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

}
