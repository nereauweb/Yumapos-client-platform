<?php

namespace App\Http\Livewire;

use App\Models\ServiceCountry;
use App\Models\ServiceOperator;
use Livewire\Component;
use Livewire\WithPagination;

class ServicesList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $sortAsc = true;
    public $sortField;

    public $countrySelected;
    public $relationshipAsc = true;
    public $relationshipSortField;


    /*
     * render function loads the list of combined operatorss
     * */
    public function render()
    {
		$service_update_errors = [];        
        $countriesList = ServiceCountry::orderBy('name')->select(['name', 'id'])->get();
        $service_operators = ServiceOperator::when($this->sortField, function ($query) {
            $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })->when($this->relationshipSortField, function ($query) {
            if ($this->relationshipSortField === 'country') {
                $query->orderBy(ServiceCountry::select('name')->whereColumn('service_countries.id', 'service_operators.country_id'), $this->relationshipAsc ? 'asc' : 'desc');
            }
        })->when($this->countrySelected, function ($query) {
            $query->where('country_id', $this->countrySelected);
        })->paginate(10);
        return view('livewire.services-list', compact('service_operators', 'countriesList'));
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

    // sortByrelationship orders the table depending on column which is clicked than it orders it asc/desc.
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

    // triggers the reload of render function once the combination of filters is submited
    public function commit(){}
}
