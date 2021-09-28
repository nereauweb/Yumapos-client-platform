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


    /*
     * render function loads the list of combined operatorss
     * */
    public function render()
    {
		$service_update_errors = [];
        $ding_operators = ApiDingOperator::orderBy('Name')->pluck('ProviderCode','Name');
        $ding_operators_options = '';
        foreach($ding_operators as $ding_operator_name => $ding_ProviderCode){
            $service_operator = ServiceOperator::where('name',$ding_operator_name)->orWhere('ding_ProviderCode',$ding_ProviderCode)->first();
            if ($service_operator){
                $service_operator->ding_providerCode = $ding_ProviderCode;
                $service_operator->save();
            } else {
                $country = ApiDingOperator::where('ProviderCode',$ding_ProviderCode)->first()->country;
                if ($country){
					$service_country = ServiceCountry::updateOrCreate(['iso'=>$country->CountryIso],['name'=>$country->CountryName]);
				} else {
					$ding_operator = ApiDingOperator::where('Name',$ding_operator_name)->first();
					if (!$ding_operator||!$ding_operator->country) { 
						array_push($service_update_errors,'No country for ding operator: ' . $ding_operator_name);
						continue; 
					}
					$service_country = ServiceCountry::updateOrCreate(['iso'=>$ding_operator->country->CountryIso],['name'=>$ding_operator->country->CountryName]);
				}
                ServiceOperator::create([
                    'name' => $ding_operator_name,
                    'country_id' => $service_country->id,
                    'master' => 'ding',
                    'ding_ProviderCode' => $ding_ProviderCode,
                ]);
            }
            $ding_operators_options .= '<option value="'.$ding_ProviderCode.'">'.$ding_operator_name.'</option>';
        }

        $reloadly_operators = ApiReloadlyOperator::orderBy('name')->pluck('operatorId','name');
        $reloadly_operators_options = '';
        foreach($reloadly_operators as $reloadly_operator_name => $reloadly_operatorId){
            $service_operator = ServiceOperator::where('name',$reloadly_operator_name)->orWhere('reloadly_operatorId',$reloadly_operatorId)->first();
            if ($service_operator){
                if (!$service_operator->reloadly_operatorId == $reloadly_operatorId){
                    $service_operator->reloadly_operatorId = $reloadly_operatorId;
                    $service_operator->save();
                }
            } else {
                $country = ApiReloadlyOperator::where('operatorId',$reloadly_operatorId)->first()->country;
                $service_country = ServiceCountry::updateOrCreate(['iso'=>$country->isoName],['name'=>$country->name]);
                ServiceOperator::create([
                    'name' => $reloadly_operator_name,
                    'country_id' => $service_country->id,
                    'master' => 'reloadly',
                    'reloadly_operatorId' => $reloadly_operatorId,
                ]);
            }
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
