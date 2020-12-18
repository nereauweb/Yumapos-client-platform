<?php

namespace App\Http\Livewire;

use App\Http\Ding\Model\Country;
use App\Models\ApiDingCountry;
use App\Models\ApiDingProduct;
use App\Models\ApiReloadlyOperator;
use App\Models\ApiReloadlyOperatorCountry;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DingProducts extends Component
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
    public $type = false;
    public $sortAsc = true;
    private $livewireOperators;
    public $countryFilter = false;

    public $countryId;
    public $countryName;

    public function render()
    {
        $countriesList = ApiDingCountry::all();

        $this->livewireOperators = ApiDingProduct::select('api_ding_products.*')->when($this->countryName, function ($query) {
            $query->join('api_ding_operators as ado', 'api_ding_products.ProviderCode', 'ado.ProviderCode')->where('ado.CountryIso','=', $this->countryName);
        })->when($this->sortField, function ($query) {
            $query->orderBy('api_ding_products.'.$this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })->when($this->customSort, function ($query) {
            if ($this->customSort == 'CountryName') {
                $query->join('api_ding_operators as ado', 'api_ding_products.ProviderCode', 'ado.ProviderCode')->join('api_ding_countries as adc', 'adc.CountryIso', 'ado.CountryIso')->orderBy('adc.'.$this->customSort, $this->sortAscCustom ? 'asc' : 'desc');
            } else {
                $query->join('api_ding_operators as ado', 'api_ding_products.ProviderCode', 'ado.ProviderCode')->orderBy('ado.'.$this->customSort, $this->sortAscCustom ? 'asc' : 'desc');
            }
        })->paginate(10);

        return view('livewire.ding-products', [
            'livewireProducts' => $this->livewireOperators,
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
        $this->sortField = '';
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
