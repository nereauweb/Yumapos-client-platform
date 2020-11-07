<?php

namespace App\Http\Controllers;

use App\Models\ServiceOperation;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceOperationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() : JsonResponse
    {
        $operations = $this->operationStats('day');
        $amounts = $this->amountStats('day');
        $gains = $this->gainStats('day');
        $costs = $this->costStats('day');

        return response()->json([
            'operations' => $operations,
            'amounts' => $amounts,
            'gains' => $gains,
            'costs' => $costs
        ], 200);
    }

    public function operations($type)
    {
        if ($type == 'day') {
            $platformTotalOperations = DB::table('service_operations')
                ->select(DB::raw('count(id) as operations, sum(platform_total_gain) - sum(user_discount) as gain_data, sum(sent_amount) - sum(platform_commission) as cost, sum(user_amount) as amount_data, HOUR(created_at) as label'))
                ->whereDate('created_at', '=', '2020-09-20')
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } elseif ($type == 'yesterday') {
            $platformTotalOperations = DB::table('service_operations')
                ->select(DB::raw('count(id) as operations, sum(platform_total_gain) - sum(user_discount) as gain_data, sum(sent_amount) - sum(platform_commission) as cost, sum(user_amount) as amount_data, HOUR(created_at) as label'))
                ->whereDate('created_at', '=', '2020-09-19')
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } elseif ($type == 'week') {
            $platformTotalOperations = DB::table('service_operations')
                ->select(DB::raw('count(id) as operations, sum(platform_total_gain) - sum(user_discount) as gain_data, sum(sent_amount) - sum(platform_commission) as cost, sum(user_amount) as amount_data, DAY(created_at) as label'))
                ->whereBetween('created_at', [Carbon::createFromDate('2020', '09', '2')->startOfWeek(), Carbon::createFromDate('2020', '09', '2')->endOfWeek()])
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } else if ($type == 'month') {
            $platformMonthlyTotalOperations = DB::table('service_operations')
                ->select(DB::raw('count(id) as operations, sum(platform_total_gain) - sum(user_discount) as gain_data, sum(sent_amount) - sum(platform_commission) as cost, sum(user_amount) as amount_data, DAY(created_at) as day ,DATE_FORMAT(created_at, "%D") as label'))
                ->whereMonth('created_at', '=', Carbon::now()->startOfMonth()->subMonth(3))
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy(['label', 'day'])
                ->get();
            return response()->json($platformMonthlyTotalOperations, 200);
        }

        return response()->json("ERROR", 500);
    }

//    public function gainStats($type)
//    {
//        if ($type == 'day') {
//            $platformTotalOperations = DB::table('service_operations')
//                ->select(DB::raw('sum(platform_total_gain) - sum(user_discount) as gain_data, HOUR(created_at) as label'))
//                ->whereDate('created_at', '=', '2020-09-20')
////            ->whereDate('created_at', '=', Carbon::now()->toDateString())
//                ->groupBy('label')
//                ->get();
//            return response()->json($platformTotalOperations, 200);
//        } elseif ($type == 'yesterday') {
//            $platformTotalOperations = DB::table('service_operations')
//                ->select(DB::raw('sum(platform_total_gain) - sum(user_discount) as gain_data, HOUR(created_at) as label'))
//                ->whereDate('created_at', '=', '2020-09-19')
////            ->whereDate('created_at', '=', Carbon::now()->toDateString())
//                ->groupBy('label')
//                ->get();
//            return response()->json($platformTotalOperations, 200);
//        } elseif($type == 'week') {
//            $platformTotalOperations = DB::table('service_operations')
//                ->select(DB::raw('sum(platform_total_gain) - sum(user_discount) as gain_data, DAY(created_at) as label'))
//                ->whereBetween('created_at', [Carbon::createFromDate('2020', '09', '2')->startOfWeek(), Carbon::createFromDate('2020', '09', '2')->endOfWeek()])
////            ->whereDate('created_at', '=', Carbon::now()->toDateString())
//                ->groupBy('label')
//                ->get();
//            return response()->json($platformTotalOperations, 200);
//        } elseif ($type == 'month') {
//            $platformMonthlyTotalOperations = DB::table('service_operations')
//                ->select(DB::raw('sum(platform_total_gain) - sum(user_discount) as gain_data, DAY(created_at) as day ,DATE_FORMAT(created_at, "%D") as label'))
//                ->whereMonth('created_at', '=', Carbon::now()->startOfMonth()->subMonth(3))
////            ->whereDate('created_at', '=', Carbon::now()->toDateString())
//                ->groupBy(['label', 'day'])
//                ->get();
//            return response()->json($platformMonthlyTotalOperations, 200);
//        }
//
//        return response()->json("ERROR", 500);
//    }
//
//    public function costStats($type)
//    {
//        if ($type == 'day') {
//            $platformTotalOperations = DB::table('service_operations')
//                ->select(DB::raw('sum(sent_amount) - sum(platform_commission)  as cost, HOUR(created_at) as hour'))
//                ->whereDate('created_at', '=', '2020-09-20')
////            ->whereDate('created_at', '=', Carbon::now()->toDateString())
//                ->groupBy('hour')
//                ->get();
//            return response()->json($platformTotalOperations, 200);
//        } elseif ($type == 'yesterday') {
//            $platformTotalOperations = DB::table('service_operations')
//                ->select(DB::raw('sum(sent_amount) - sum(platform_commission) as cost, HOUR(created_at) as label'))
//                ->whereDate('created_at', '=', '2020-09-19')
////            ->whereDate('created_at', '=', Carbon::now()->toDateString())
//                ->groupBy('label')
//                ->get();
//            return response()->json($platformTotalOperations, 200);
//        } elseif($type == 'week') {
//            $platformTotalOperations = DB::table('service_operations')
//                ->select(DB::raw('sum(sent_amount) - sum(platform_commission) as cost, DAY(created_at) as label'))
//                ->whereBetween('created_at', [Carbon::createFromDate('2020', '09', '2')->startOfWeek(), Carbon::createFromDate('2020', '09', '2')->endOfWeek()])
////            ->whereDate('created_at', '=', Carbon::now()->toDateString())
//                ->groupBy('label')
//                ->get();
//            return response()->json($platformTotalOperations, 200);
//        } elseif ($type == 'month') {
//            $platformMonthlyTotalOperations = DB::table('service_operations')
//                ->select(DB::raw('sum(sent_amount) - sum(platform_commission) as cost, DAY(created_at) as day ,DATE_FORMAT(created_at, "%D") as label'))
//                ->whereMonth('created_at', '=', Carbon::now()->startOfMonth()->subMonth(3))
////            ->whereDate('created_at', '=', Carbon::now()->toDateString())
//                ->groupBy(['label', 'day'])
//                ->get();
//            return response()->json($platformMonthlyTotalOperations, 200);
//        }
//
//        return response()->json("ERROR", 500);
//    }
//
//    public function amountStats($type)
//    {
//        if ($type == 'day') {
//            $platformTotalOperations = DB::table('service_operations')
//                ->select(DB::raw('sum(user_amount) as amount_data, HOUR(created_at) as label'))
//                ->whereDate('created_at', '=', '2020-09-20')
////            ->whereDate('created_at', '=', Carbon::now()->toDateString())
//                ->groupBy('label')
//                ->get();
//            return response()->json($platformTotalOperations, 200);
//        } elseif ($type == 'yesterday') {
//            $platformTotalOperations = DB::table('service_operations')
//                ->select(DB::raw('sum(sent_amount) - sum(platform_commission) as amount_data, HOUR(created_at) as label'))
//                ->whereDate('created_at', '=', '2020-09-19')
////            ->whereDate('created_at', '=', Carbon::now()->toDateString())
//                ->groupBy('label')
//                ->get();
//            return response()->json($platformTotalOperations, 200);
//        } elseif($type == 'week') {
//            $platformTotalOperations = DB::table('service_operations')
//                ->select(DB::raw('sum(user_amount) as amount_data, DAY(created_at) as label'))
//                ->whereBetween('created_at', [Carbon::createFromDate('2020', '09', '2')->startOfWeek(), Carbon::createFromDate('2020', '09', '2')->endOfWeek()])
////            ->whereDate('created_at', '=', Carbon::now()->toDateString())
//                ->groupBy('label')
//                ->get();
//            return response()->json($platformTotalOperations, 200);
//        } else if ($type == 'month') {
//            $platformMonthlyTotalOperations = DB::table('service_operations')
//                ->select(DB::raw('sum(user_amount) as amount_data, DAY(created_at) as day ,DATE_FORMAT(created_at, "%D") as label'))
//                ->whereMonth('created_at', '=', Carbon::now()->startOfMonth()->subMonth(3))
////            ->whereDate('created_at', '=', Carbon::now()->toDateString())
//                ->groupBy(['label', 'day'])
//                ->get();
//            return response()->json($platformMonthlyTotalOperations, 200);
//        }
//
//        return response()->json("ERROR", 500);
//    }
//
    public function totals($type)
    {

        switch ($type) {
            case 'day':
                $totalsForOperations = ServiceOperation::whereDate('created_at', '=', '2020-09-20')->count();
                $totalsForGain = ServiceOperation::whereDate('created_at', '=', '2020-09-20')->select(DB::raw('sum(platform_total_gain - user_discount) as gainSumPerDay'))->first();
                $totalsForCost = ServiceOperation::whereDate('created_at', '=', '2020-09-20')->select(DB::raw('sum(sent_amount - platform_commission) as costSumPerDay'))->first();
                $totalsForAmount = ServiceOperation::whereDate('created_at', '=', '2020-09-20')->sum('user_amount');
                break;
            case 'yesterday':
                $totalsForOperations = ServiceOperation::whereDate('created_at', '=', '2020-09-19')->count();
                $totalsForGain = ServiceOperation::whereDate('created_at', '=', '2020-09-19')->select(DB::raw('sum(platform_total_gain - user_discount) as gainSumPerDay'))->first();
                $totalsForCost = ServiceOperation::whereDate('created_at', '=', '2020-09-19')->select(DB::raw('sum(sent_amount - platform_commission) as costSumPerDay'))->first();
                $totalsForAmount = ServiceOperation::whereDate('created_at', '=', '2020-09-19')->sum('user_amount');
                break;
            case 'week':
                $totalsForOperations = ServiceOperation::whereBetween('created_at', [Carbon::createFromDate('2020', '09', '2')->startOfWeek(), Carbon::createFromDate('2020', '09', '2')->endOfWeek()])->count();
                $totalsForGain = ServiceOperation::whereBetween('created_at', [Carbon::createFromDate('2020', '09', '2')->startOfWeek(), Carbon::createFromDate('2020', '09', '2')->endOfWeek()])->select(DB::raw('sum(platform_total_gain - user_discount) as gainSumPerDay'))->first();
                $totalsForCost = ServiceOperation::whereBetween('created_at', [Carbon::createFromDate('2020', '09', '2')->startOfWeek(), Carbon::createFromDate('2020', '09', '2')->endOfWeek()])->select(DB::raw('sum(sent_amount - platform_commission) as costSumPerDay'))->first();
                $totalsForAmount = ServiceOperation::whereBetween('created_at', [Carbon::createFromDate('2020', '09', '2')->startOfWeek(), Carbon::createFromDate('2020', '09', '2')->endOfWeek()])->sum('user_amount');
                break;
            case 'month':
                $totalsForOperations = ServiceOperation::whereMonth('created_at', '=', Carbon::now()->startOfMonth()->subMonth(3))->count();
                $totalsForGain = ServiceOperation::whereMonth('created_at', '=', Carbon::now()->startOfMonth()->subMonth(3))->select(DB::raw('sum(platform_total_gain - user_discount) as gainSumPerDay'))->first();
                $totalsForCost = ServiceOperation::whereMonth('created_at', '=', Carbon::now()->startOfMonth()->subMonth(3))->select(DB::raw('sum(sent_amount - platform_commission) as costSumPerDay'))->first();
                $totalsForAmount = ServiceOperation::whereMonth('created_at', '=', Carbon::now()->startOfMonth()->subMonth(3))->sum('user_amount');
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
}
