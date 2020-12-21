<?php

namespace App\Http\Livewire;

use App\Http\Ding\Model\Country;
use App\Models\ApiReloadlyOperator;
use App\Models\ApiReloadlyOperatorCountry;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ReloadlyOperators extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $searchData;
    public $sortField;
    public $customSort = null;
    public $sortAscCustom = true;
    public $sortAsc = true;

    public $countryId;
    public $countryName;

    // render function loads reloadly operators list
    public function render()
    {
        $livewireOperators = ApiReloadlyOperator::leftJoin('api_reloadly_operators_countries as country', 'country.parent_id', '=', 'api_reloadly_operators.id')
        ->leftJoin('api_reloadly_operators_fxs as fx', 'fx.parent_id', '=', 'api_reloadly_operators.id')
        ->select('api_reloadly_operators.*', 'fx.currencyCode as currencyCode', 'fx.rate as rate', 'country.name as countryName', 'country.isoName as isoName')->when($this->countryName, function ($query) {
            $query->where('country.name', $this->countryName);
        })->when($this->sortField, function ($query) {
            $query->orderBy('api_reloadly_operators.'.$this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })->when($this->customSort, function ($query) {
            $query->orderBy($this->customSort, $this->sortAscCustom ? 'asc' : 'desc');
        });

        $countriesList = DB::table('api_reloadly_operators_countries')->select(DB::raw('count(*) as countries_count, name'))->orderBy('name', 'asc')->groupBy('name')->get();
        $livewireOperators = $livewireOperators->distinct()->paginate(10);

        return view('livewire.reloadly-operators', [
            'livewireOperators' => $livewireOperators,
            'countriesList' => $countriesList,
        ]);
    }

    // sortBy field orders the table based on column clicked
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

    // orders the table based on the column clicked when we need a join in the query
    public function filter($type)
    {
        if ($this->customSort === $type) {
            $this->sortAscCustom = !$this->sortAscCustom;
        } else {
            $this->sortAscCustom = true;
        }
        $this->sortField = '';
        $this->customSort = $type;
    }

    // resets the date after submission of the form
    public function resetDate()
    {
        $this->start = '';
        $this->end = '';
    }

    // updates value of searchData to the new value, than that is used inside the query to return the searched data
    public function search()
    {
        $this->searchData = $this->search;
    }

    // resets the search
    public function resetSearch()
    {
        $this->search = '';
        $this->searchData = '';
    }

    // returns operations limited to country selected
    public function commit() {
        if (isset($this->countryId)) {
            $countries = ApiReloadlyOperatorCountry::where('name', '=', $this->countryName);
        }
    }
}
