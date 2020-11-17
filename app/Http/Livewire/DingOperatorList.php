<?php

namespace App\Http\Livewire;

use App\Models\ApiDingCountry;
use App\Models\ApiDingOperator;
use Livewire\Component;
use Livewire\WithPagination;

class DingOperatorList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $sortField;
    public $sortAsc = true;
    public $countrySelected;

    public $relationshipAsc = true;
    public $relationshipSortField;

    public function render()
    {
        $livewireDingOperators = ApiDingOperator::select('api_ding_operators.*')->when($this->sortField, function ($query) {
            $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })->when($this->countrySelected, function ($query) {
            $query->select('api_ding_operators.*')->where('countryIso', $this->countrySelected);
        })->when($this->relationshipSortField, function ($query) {
            $query->select('api_ding_operators.*')->orderBy(ApiDingCountry::select('CountryName')->whereColumn('api_ding_countries.CountryIso', 'api_ding_operators.CountryIso'), $this->relationshipAsc ? 'asc' : 'desc');
        })->paginate(10);

        $countriesList = $countriesList = ApiDingCountry::orderBy('CountryName')->get();

        return view('livewire.ding-operator-list', [
            'livewireDingOperators' => $livewireDingOperators,
            'dingCountries' => $countriesList
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

    public function sortByRelationship($field)
    {
        if ($this->relationshipSortField === $field) {
            $this->relationshipAsc = !$this->relationshipAsc;
        } else {
            $this->relationshipAsc = true;
        }
        $this->sortField = '';
        $this->relationshipSortField = $field;
    }

    public function commit(){}
}
