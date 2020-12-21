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

    // render function loads operator list andreturns the view livewire/ding-operator-list.blade.php this component
    // than is called inside admin/ding/list.blade.php
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
    // sortBy sorts the query desc/asc based on the column clicked
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    // sortByRelationship function sorts the columns in table depending on what is clicked.
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

    /*
     * sortBy function serves for the purpose of applying the filters to the query inside render function,
     * here we update the variables which we use as filters in our custom query inside render function
     * */
    public function commit(){}
}
