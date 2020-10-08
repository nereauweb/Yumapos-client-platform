<?php

namespace App\Http\Livewire;

use App\Models\ApiReloadlyOperator;
use App\Models\ApiReloadlyOperatorCountry;
use Livewire\Component;
use Livewire\WithPagination;

class ShowServices extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $searchData; 
    public $sortField;
    public $customSort = null;
    public $sortAscCustom = true; 
    public $start;
    public $end;
    public $type;
    public $sortAsc = true;

    public $countryId;

    public function render()
    {
        $operators = ApiReloadlyOperator::join('api_reloadly_operators_countries as country', 'country.parent_id', '=', 'api_reloadly_operators.id')
        ->join('api_reloadly_operators_fxs as fx', 'fx.parent_id', '=', 'api_reloadly_operators.id')
        ->select('api_reloadly_operators.*')->when($this->countryId, function ($query) {
            $query->where('country.parent_id', $this->countryId);
        })->when($this->sortField, function ($query) {
            $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })->when(($this->start && $this->end), function ($query) {
            $query->where('api_reloadly_operators.created_at','>=', \Carbon\Carbon::parse($this->start))->where('api_reloadly_operators.created_at','<=', \Carbon\Carbon::parse($this->end));
        })->when($this->customSort, function ($query) {
            $query->orderBy($this->customSort, $this->sortAscCustom ? 'asc' : 'desc');
        })->when($this->type, function ($query) {
            $query->where('api_reloadly_operators.denominationType', $this->type);
        });
        
        $countriesList = ApiReloadlyOperatorCountry::orderBy('name', 'asc')->get();
        $typesList = ApiReloadlyOperator::select('denominationType')->distinct('denominationType')->get();
    
        $operators = $operators->paginate(10);

        return view('livewire.show-services', [
            'operators' => $operators,
            'countriesList' => $countriesList,
            'typesList' => $typesList
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

    public function resetDate() 
    {
        $this->start = '';
        $this->end = '';
    }

    public function search()
    {
        $this->searchData = $this->search;
    }

    public function resetSearch()
    {
        $this->search = '';
        $this->searchData = '';
    }

    public function commit() {}
}
