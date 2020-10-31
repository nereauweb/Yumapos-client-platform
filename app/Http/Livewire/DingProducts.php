<?php

namespace App\Http\Livewire;

use App\Http\Ding\Model\Country;
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
    public $type;
    public $sortAsc = true;

    public $countryId;
    public $countryName;

    public function render()
    {
//        $livewireOperators = ApiDingProduct::leftJoin('api_ding_operators as operators', 'operators.ProviderCode', '=', 'api_ding_products.ProviderCode')
//        ->select('api_reloadly_operators.*', 'fx.currencyCode as currencyCode', 'fx.rate as rate', 'country.name as countryName', 'country.isoName as isoName')->when($this->countryName, function ($query) {
//            $query->where('name', $this->countryName);
//        })->when($this->sortField, function ($query) {
//            $query->orderBy('api_reloadly_operators.'.$this->sortField, $this->sortAsc ? 'asc' : 'desc');
//        })->when(($this->start && $this->end), function ($query) {
//            $query->where('api_reloadly_operators.created_at','>=', \Carbon\Carbon::parse($this->start))->where('api_reloadly_operators.created_at','<=', \Carbon\Carbon::parse($this->end));
//        })->when($this->customSort, function ($query) {
//            $query->orderBy($this->customSort, $this->sortAscCustom ? 'asc' : 'desc');
//        })->when($this->type, function ($query) {
//            $query->where('api_reloadly_operators.denominationType', $this->type);
//        });

        $countriesList = DB::table('api_reloadly_operators_countries')->select(DB::raw('count(*) as countries_count, name'))->groupBy('name')->get();
        $typesList = ApiReloadlyOperator::select('denominationType')->distinct('denominationType')->get();
//
//        $livewireOperators = $livewireOperators->distinct()->paginate(10);

        $livewireOperators = ApiDingProduct::paginate(10);
        return view('livewire.ding-products', [
            'livewireProducts' => $livewireOperators,
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

    public function commit() {
        if (isset($this->countryId)) {
            $countries = ApiReloadlyOperatorCountry::where('name', '=', $this->countryName);
        }
    }
}
