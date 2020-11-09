<?php

namespace App\Http\Livewire;

use App\Models\ApiDingOperator;
use App\Models\ApiReloadlyOperator;
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

    public function mount()
    {

    }

    public function render()
    {
        $ding_operators = ApiDingOperator::pluck('ProviderCode','Name');
        $ding_operators_options = '';
        foreach($ding_operators as $ding_operator_name => $ding_ProviderCode){
//            $service_operator = ServiceOperator::where('name',$ding_operator_name)->orWhere('ding_ProviderCode',$ding_ProviderCode)->first();
//            if ($service_operator){
//                $service_operator->ding_providerCode = $ding_ProviderCode;
//                $service_operator->save();
//            } else {
//                $country = ApiDingOperator::where('ProviderCode',$ding_ProviderCode)->first()->country;
//                $service_country = ServiceCountry::updateOrCreate(['iso'=>$country->CountryIso],['name'=>$country->CountryName]);
//                ServiceOperator::create([
//                    'name' => $ding_operator_name,
//                    'country_id' => $service_country->id,
//                    'master' => 'ding',
//                    'ding_ProviderCode' => $ding_ProviderCode,
//                ]);
//            }
            $ding_operators_options .= '<option value="'.$ding_ProviderCode.'">'.$ding_operator_name.'</option>';
        }

        $reloadly_operators = ApiReloadlyOperator::pluck('operatorId','name');
        $reloadly_operators_options = '';
        foreach($reloadly_operators as $reloadly_operator_name => $reloadly_operatorId){
//            $service_operator = ServiceOperator::where('name',$reloadly_operator_name)->orWhere('reloadly_operatorId',$reloadly_operatorId)->first();
//            if ($service_operator){
//                if (!$service_operator->reloadly_operatorId == $reloadly_operatorId){
//                    $service_operator->reloadly_operatorId = $reloadly_operatorId;
//                    $service_operator->save();
//                }
//            } else {
//                $country = ApiReloadlyOperator::where('operatorId',$reloadly_operatorId)->first()->country;
//                $service_country = ServiceCountry::updateOrCreate(['iso'=>$country->isoName],['name'=>$country->name]);
//                ServiceOperator::create([
//                    'name' => $reloadly_operator_name,
//                    'country_id' => $service_country->id,
//                    'master' => 'reloadly',
//                    'reloadly_operatorId' => $reloadly_operatorId,
//                ]);
//            }
            $reloadly_operators_options .= '<option value="'.$reloadly_operatorId.'">'.$reloadly_operator_name.'</option>';
        }
        $countriesList = ServiceCountry::orderBy('name')->select(['name', 'id'])->get();
        $service_operators = ServiceOperator::when($this->sortField, function ($query) {
            $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })->when($this->relationshipSortField, function ($query) {
            if ($this->relationshipSortField === 'country') {
                $query->orderBy(ServiceCountry::select('name')->whereColumn('service_countries.id', 'service_operators.country_id'), $this->relationshipAsc ? 'asc' : 'desc');
            } elseif ($this->relationshipSortField === 'ding') {
                $query->orderBy(ApiDingOperator::select('Name')->whereColumn('api_ding_operators.ProviderCode', 'service_operators.ding_ProviderCode'), $this->relationshipAsc ? 'asc' : 'desc');
            } elseif ($this->relationshipSortField === 'reloadly') {
                $query->orderBy(ApiReloadlyOperator::select('name')->whereColumn('api_reloadly_operators.operatorId', 'service_operators.reloadly_operatorId'), $this->relationshipAsc ? 'asc' : 'desc');
            }
        })->when($this->countrySelected, function ($query) {
            $query->where('country_id', $this->countrySelected);
        })->paginate(10);
        return view('livewire.services-list', compact('ding_operators', 'reloadly_operators', 'service_operators', 'countriesList', 'ding_operators_options', 'reloadly_operators_options'));
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
