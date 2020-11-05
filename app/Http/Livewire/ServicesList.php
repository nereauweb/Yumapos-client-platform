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
    private $ding_operators;
    private $reloadly_operators;
    private $service_operators;

    public function mount()
    {

    }

    public function render()
    {
        $this->ding_operators = ApiDingOperator::pluck('ProviderCode','Name');
//        $this->ding_operators_options = '';
//        foreach($this->ding_operators as $ding_operator_name => $ding_ProviderCode){
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
//            $this->ding_operators_options .= '<option value="'.$ding_ProviderCode.'">'.$ding_operator_name.'</option>';
//        }

        $this->reloadly_operators = ApiReloadlyOperator::pluck('operatorId','name');
//        $this->reloadly_operators_options = '';
//        foreach($this->reloadly_operators as $reloadly_operator_name => $reloadly_operatorId){
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
//            $this->reloadly_operators_options .= '<option value="'.$reloadly_operatorId.'">'.$reloadly_operator_name.'</option>';
//        }
        $this->service_operators = ServiceOperator::orderBy('name')->paginate(10);

        return view('livewire.services-list', ['ding_operators' => $this->ding_operators, 'reloadly_operators' => $this->reloadly_operators, 'service_operators' => $this->service_operators]);
    }
}
