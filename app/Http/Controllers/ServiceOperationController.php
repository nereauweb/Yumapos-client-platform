<?php

namespace App\Http\Controllers;

use App\Models\ServiceOperation;
use App\Models\ServiceOperator;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceOperationController extends Controller
{
    protected $month;
    protected $week;
    protected $day;
    protected $yesterday;

    public function __construct()
    {
        $this->month = Carbon::now()->month;
        $this->week = [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()];
        $this->day = Carbon::today();
        $this->yesterday = Carbon::yesterday();
    }
    public function operations($type, $country = null, $operator = null, $isUser = null) : JsonResponse
    {
        if ($type == 'day') {
            $platformTotalOperations = DB::table('service_operations')
                ->whereDate('service_operations.created_at', '=', $this->day)
                ->when(request()->all(), function ($query) {
                    $this->appendDefaultFilters($query, request()->all(), 'service_operations.');
                })
                ->select(DB::raw('count(id) as operations, sum(platform_total_gain) - sum(user_discount) as gain_data, sum(sent_amount) - sum(platform_commission) as cost, sum(user_amount) as amount_data, HOUR(created_at) as label'))
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } elseif ($type == 'yesterday') {
            $platformTotalOperations = DB::table('service_operations')
                ->select(DB::raw('count(id) as operations, sum(platform_total_gain) - sum(user_discount) as gain_data, sum(sent_amount) - sum(platform_commission) as cost, sum(user_amount) as amount_data, HOUR(created_at) as label'))
                ->whereDate('created_at', '=', $this->yesterday)
                ->when(request()->all(), function ($query) {
                    $this->appendDefaultFilters($query, request()->all());
                })
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } elseif ($type == 'week') {
            $platformTotalOperations = DB::table('service_operations')
                ->select(DB::raw('count(id) as operations, sum(platform_total_gain) - sum(user_discount) as gain_data, sum(sent_amount) - sum(platform_commission) as cost, sum(user_amount) as amount_data, DAY(created_at) as label'))
                ->whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-7 days')))
                ->when(request()->all(), function ($query) {
                    $this->appendDefaultFilters($query, request()->all());
                })
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } else if ($type == 'month') {
            $platformMonthlyTotalOperations = DB::table('service_operations')
                ->select(DB::raw('count(id) as operations, sum(platform_total_gain) - sum(user_discount) as gain_data, sum(sent_amount) - sum(platform_commission) as cost, sum(user_amount) as amount_data, DAY(created_at) as day ,DATE_FORMAT(created_at, "%D") as label'))
                ->whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-30 days')))
                ->when(request()->all(), function ($query) {
                    $this->appendDefaultFilters($query, request()->all());
                })
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
                $totalsForOperations = ServiceOperation::whereDate('created_at', '=', $this->day)
                ->when(request()->all(), function ($query) {
                    $this->appendDefaultFilters($query, request()->all());
                })->count();
                $totalsForGain = ServiceOperation::select(DB::raw('sum(platform_total_gain - user_discount) as gainSumPerDay'))
                ->whereDate('created_at', '=', $this->day)
                ->when(request()->all(), function ($query) {
                    $this->appendDefaultFilters($query, request()->all());
                })->first();
                $totalsForCost = ServiceOperation::select(DB::raw('sum(sent_amount - platform_commission) as costSumPerDay'))
                ->whereDate('created_at', '=', $this->day)
                ->when(request()->all(), function ($query) {
                    $this->appendDefaultFilters($query, request()->all());
                })->first();
                $totalsForAmount = ServiceOperation::whereDate('created_at', '=', $this->day)->when(request()->all(), function ($query) {
                    $this->appendDefaultFilters($query, request()->all());
                })->sum('user_amount');
                break;
            case 'yesterday':
                $totalsForOperations = ServiceOperation::whereDate('created_at', '=', $this->yesterday)
                ->when(request()->all(), function ($query) {
                    $this->appendDefaultFilters($query, request()->all());
                })
                ->count();
                $totalsForGain = ServiceOperation::select(DB::raw('sum(platform_total_gain - user_discount) as gainSumPerDay'))
                ->whereDate('created_at', '=', $this->yesterday)
                ->when(request()->all(), function ($query) {
                    $this->appendDefaultFilters($query, request()->all());
                })
                ->first();
                $totalsForCost = ServiceOperation::select(DB::raw('sum(sent_amount - platform_commission) as costSumPerDay'))
                ->whereDate('created_at', '=', $this->yesterday)
                ->when(request()->all(), function ($query) {
                    $this->appendDefaultFilters($query, request()->all());
                })
                ->first();
                $totalsForAmount = ServiceOperation::whereDate('created_at', '=', $this->yesterday)
                ->when(request()->all(), function ($query) {
                    $this->appendDefaultFilters($query, request()->all());
                })
                ->sum('user_amount');
                break;
            case 'week':
                $totalsForOperations = ServiceOperation::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-7 days')))
                ->when(request()->all(), function ($query) {
                    $this->appendDefaultFilters($query, request()->all());
                })->count();
                $totalsForGain = ServiceOperation::select(DB::raw('sum(platform_total_gain - user_discount) as gainSumPerDay'))
                ->whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-7 days')))
                ->when(request()->all(), function ($query) {
                    $this->appendDefaultFilters($query, request()->all());
                })
                ->first();
                $totalsForCost = ServiceOperation::select(DB::raw('sum(sent_amount - platform_commission) as costSumPerDay'))
                ->whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-7 days')))
                ->when(request()->all(), function ($query) {
                    $this->appendDefaultFilters($query, request()->all());
                })
                ->first();
                $totalsForAmount = ServiceOperation::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-7 days')))->when(request()->all(), function ($query) {
                    $this->appendDefaultFilters($query, request()->all());
                })->sum('user_amount');
                break;
            case 'month':
                $totalsForOperations = ServiceOperation::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-30 days')))
                ->when(request()->all(), function ($query) {
                    $this->appendDefaultFilters($query, request()->all());
                })->count();
                $totalsForGain = ServiceOperation::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-30 days')))->select(DB::raw('sum(platform_total_gain - user_discount) as gainSumPerDay'))
                ->when(request()->all(), function ($query) {
                    $this->appendDefaultFilters($query, request()->all());
                })
                ->first();
                $totalsForCost = ServiceOperation::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-30 days')))
                ->select(DB::raw('sum(sent_amount - platform_commission) as costSumPerDay'))
                ->when(request()->all(), function ($query) {
                    $this->appendDefaultFilters($query, request()->all());
                })->first();
                $totalsForAmount = ServiceOperation::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-30 days')))->when(request()->all(), function ($query) {
                    $this->appendDefaultFilters($query, request()->all());
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

    private function appendDefaultFilters($query, $request, $concatstr = null, $type = null)
    {
        $query->when($request['country'], function ($q) use ($concatstr, $request) {
            $q->where($concatstr.'request_country_iso', '=', $request['country']);
        })->when($request['operator'], function ($q) use ($concatstr, $request, $type) {
            $operatorToCheck = ServiceOperator::findOrFail($request['operator']);
            if (is_null($operatorToCheck->reloadly_operatorId) && !is_null($operatorToCheck->ding_ProviderCode)) {
                $q->where($concatstr.'request_ProviderCode', '=', $operatorToCheck->ding_ProviderCode);
            } else if (!is_null($operatorToCheck->reloadly_operatorId) && is_null($operatorToCheck->ding_ProviderCode))  {
                $q->where($concatstr.'request_operatorId', '=', $operatorToCheck->reloadly_operatorId);
            } else {
                $q->where($concatstr.'request_operatorId', '=', $operatorToCheck->reloadly_operatorId)->orWhere($concatstr.'request_ProviderCode', '=', $operatorToCheck->ding_ProviderCode);
            }
        })->when($request['isUser'], function ($q) use ($concatstr, $request) {
            $q->where($concatstr.'user_id', $request['user_id']);
        });
    }

    private function appendAgentFilter($query, $request, $concatstr = null)
    {
        return $query->when($request['country'], function ($q) use ($concatstr, $request) {
            $q->where($concatstr.'request_country_iso', '=', $request['country']);
        })->when($request['operator'], function ($q) use ($concatstr, $request) {
            $operatorToCheck = ServiceOperator::findOrFail($request['operator']);
            if (is_null($operatorToCheck->reloadly_operatorId) && !is_null($operatorToCheck->ding_ProviderCode)) {
                $q->where($concatstr.'request_ProviderCode', $operatorToCheck->ding_ProviderCode);
            } else if (!is_null($operatorToCheck->reloadly_operatorId) && is_null($operatorToCheck->ding_ProviderCode))  {
                $q->where($concatstr.'request_operatorId', $operatorToCheck->reloadly_operatorId);
            } else {
                $q->where($concatstr.'request_operatorId', $operatorToCheck->reloadly_operatorId)->orWhere($concatstr.'request_ProviderCode', $operatorToCheck->ding_ProviderCode);
            }
        });
    }

    public function agentOperations($type)
    {
        if ($type == 'day') {
            $platformTotalOperations = DB::table('service_operations')
                ->join('agent_operations', 'service_operations.id', '=', 'agent_operations.service_operation_id')
                ->select(DB::raw('count(service_operations.id) as operations, sum(service_operations.platform_total_gain) - sum(service_operations.user_discount) as gain_data, sum(service_operations.sent_amount) - sum(service_operations.platform_commission) as cost, sum(service_operations.user_amount) as amount_data, HOUR(service_operations.created_at) as label'))
                ->whereDate('service_operations.created_at', '=', $this->day)
                ->where('agent_operations.user_id', auth()->id())
                ->when(request()->all(), function ($query) {
                    $this->appendAgentFilter($query, request()->all(), 'service_operations.');
                })
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } elseif ($type == 'yesterday') {
            $platformTotalOperations = DB::table('service_operations')
                ->join('agent_operations', 'service_operations.id', '=', 'agent_operations.service_operation_id')
                ->select(DB::raw('count(service_operations.id) as operations, sum(service_operations.platform_total_gain) - sum(service_operations.user_discount) as gain_data, sum(service_operations.sent_amount) - sum(service_operations.platform_commission) as cost, sum(service_operations.user_amount) as amount_data, HOUR(service_operations.created_at) as label'))
                ->whereDate('service_operations.created_at', '=', $this->yesterday)
                ->where('agent_operations.user_id', auth()->id())
                ->when(request()->all(), function ($query) {
                    $this->appendAgentFilter($query, request()->all(), 'service_operations.');
                })
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } elseif ($type == 'week') {
            $platformTotalOperations = DB::table('service_operations')
                ->join('agent_operations', 'service_operations.id', '=', 'agent_operations.service_operation_id')
                ->select(DB::raw('count(service_operations.id) as operations, sum(service_operations.platform_total_gain) - sum(service_operations.user_discount) as gain_data, sum(service_operations.sent_amount) - sum(service_operations.platform_commission) as cost, sum(service_operations.user_amount) as amount_data, DAY(service_operations.created_at) as label'))
                ->whereBetween('service_operations.created_at', $this->week)
                ->where('agent_operations.user_id', auth()->id())
                ->when(request()->all(), function ($query) {
                    $this->appendAgentFilter($query, request()->all(), 'service_operations.');
                })
                ->groupBy('label')
                ->get();
            return response()->json($platformTotalOperations, 200);
        } else if ($type == 'month') {
            $platformMonthlyTotalOperations = DB::table('service_operations')
                ->join('agent_operations', 'service_operations.id', '=', 'agent_operations.service_operation_id')
                ->select(DB::raw('count(service_operations.id) as operations, sum(service_operations.platform_total_gain) - sum(service_operations.user_discount) as gain_data, sum(service_operations.sent_amount) - sum(service_operations.platform_commission) as cost, sum(service_operations.user_amount) as amount_data, DAY(service_operations.created_at) as day ,DATE_FORMAT(service_operations.created_at, "%D") as label'))
                ->whereDate('service_operations.created_at', '>=', $this->month)
                ->where('agent_operations.user_id', auth()->id())
                ->when(request()->all(), function ($query) {
                    $this->appendAgentFilter($query, request()->all(), 'service_operations.');
                })
                ->groupBy(['label', 'day'])
                ->get();
            return response()->json($platformMonthlyTotalOperations, 200);
        }
    }

    public function agentTotals($type) : JsonResponse
    {
        switch ($type) {
            case 'day':
                $totalsForOperations = DB::table('service_operations')
                    ->join('agent_operations', 'service_operations.id', '=', 'agent_operations.service_operation_id')
                    ->whereDate('service_operations.created_at', '=', $this->day)
                    ->where('agent_operations.user_id', auth()->id())
                    ->when(request()->all(), function ($query) {
                        $this->appendAgentFilter($query, request()->all(), 'service_operations.');
                    })
                    ->count();
                $totalsForGain = DB::table('service_operations')
                    ->join('agent_operations', 'service_operations.id', '=', 'agent_operations.service_operation_id')
                    ->select(DB::raw('sum(service_operations.platform_total_gain - service_operations.user_discount) as gainSumPerDay'))
                    ->whereDate('service_operations.created_at', '=', $this->day)
                    ->where('agent_operations.user_id', auth()->id())
                    ->when(request()->all(), function ($query) {
                        $this->appendAgentFilter($query, request()->all(), 'service_operations.');
                    })
                    ->first();
                $totalsForCost = DB::table('service_operations')
                    ->join('agent_operations', 'service_operations.id', '=', 'agent_operations.service_operation_id')
                    ->whereDate('service_operations.created_at', '=', $this->day)
                    ->select(DB::raw('sum(service_operations.sent_amount - service_operations.platform_commission) as costSumPerDay'))
                    ->where('agent_operations.user_id', auth()->id())
                    ->when(request()->all(), function ($query) {
                        $this->appendAgentFilter($query, request()->all(), 'service_operations.');
                    })
                    ->first();
                $totalsForAmount = DB::table('service_operations')
                    ->join('agent_operations', 'service_operations.id', '=', 'agent_operations.service_operation_id')
                    ->where('agent_operations.user_id', auth()->id())
                    ->whereDate('service_operations.created_at', '=', $this->day)
                    ->when(request()->all(), function ($query) {
                        $this->appendAgentFilter($query, request()->all(), 'service_operations.');
                    })
                    ->sum('service_operations.user_amount');
                break;
            case 'yesterday':
                $totalsForOperations = DB::table('service_operations')
                    ->join('agent_operations', 'service_operations.id', '=', 'agent_operations.service_operation_id')
                    ->whereDate('service_operations.created_at', '=', $this->yesterday)
                    ->where('agent_operations.user_id', auth()->id())
                    ->when(request()->all(), function ($query) {
                        $this->appendAgentFilter($query, request()->all(), 'service_operations.');
                    })
                    ->count();
                $totalsForGain = DB::table('service_operations')
                    ->join('agent_operations', 'service_operations.id', '=', 'agent_operations.service_operation_id')
                    ->whereDate('service_operations.created_at', '=', $this->yesterday)
                    ->where('agent_operations.user_id', auth()->id())
                    ->select(DB::raw('sum(service_operations.platform_total_gain - service_operations.user_discount) as gainSumPerDay'))
                    ->when(request()->all(), function ($query) {
                        $this->appendAgentFilter($query, request()->all(), 'service_operations.');
                    })->first();
                $totalsForCost = DB::table('service_operations')
                    ->join('agent_operations', 'service_operations.id', '=', 'agent_operations.service_operation_id')
                    ->whereDate('service_operations.created_at', '=', $this->yesterday)
                    ->where('agent_operations.user_id', auth()->id())
                    ->select(DB::raw('sum(sent_amount - platform_commission) as costSumPerDay'))
                    ->when(request()->all(), function ($query) {
                        $this->appendAgentFilter($query, request()->all(), 'service_operations.');
                    })->first();
                $totalsForAmount = DB::table('service_operations')
                    ->join('agent_operations', 'service_operations.id', '=', 'agent_operations.service_operation_id')
                    ->whereDate('service_operations.created_at', '=', $this->yesterday)
                    ->where('agent_operations.user_id', auth()->id())
                    ->when(request()->all(), function ($query) {
                        $this->appendAgentFilter($query, request()->all(), 'service_operations.');
                    })
                    ->sum('user_amount');
                break;
            case 'week':
                $totalsForOperations = DB::table('service_operations')
                    ->join('agent_operations', 'service_operations.id', '=', 'agent_operations.service_operation_id')
                    ->whereDate('service_operations.created_at', '>=', date('Y-m-d H:i:s',strtotime('-7 days')))
                    ->where('agent_operations.user_id', auth()->id())
                    ->when(request()->all(), function ($query) {
                        $this->appendAgentFilter($query, request()->all(), 'service_operations.');
                    })
                    ->count();
                $totalsForGain =  DB::table('service_operations')
                    ->join('agent_operations', 'service_operations.id', '=', 'agent_operations.service_operation_id')
                    ->whereDate('service_operations.created_at', '>=', date('Y-m-d H:i:s',strtotime('-7 days')))
                    ->where('agent_operations.user_id', auth()->id())
                    ->select(DB::raw('sum(service_operations.platform_total_gain - service_operations.user_discount) as gainSumPerDay'))
                    ->when(request()->all(), function ($query) {
                        $this->appendAgentFilter($query, request()->all(), 'service_operations.');
                    })->first();
                $totalsForCost = DB::table('service_operations')
                    ->join('agent_operations', 'service_operations.id', '=', 'agent_operations.service_operation_id')
                    ->whereDate('service_operations.created_at', '>=', date('Y-m-d H:i:s',strtotime('-7 days')))
                    ->where('agent_operations.user_id', auth()->id())
                    ->select(DB::raw('sum(service_operations.sent_amount - service_operations.platform_commission) as costSumPerDay'))
                    ->when(request()->all(), function ($query) {
                        $this->appendAgentFilter($query, request()->all(), 'service_operations.');
                    })->first();
                $totalsForAmount = DB::table('service_operations')
                    ->join('agent_operations', 'service_operations.id', '=', 'agent_operations.service_operation_id')
                    ->whereDate('service_operations.created_at', '>=', date('Y-m-d H:i:s',strtotime('-7 days')))
                    ->where('agent_operations.user_id', auth()->id())
                    ->when(request()->all(), function ($query) {
                        $this->appendAgentFilter($query, request()->all(), 'service_operations.');
                    })
                    ->sum('service_operations.user_amount');
                break;
            case 'month':
                $totalsForOperations = DB::table('service_operations')
                    ->join('agent_operations', 'service_operations.id', '=', 'agent_operations.service_operation_id')
                    ->whereDate('service_operations.created_at', '>=', date('Y-m-d H:i:s',strtotime('-30 days')))
                    ->where('agent_operations.user_id', auth()->id())
                    ->when(request()->all(), function ($query) {
                        $this->appendAgentFilter($query, request()->all(), 'service_operations.');
                    })
                    ->count();
                $totalsForGain = DB::table('service_operations')
                    ->join('agent_operations', 'service_operations.id', '=', 'agent_operations.service_operation_id')
                    ->whereDate('service_operations.created_at', '>=', date('Y-m-d H:i:s',strtotime('-30 days')))
                    ->where('agent_operations.user_id', auth()->id())
                    ->select(DB::raw('sum(service_operations.platform_total_gain - service_operations.user_discount) as gainSumPerDay'))
                    ->when(request()->all(), function ($query) {
                        $this->appendAgentFilter($query, request()->all(), 'service_operations.');
                    })->first();
                $totalsForCost = DB::table('service_operations')
                    ->join('agent_operations', 'service_operations.id', '=', 'agent_operations.service_operation_id')
                    ->whereDate('service_operations.created_at', '>=', date('Y-m-d H:i:s',strtotime('-30 days')))
                    ->where('agent_operations.user_id', auth()->id())
                    ->select(DB::raw('sum(service_operations.sent_amount - service_operations.platform_commission) as costSumPerDay'))
                    ->when(request()->all(), function ($query) {
                        $this->appendAgentFilter($query, request()->all(), 'service_operations.');
                    })->first();
                $totalsForAmount = DB::table('service_operations')
                    ->join('agent_operations', 'service_operations.id', '=', 'agent_operations.service_operation_id')
                    ->whereDate('service_operations.created_at', '>=', date('Y-m-d H:i:s',strtotime('-30 days')))
                    ->where('agent_operations.user_id', auth()->id())
                    ->when(request()->all(), function ($query) {
                        $this->appendAgentFilter($query, request()->all(), 'service_operations.');
                    })
                    ->sum('service_operations.user_amount');
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
