<?php

namespace App\Http\Livewire;

use App\Models\ServiceOperation;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DashboardOperationList extends Component
{
    public $filterSelected = 'day';
    public $usersDetails;
    public $countriesList;
    public $operationsList;

    public function render()
    {
        $this->usersDetails = ServiceOperation::select(DB::raw('sum(user_amount) amount, service_operations.*'))->orderBy('amount', 'desc')->groupBy('user_id')->take(5)->get();
        $this->countriesList = ServiceOperation::select(DB::raw('sum(user_amount) amount, service_operations.*'))->orderBy('amount', 'desc')->groupBy('request_country_iso')->take(5)->get();
        $this->operationsList = ServiceOperation::select(DB::raw('sum(user_amount) amount, service_operations.*'))->orderBy('amount', 'desc')->groupBy('request_operatorId')->take(5)->get();
        $services = auth()->user()->adminAccessServices($this->filterSelected);
        return view('livewire.dashboard-operation-list', compact('services'));
    }

    public function mount()
    {

    }
}
