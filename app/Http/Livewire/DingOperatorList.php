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

    public function render()
    {
        $livewireDingOperators = ApiDingOperator::when($this->sortField, function ($query) {
            $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })->when($this->countrySelected, function ($query) {
            $query->where('countryIso', $this->countrySelected);
        })->paginate(10);

        $countriesList = $countriesList = ApiDingCountry::all();

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

    public function commit(){}
}
