<?php

namespace App\Http\Livewire;

use App\Models\ServiceOperation;
use Carbon\Carbon;
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
        $this->usersDetails = ServiceOperation::select(DB::raw('sum(user_amount) amount, service_operations.*'))->when($this->filterSelected, function ($query) {
            $this->filter($query);
        })->orderBy('amount', 'desc')->groupBy('user_id')->take(5)->get();
        $this->countriesList = ServiceOperation::select(DB::raw('sum(user_amount) amount, service_operations.*'))->when($this->filterSelected, function ($query) {
            $this->filter($query);
        })->orderBy('amount', 'desc')->groupBy('request_country_iso')->take(5)->get();
        $this->operationsList = ServiceOperation::select(DB::raw('sum(user_amount) amount, service_operations.*'))->when($this->filterSelected, function ($query) {
            $this->filter($query);
        })->orderBy('amount', 'desc')->groupBy('request_operatorId')->take(5)->get();
        $services = auth()->user()->adminAccessServices($this->filterSelected);
        return view('livewire.dashboard-operation-list', compact('services'));
    }

    public function filter($query)
    {
        $q = '';
        switch ($this->filterSelected) {
            case 'day':
                $q = $query->whereDate('created_at', '=', '2020-09-20');
                break;
            case 'yesterday':
                $q = $query->whereDate('created_at', '=', '2020-09-19');
                break;
            case 'week':
                $q = $query->whereBetween('created_at', [Carbon::createFromDate('2020', '09', '6')->startOfWeek(), Carbon::createFromDate('2020', '09', '6')->endOfWeek()]);
                break;
            case 'month':
                $q = $query->whereMonth('created_at', '=', Carbon::now()->startOfMonth()->subMonth(3));
                break;
            default:
                break;
        }

        return $q;
    }
}
