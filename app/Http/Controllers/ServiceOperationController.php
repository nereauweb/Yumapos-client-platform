<?php

namespace App\Http\Controllers;

use App\Models\ServiceOperation;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceOperationController extends Controller
{

    public function operations($type, $country = null, $operator = null, $isUser = null) : JsonResponse
    {
        if (request()->operator && request()->operator > 0) {
            $operator = true;
        } else {
            $operator = null;
        }

        if (request()->isUser == true) {
            $isUser = true;
        } else {
            $isUser = null;
        }

        if ($type == 'day') {
            $platformTotalOperations = DB::table('service_operations')
                ->select(DB::raw('count(id) as operations, sum(platform_total_gain) - sum(user_discount) as gain_data, sum(sent_amount) - sum(platform_commission) as cost, sum(user_amount) as amount_data, HOUR(created_at) as label'))
                ->whereDate('created_at', '=', '2020-09-22')
                ->when($country || request()->country, function ($query) use ($country) {
                    $query->where('request_country_iso', '=', $country ? $country : request()->country);
                })
                ->when(!is_null($isUser), function ($query) {
                    $query->where('user_id', request()->user_id);
                })
                ->when(!is_null($operator), function ($query) {
                    $query->where('request_operatorId', request()->operator);
                })
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } elseif ($type == 'yesterday') {
            $platformTotalOperations = DB::table('service_operations')
                ->select(DB::raw('count(id) as operations, sum(platform_total_gain) - sum(user_discount) as gain_data, sum(sent_amount) - sum(platform_commission) as cost, sum(user_amount) as amount_data, HOUR(created_at) as label'))
                ->whereDate('created_at', '=', '2020-09-19')
                ->when($country || request()->country, function ($query) use ($country) {
                    $query->where('request_country_iso', '=', $country ? $country : request()->country);
                })
                ->when(!is_null($operator), function ($query) {
                    $query->where('request_operatorId', request()->operator);
                })
                ->when(!is_null($isUser), function ($query) {
                    $query->where('user_id', request()->user_id);
                })
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } elseif ($type == 'week') {
            $platformTotalOperations = DB::table('service_operations')
                ->select(DB::raw('count(id) as operations, sum(platform_total_gain) - sum(user_discount) as gain_data, sum(sent_amount) - sum(platform_commission) as cost, sum(user_amount) as amount_data, DAY(created_at) as label'))
                ->when($country || request()->country, function ($query) use ($country) {
                    $query->where('request_country_iso', '=', $country ? $country : request()->country);
                })
                ->when(!is_null($operator), function ($query) {
                    $query->where('request_operatorId', request()->operator);
                })
                ->when(!is_null($isUser), function ($query) {
                    $query->where('user_id', request()->user_id);
                })
                ->whereBetween('created_at', [Carbon::createFromDate('2020', '09', '2')->startOfWeek(), Carbon::createFromDate('2020', '09', '2')->endOfWeek()])
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } else if ($type == 'month') {
            $platformMonthlyTotalOperations = DB::table('service_operations')
                ->select(DB::raw('count(id) as operations, sum(platform_total_gain) - sum(user_discount) as gain_data, sum(sent_amount) - sum(platform_commission) as cost, sum(user_amount) as amount_data, DAY(created_at) as day ,DATE_FORMAT(created_at, "%D") as label'))
                ->when($country || request()->country, function ($query) use ($country) {
                    $query->where('request_country_iso', '=', $country ? $country : request()->country);
                })
                ->when(!is_null($operator), function ($query) {
                    $query->where('request_operatorId', request()->operator);
                })
                ->when(!is_null($isUser), function ($query) {
                    $query->where('user_id', request()->user_id);
                })
                ->whereMonth('created_at', '=', Carbon::now()->startOfMonth()->subMonth(3))
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy(['label', 'day'])
                ->get();
            return response()->json($platformMonthlyTotalOperations, 200);
        }

        return response()->json("ERROR", 500);
    }

    public function totals($type) : JsonResponse
    {
        switch ($type) {
            case 'day':
                $totalsForOperations = ServiceOperation::whereDate('created_at', '=', '2020-09-22')
                ->when(request()->country, function ($query) {
                    $query->where('request_country_iso', '=', request()->country);
                })->when(request()->operator, function ($query) {
                    $query->where('request_operatorId', request()->operator);
                })->when(request()->isUser, function ($query) {
                    $query->where('user_id', request()->user_id);
                })->count();
                $totalsForGain = ServiceOperation::whereDate('created_at', '=', '2020-09-19')->select(DB::raw('sum(platform_total_gain - user_discount) as gainSumPerDay'))
                ->when(request()->country, function ($query) {
                    $query->where('request_country_iso', '=', request()->country);
                })->when(request()->operator, function ($query) {
                    $query->where('request_operatorId', request()->operator);
                })->when(request()->isUser, function ($query) {
                    $query->where('user_id', request()->user_id);
                })->first();
                $totalsForCost = ServiceOperation::whereDate('created_at', '=', '2020-09-20')->select(DB::raw('sum(sent_amount - platform_commission) as costSumPerDay'))
                ->when(request()->country, function ($query) {
                    $query->where('request_country_iso', '=', request()->country);
                })->when(request()->operator, function ($query) {
                    $query->where('request_operatorId', request()->operator);
                })->when(request()->isUser, function ($query) {
                    $query->where('user_id', request()->user_id);
                })->first();
                $totalsForAmount = ServiceOperation::whereDate('created_at', '=', '2020-09-20')->when(request()->country, function ($query) {
                    $query->where('request_country_iso', '=', request()->country);
                })->when(request()->operator, function ($query) {
                    $query->where('request_operatorId', request()->operator);
                })->when(request()->isUser, function ($query) {
                    $query->where('user_id', request()->user_id);
                })->sum('user_amount');
                break;
            case 'yesterday':
                $totalsForOperations = ServiceOperation::whereDate('created_at', '=', '2020-09-19')
                ->when(request()->country, function ($query) {
                    $query->where('request_country_iso', '=', request()->country);
                })->when(request()->operator, function ($query) {
                    $query->where('request_operatorId', request()->operator);
                })->when(request()->isUser, function ($query) {
                    $query->where('user_id', request()->user_id);
                })->count();
                $totalsForGain = ServiceOperation::whereDate('created_at', '=', '2020-09-19')
                ->when(request()->country, function ($query) {
                    $query->where('request_country_iso', '=', request()->country);
                })->when(request()->operator, function ($query) {
                    $query->where('request_operatorId', request()->operator);
                })->when(request()->isUser, function ($query) {
                    $query->where('user_id', request()->user_id);
                })->select(DB::raw('sum(platform_total_gain - user_discount) as gainSumPerDay'))->first();
                $totalsForCost = ServiceOperation::whereDate('created_at', '=', '2020-09-19')
                ->when(request()->country, function ($query) {
                    $query->where('request_country_iso', '=', request()->country);
                })->when(request()->operator, function ($query) {
                    $query->where('request_operatorId', request()->operator);
                })->when(request()->isUser, function ($query) {
                    $query->where('user_id', request()->user_id);
                })->select(DB::raw('sum(sent_amount - platform_commission) as costSumPerDay'))->first();
                $totalsForAmount = ServiceOperation::whereDate('created_at', '=', '2020-09-19')
                ->when(request()->country, function ($query) {
                    $query->where('request_country_iso', '=', request()->country);
                })->when(request()->operator, function ($query) {
                    $query->where('request_operatorId', request()->operator);
                })->when(request()->isUser, function ($query) {
                    $query->where('user_id', request()->user_id);
                })->sum('user_amount');
                break;
            case 'week':
                $totalsForOperations = ServiceOperation::whereBetween('created_at', [Carbon::createFromDate('2020', '09', '2')->startOfWeek(), Carbon::createFromDate('2020', '09', '2')->endOfWeek()])
                ->when(request()->country, function ($query) {
                    $query->where('request_country_iso', '=', request()->country);
                })->when(request()->operator, function ($query) {
                    $query->where('request_operatorId', request()->operator);
                })->when(request()->isUser, function ($query) {
                    $query->where('user_id', request()->user_id);
                })->count();
                $totalsForGain = ServiceOperation::whereBetween('created_at', [Carbon::createFromDate('2020', '09', '2')->startOfWeek(), Carbon::createFromDate('2020', '09', '2')->endOfWeek()])
                ->when(request()->country, function ($query) {
                    $query->where('request_country_iso', '=', request()->country);
                })->when(request()->operator, function ($query) {
                    $query->where('request_operatorId', request()->operator);
                })->when(request()->isUser, function ($query) {
                    $query->where('user_id', request()->user_id);
                })->select(DB::raw('sum(platform_total_gain - user_discount) as gainSumPerDay'))->first();
                $totalsForCost = ServiceOperation::whereBetween('created_at', [Carbon::createFromDate('2020', '09', '2')->startOfWeek(), Carbon::createFromDate('2020', '09', '2')->endOfWeek()])
                ->when(request()->country, function ($query) {
                    $query->where('request_country_iso', '=', request()->country);
                })->when(request()->operator, function ($query) {
                    $query->where('request_operatorId', request()->operator);
                })->when(request()->isUser, function ($query) {
                    $query->where('user_id', request()->user_id);
                })->select(DB::raw('sum(sent_amount - platform_commission) as costSumPerDay'))->first();
                $totalsForAmount = ServiceOperation::whereBetween('created_at', [Carbon::createFromDate('2020', '09', '2')->startOfWeek(), Carbon::createFromDate('2020', '09', '2')->endOfWeek()])
                ->when(request()->country, function ($query) {
                    $query->where('request_country_iso', '=', request()->country);
                })->when(request()->operator, function ($query) {
                    $query->where('request_operatorId', request()->operator);
                })->when(request()->isUser, function ($query) {
                    $query->where('user_id', request()->user_id);
                })->sum('user_amount');
                break;
            case 'month':
                $totalsForOperations = ServiceOperation::whereMonth('created_at', '=', Carbon::now()->startOfMonth()->subMonth(3))->when(request()->country, function ($query) {
                    $query->where('request_country_iso', '=', request()->country);
                })->when(request()->operator, function ($query) {
                    $query->where('request_operatorId', request()->operator);
                })->when(request()->isUser, function ($query) {
                    $query->where('user_id', request()->user_id);
                })->count();
                $totalsForGain = ServiceOperation::whereMonth('created_at', '=', Carbon::now()->startOfMonth()->subMonth(3))->when(request()->country, function ($query) {
                    $query->where('request_country_iso', '=', request()->country);
                })->when(request()->operator, function ($query) {
                    $query->where('request_operatorId', request()->operator);
                })->when(request()->isUser, function ($query) {
                    $query->where('user_id', request()->user_id);
                })->select(DB::raw('sum(platform_total_gain - user_discount) as gainSumPerDay'))->first();
                $totalsForCost = ServiceOperation::whereMonth('created_at', '=', Carbon::now()->startOfMonth()->subMonth(3))->when(request()->country, function ($query) {
                    $query->where('request_country_iso', '=', request()->country);
                })->when(request()->operator, function ($query) {
                    $query->where('request_operatorId', request()->operator);
                })->when(request()->isUser, function ($query) {
                    $query->where('user_id', request()->user_id);
                })->select(DB::raw('sum(sent_amount - platform_commission) as costSumPerDay'))->first();
                $totalsForAmount = ServiceOperation::whereMonth('created_at', '=', Carbon::now()->startOfMonth()->subMonth(3))->when(request()->country, function ($query) {
                    $query->where('request_country_iso', '=', request()->country);
                })->when(request()->operator, function ($query) {
                    $query->where('request_operatorId', request()->operator);
                })->when(request()->isUser, function ($query) {
                    $query->where('user_id', request()->user_id);
                })->sum('user_amount');
                break;
            default:
                $totalsForOperations = 'NOT SET!';
                $totalsForGain = 'NOT SET!';
                $totalsForCost = 'NOT SET!';
                $totalsForAmount = 'NOT SET!';
        }


        return response()->json([
            'totalsForOperations' => $totalsForOperations,
            'totalsForGain' => $totalsForGain,
            'totalsForCost' => $totalsForCost,
            'totalsForAmount' => $totalsForAmount
        ], 200);
    }

    public function countries($countryIso)
    {
        $response = $this->operations(request()->filter, $countryIso);
        return response()->json($response, 200);
    }
}
