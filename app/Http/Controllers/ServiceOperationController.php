<?php

namespace App\Http\Controllers;

use App\Models\ServiceOperation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceOperationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function operationStats($type)
    {
        if ($type == 'day') {
            $platformTotalOperations = DB::table('service_operations')
                ->select(DB::raw('count(id) as operations, HOUR(created_at) as label'))
                ->whereDate('created_at', '=', '2020-09-20')
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } elseif ($type == 'yesterday') {
            $platformTotalOperations = DB::table('service_operations')
                ->select(DB::raw('count(id) as operations, HOUR(created_at) as label'))
                ->whereDate('created_at', '=', '2020-09-19')
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } elseif ($type == 'week') {
            $platformTotalOperations = DB::table('service_operations')
                ->select(DB::raw('count(id) as operations, DAY(created_at) as label'))
                ->whereBetween('created_at', [Carbon::createFromDate('2020', '09', '2')->startOfWeek(), Carbon::createFromDate('2020', '09', '2')->endOfWeek()])
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } else if ($type == 'month') {
            $platformMonthlyTotalOperations = DB::table('service_operations')
                ->select(DB::raw('count(id) as operations, DAY(created_at) as day ,DATE_FORMAT(created_at, "%D") as label'))
                ->whereMonth('created_at', '=', Carbon::now()->startOfMonth()->subMonth(3))
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy(['label', 'day'])
                ->get();
            return response()->json($platformMonthlyTotalOperations, 200);
        }

        return response()->json("ERROR", 500);
    }

    public function gainStats($type)
    {
        if ($type == 'day') {
            $platformTotalOperations = DB::table('service_operations')
                ->select(DB::raw('sum(platform_total_gain) - sum(user_discount) as gain_data, HOUR(created_at) as label'))
                ->whereDate('created_at', '=', '2020-09-20')
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } elseif ($type == 'yesterday') {
            $platformTotalOperations = DB::table('service_operations')
                ->select(DB::raw('sum(platform_total_gain) - sum(user_discount) as gain_data, HOUR(created_at) as label'))
                ->whereDate('created_at', '=', '2020-09-19')
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } elseif($type == 'week') {
            $platformTotalOperations = DB::table('service_operations')
                ->select(DB::raw('sum(platform_total_gain) - sum(user_discount) as gain_data, DAY(created_at) as label'))
                ->whereBetween('created_at', [Carbon::createFromDate('2020', '09', '2')->startOfWeek(), Carbon::createFromDate('2020', '09', '2')->endOfWeek()])
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } elseif ($type == 'month') {
            $platformMonthlyTotalOperations = DB::table('service_operations')
                ->select(DB::raw('sum(platform_total_gain) - sum(user_discount) as gain_data, DAY(created_at) as day ,DATE_FORMAT(created_at, "%D") as label'))
                ->whereMonth('created_at', '=', Carbon::now()->startOfMonth()->subMonth(3))
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy(['label', 'day'])
                ->get();
            return response()->json($platformMonthlyTotalOperations, 200);
        }

        return response()->json("ERROR", 500);
    }

    public function costStats($type)
    {
        if ($type == 'day') {
            $platformTotalOperations = DB::table('service_operations')
                ->select(DB::raw('sum(sent_amount) - sum(platform_commission)  as cost, HOUR(created_at) as hour'))
                ->whereDate('created_at', '=', '2020-09-20')
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy('hour')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } elseif ($type == 'yesterday') {
            $platformTotalOperations = DB::table('service_operations')
                ->select(DB::raw('sum(sent_amount) - sum(platform_commission) as cost, HOUR(created_at) as label'))
                ->whereDate('created_at', '=', '2020-09-19')
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } elseif($type == 'week') {
            $platformTotalOperations = DB::table('service_operations')
                ->select(DB::raw('sum(sent_amount) - sum(platform_commission) as cost, DAY(created_at) as label'))
                ->whereBetween('created_at', [Carbon::createFromDate('2020', '09', '2')->startOfWeek(), Carbon::createFromDate('2020', '09', '2')->endOfWeek()])
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } elseif ($type == 'month') {
            $platformMonthlyTotalOperations = DB::table('service_operations')
                ->select(DB::raw('sum(sent_amount) - sum(platform_commission) as cost, DAY(created_at) as day ,DATE_FORMAT(created_at, "%D") as label'))
                ->whereMonth('created_at', '=', Carbon::now()->startOfMonth()->subMonth(3))
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy(['label', 'day'])
                ->get();
            return response()->json($platformMonthlyTotalOperations, 200);
        }

        return response()->json("ERROR", 500);
    }

    public function amountStats($type)
    {
        if ($type == 'day') {
            $platformTotalOperations = DB::table('service_operations')
                ->select(DB::raw('sum(user_amount) as amount_data, HOUR(created_at) as label'))
                ->whereDate('created_at', '=', '2020-09-20')
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } elseif ($type == 'yesterday') {
            $platformTotalOperations = DB::table('service_operations')
                ->select(DB::raw('sum(sent_amount) - sum(platform_commission) as amount_data, HOUR(created_at) as label'))
                ->whereDate('created_at', '=', '2020-09-19')
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } elseif($type == 'week') {
            $platformTotalOperations = DB::table('service_operations')
                ->select(DB::raw('sum(user_amount) as amount_data, DAY(created_at) as label'))
                ->whereBetween('created_at', [Carbon::createFromDate('2020', '09', '2')->startOfWeek(), Carbon::createFromDate('2020', '09', '2')->endOfWeek()])
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } else if ($type == 'month') {
            $platformMonthlyTotalOperations = DB::table('service_operations')
                ->select(DB::raw('sum(user_amount) as amount_data, DAY(created_at) as day ,DATE_FORMAT(created_at, "%D") as label'))
                ->whereMonth('created_at', '=', Carbon::now()->startOfMonth()->subMonth(3))
//            ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->groupBy(['label', 'day'])
                ->get();
            return response()->json($platformMonthlyTotalOperations, 200);
        }

        return response()->json("ERROR", 500);
    }
}
