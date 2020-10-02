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
    public $customSort = null;
    public $sortAscCustom = true; 
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
            $this->customSort = '';
        }

        if ($this->customSort === 'country') {
            $operators = ApiReloadlyOperator::join('api_reloadly_operators_countries as country', 'country.parent_id', '=', 'api_reloadly_operators.id')
            ->orderBy('country.name', $this->sortAscCustom ? 'asc' : 'desc')
            ->select('api_reloadly_operators.*');
        }

        if ($this->customSort === 'fxCurrency') {
            $operators = ApiReloadlyOperator::join('api_reloadly_operators_fxs as fx', 'fx.parent_id', '=', 'api_reloadly_operators.id')
            ->orderBy('fx.currencyCode', $this->sortAscCustom ? 'asc' : 'desc')
            ->select('api_reloadly_operators.*');
        }

        if ($this->customSort === 'rate') {
            $operators = ApiReloadlyOperator::join('api_reloadly_operators_fxs as fx', 'fx.parent_id', '=', 'api_reloadly_operators.id')
            ->orderBy('fx.rate', $this->sortAscCustom ? 'asc' : 'desc')
            ->select('api_reloadly_operators.*');
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
        $this->customSort = '';

        $this->sortField = $field;
    }

    public function filter($type)
    {
        if ($this->customSort === $type) {
            $this->sortAscCustom = !$this->sortAscCustom;
        } else {
            $this->sortAscCustom = true;
        }

        $this->customSort = $type;
    }

}
