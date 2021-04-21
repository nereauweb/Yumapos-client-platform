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

    public $userEmail;

    public $isUser;

    /*
     * render function loads content to be used in tables in dashboard,
     * first we check if the logged in user is admin/agent/user & based on result
     * we return the desired values,
     * We load service_operations table data
     * */
    public function render()
    {
        if ($this->isUser) {
            $this->usersDetails = ServiceOperation::where('user_id', auth()->id())->select(DB::raw('sum(user_amount) amount, service_operations.*'))->where(function ($query) { $query->whereNull('report_status')->orWhere('report_status','!=','refunded'); })->when($this->filterSelected, function ($query) {
                $this->filter($query);
            })->orderBy('amount', 'desc')->groupBy('user_id')->take(5)->get();
            $this->countriesList = ServiceOperation::where('user_id', auth()->id())->select(DB::raw('sum(user_amount) amount, service_operations.*'))->where(function ($query) { $query->whereNull('report_status')->orWhere('report_status','!=','refunded'); })->when($this->filterSelected, function ($query) {
                $this->filter($query);
            })->orderBy('amount', 'desc')->groupBy('request_country_iso')->take(5)->get();
            $this->operationsList = ServiceOperation::where('user_id', auth()->id())->select(DB::raw('sum(user_amount) amount, service_operations.*'))->where(function ($query) { $query->whereNull('report_status')->orWhere('report_status','!=','refunded'); })->when($this->filterSelected, function ($query) {
                $this->filter($query);
            })->orderBy('amount', 'desc')->groupBy('request_operatorId', 'request_ProviderCode')->take(5)->get();
            $services = auth()->user()->accessServices($this->filterSelected);
        } else {

            if ($this->userEmail !== '' && !is_null($this->userEmail)) {
                $user = \App\User::where('email', $this->userEmail)->first();
                if ($user) {
                    $this->usersDetails = ServiceOperation::where('user_id', $user->id)->select(DB::raw('sum(user_amount) amount, service_operations.*'))->where(function ($query) { $query->whereNull('report_status')->orWhere('report_status','!=','refunded'); })->orderBy('amount', 'desc')->groupBy('user_id')->take(5)->get();
                    $this->countriesList = ServiceOperation::where('user_id', $user->id)->select(DB::raw('sum(user_amount) amount, service_operations.*'))->where(function ($query) { $query->whereNull('report_status')->orWhere('report_status','!=','refunded'); })->orderBy('amount', 'desc')->groupBy('request_country_iso')->take(5)->get();
                    $this->operationsList = ServiceOperation::where('user_id', $user->id)->select(DB::raw('sum(user_amount) amount, service_operations.*'))->where(function ($query) { $query->whereNull('report_status')->orWhere('report_status','!=','refunded'); })->orderBy('amount', 'desc')->groupBy('request_operatorId')->take(5)->get();
                }
            } else {
                $this->usersDetails = ServiceOperation::select(DB::raw('sum(user_amount) amount, service_operations.*'))->where(function ($query) { $query->whereNull('report_status')->orWhere('report_status','!=','refunded'); })->when($this->filterSelected, function ($query) {
                    $this->filter($query);
                })->orderBy('amount', 'desc')->groupBy('user_id')->take(5)->get();
                $this->countriesList = ServiceOperation::select(DB::raw('sum(user_amount) amount, service_operations.*'))->where(function ($query) { $query->whereNull('report_status')->orWhere('report_status','!=','refunded'); })->when($this->filterSelected, function ($query) {
                    $this->filter($query);
                })->orderBy('amount', 'desc')->groupBy('request_country_iso')->take(5)->get();
                $this->operationsList = ServiceOperation::select(DB::raw('sum(user_amount) amount, service_operations.*'))->where(function ($query) { $query->whereNull('report_status')->orWhere('report_status','!=','refunded'); })->when($this->filterSelected, function ($query) {
                    $this->filter($query);
                })->orderBy('amount', 'desc')->when(true, function ($query) {
                    $query->groupBy('request_operatorId', 'request_ProviderCode');
                })->take(5)->get();
            }

            $services = auth()->user()->adminAccessServices($this->filterSelected);
        }
        return view('livewire.dashboard-operation-list', compact('services'));
    }

    /*
     * filter function is triggered when the day/yesterday/week/month buttons are clicked
     * */
    public function filter($query)
    {
        $month = Carbon::now()->month;
        $week = [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()];
        $day = Carbon::today();
        $yesterday = Carbon::yesterday();

        $q = '';
        switch ($this->filterSelected) {
            case 'day':
                $q = $query->whereDate('created_at', '=', $day);
                break;
            case 'yesterday':
                $q = $query->whereDate('created_at', '=', $yesterday);
                break;
            case 'week':
                $q = $query->whereBetween('created_at', $week);
                break;
            case 'month':
                $q = $query->whereMonth('created_at', '=', $month);
                break;
            default:
                break;
        }

        return $q;
    }


    /*
     * searchById function serves for purpose of filtering by:
     * id table, meaning it refreshes the render operation which makes available the query to filter by id
     * */
    public function searchByEmail() {}
}
