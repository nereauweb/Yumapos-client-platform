@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @if (session()->has('status'))
                    <div class="alert @if(session()->get('status') == 'success') alert-success @else alert-danger @endif" role="alert">
                        {{ session()->get('message') }}
                    </div>
                @endif
                @if (auth()->user()->hasRole('admin'))
                        <div>
                            <div class="fade-in">
                                <div class="row">
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card text-white bg-gradient-primary">
                                            <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                                <div>
                                                    <div class="text-value-lg">
                                                        @if(Cache::has('reloadly_cache_balance'))
                                                            {{ Cache::get('reloadly_cache_balance')['balance'] }}
                                                        @else
                                                            /api/reloadly/balance not visited yet!
                                                        @endif
                                                    </div>
                                                    <div>Api reloadly balance</div>
                                                </div>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.api.reloadly.balance') }}" class="btn btn-ghost-secondary" type="button" aria-haspopup="true" aria-expanded="false">
                                                        refresh
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                                <canvas id="card-chart1" height="70" style="display: block; width: 343px; height: 70px;" width="343"></canvas>
                                                <div id="card-chart1-tooltip" class="c-chartjs-tooltip top" style="opacity: 0; left: 243.667px; top: 127.858px;"><div class="c-tooltip-header"><div class="c-tooltip-header-item">May</div></div><div class="c-tooltip-body"><div class="c-tooltip-body-item"><span class="c-tooltip-body-item-color" style="background-color: rgb(50, 31, 219);"></span><span class="c-tooltip-body-item-label">My First dataset</span><span class="c-tooltip-body-item-value">51</span></div></div></div></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card text-white bg-gradient-info">
                                            <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                                <div>
                                                    <div class="text-value-lg">
                                                        @if(Cache::has('ding_cache_balance'))
                                                            {{ Cache::get('ding_cache_balance')['balance'] }}
                                                        @else
                                                            /api/ding/balance not visited yet!
                                                        @endif
                                                    </div>
                                                    <div>Api Ding balance</div>
                                                </div>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.api.ding.Balance') }}" class="btn btn-ghost-secondary" type="button" aria-haspopup="true" aria-expanded="false">
                                                        refresh
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                                <canvas id="card-chart2" height="70" width="343" style="display: block; width: 343px; height: 70px;"></canvas>
                                                <div id="card-chart2-tooltip" class="c-chartjs-tooltip top" style="opacity: 0; left: 188.39px; top: 116.979px;"><div class="c-tooltip-header"><div class="c-tooltip-header-item">April</div></div><div class="c-tooltip-body"><div class="c-tooltip-body-item"><span class="c-tooltip-body-item-color" style="background-color: rgb(51, 153, 255);"></span><span class="c-tooltip-body-item-label">My First dataset</span><span class="c-tooltip-body-item-value">17</span></div></div></div></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card text-white bg-gradient-warning">
                                            <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                                <div>
                                                    <div class="text-value-lg">{{ $paymentsData['totals'] }}</div>
                                                    <div>Pending payments</div>
                                                </div>
                                                <div class="btn-group">
                                                    <a class="btn btn-ghost-secondary" type="button" aria-haspopup="true" aria-expanded="false" href="{{ route('admin.payments.index') }}">
                                                        view
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="c-chart-wrapper mt-3" style="height:70px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                                    @foreach($paymentsData['pending'] as $pendingPayment)
                                                        <ul>
                                                            <li style="list-style-type: none;">payment by: {{ $pendingPayment->user->name }}</li>
                                                        </ul>
                                                    @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-3">
                                        <div class="card text-white bg-gradient-danger">
                                            <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                                <div>
                                                    <div class="text-value-lg">{{ $usersData['totals'] }}</div>
                                                    <div>Pending users</div>
                                                </div>
                                                <div class="btn-group">
                                                    <a class="btn btn-ghost-secondary" type="button" aria-haspopup="true" aria-expanded="false" href="{{ route('users.index') }}">
                                                        view
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                                @foreach($usersData['pending'] as $usersPending)
                                                    <ul>
                                                        <li style="list-style-type: none;">payment by: {{ $usersPending->name }}</li>
                                                    </ul>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </div>

								<div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="card-title mb-0">Operations Report</h4>
                                            </div>
                                            <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                                                <div class="d-flex">
                                                    <div>
                                                        <select id="country-selected" autocomplete="off" class="form-control">
                                                            <option value="0">All countries</option>
                                                            @foreach(\App\Models\ServiceCountry::orderBy('name', 'asc')->get() as $country)
                                                                <option value="{{$country->iso}}">{{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="ml-3">
                                                        <select id="operator-selected" autocomplete="off" class="form-control">
                                                            <option value="0">All operators</option>
                                                            @foreach(\App\Models\ApiReloadlyOperator::orderBy('name', 'asc')->get() as $operator)
                                                                <option value="{{$operator->operatorId}}">{{ $operator->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="btn-group btn-group-toggle mx-3" data-toggle="buttons">
                                                        <label class="btn btn-outline-secondary">
                                                            <input id="option1day" value="day" name="filterSelected" type="radio" autocomplete="off" checked> Day
                                                        </label>
                                                        <label class="btn btn-outline-secondary">
                                                            <input id="option_yesterday" value="yesterday" name="filterSelected" type="radio" autocomplete="off"> Yesterday
                                                        </label>
                                                        <label class="btn btn-outline-secondary">
                                                            <input id="option_week" value="week" name="filterSelected" type="radio" autocomplete="off"> Week
                                                        </label>
                                                        <label class="btn btn-outline-secondary">
                                                            <input id="option2month" value="month" name="filterSelected" type="radio" autocomplete="off"> Month
                                                        </label>
                                                    </div>
                                                    <a href="{{ route('admin.report.operations') }}" class="btn btn-primary" type="button">
                                                        <svg class="c-icon">
                                                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-cloud-download"></use>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="c-chart-wrapper" style="height:300px;margin-top:40px;">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand">
                                                    <div class=""></div>
                                                </div>
                                                <div class="chartjs-size-monitor-shrink">
                                                    <div class=""></div>
                                                </div>
                                            </div>
                                            <canvas class="chart chartjs-render-monitor" id="main-chart" height="300" width="1549" style="display: block;"></canvas>
                                            <div id="main-chart-tooltip" class="c-chartjs-tooltip center" style="opacity: 0; left: 1004.14px; top: 302.554px;">
                                                <div class="c-tooltip-header">
                                                    <div class="c-tooltip-header-item">
                                                        T
                                                    </div>
                                                </div>
                                                <div class="c-tooltip-body">
                                                    <div class="c-tooltip-body-item">
                                                        <span class="c-tooltip-body-item-color" style="background-color: rgba(3, 9, 15, 0.1);">
                                                        </span>
                                                        <span class="c-tooltip-body-item-label">My First dataset</span>
                                                        <span class="c-tooltip-body-item-value">163</span>
                                                    </div>
                                                    <div class="c-tooltip-body-item">
                                                        <span class="c-tooltip-body-item-color" style="background-color: transparent;"></span>
                                                        <span class="c-tooltip-body-item-label">My Second dataset</span>
                                                        <span class="c-tooltip-body-item-value">97</span>
                                                    </div>
                                                    <div class="c-tooltip-body-item">
                                                        <span class="c-tooltip-body-item-color" style="background-color: transparent;"></span>
                                                        <span class="c-tooltip-body-item-label">My Third dataset</span>
                                                        <span class="c-tooltip-body-item-value">65</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row text-center">
                                            <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                                <div class="text-muted">Number of operations</div><strong id="operationsTotals">29.703</strong>
                                                <div class="progress progress-xs mt-2">
                                                    <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                                <div class="text-muted">Amount</div><strong id="amountTotals">24.093</strong>
                                                <div class="progress progress-xs mt-2">
                                                    <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                                <div class="text-muted">Cost</div><strong id="costTotals">78.706</strong>
                                                <div class="progress progress-xs mt-2">
                                                    <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                                <div class="text-muted">Gain</div><strong id="gainTotals">22.123</strong>
                                                <div class="progress progress-xs mt-2">
                                                    <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @livewireStyles()
                                @livewire('dashboard-operation-list')
                                @livewireScripts()

{{--                                <div class="row">--}}
{{--                                    <div class="col-sm-6 col-lg-4">--}}
{{--                                        <div class="card">--}}
{{--                                            <div class="card-header bg-facebook content-center">--}}
{{--                                                <svg class="c-icon c-icon-3xl text-white my-4">--}}
{{--                                                    <use xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-facebook-f"></use>--}}
{{--                                                </svg>--}}
{{--                                            </div>--}}
{{--                                            <div class="card-body row text-center">--}}
{{--                                                <div class="col">--}}
{{--                                                    <div class="text-value-xl">89k</div>--}}
{{--                                                    <div class="text-uppercase text-muted small">friends</div>--}}
{{--                                                </div>--}}
{{--                                                <div class="c-vr"></div>--}}
{{--                                                <div class="col">--}}
{{--                                                    <div class="text-value-xl">459</div>--}}
{{--                                                    <div class="text-uppercase text-muted small">feeds</div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="col-sm-6 col-lg-4">--}}
{{--                                        <div class="card">--}}
{{--                                            <div class="card-header bg-twitter content-center">--}}
{{--                                                <svg class="c-icon c-icon-3xl text-white my-4">--}}
{{--                                                    <use xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-twitter"></use>--}}
{{--                                                </svg>--}}
{{--                                            </div>--}}
{{--                                            <div class="card-body row text-center">--}}
{{--                                                <div class="col">--}}
{{--                                                    <div class="text-value-xl">973k</div>--}}
{{--                                                    <div class="text-uppercase text-muted small">followers</div>--}}
{{--                                                </div>--}}
{{--                                                <div class="c-vr"></div>--}}
{{--                                                <div class="col">--}}
{{--                                                    <div class="text-value-xl">1.792</div>--}}
{{--                                                    <div class="text-uppercase text-muted small">tweets</div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="col-sm-6 col-lg-4">--}}
{{--                                        <div class="card">--}}
{{--                                            <div class="card-header bg-linkedin content-center">--}}
{{--                                                <svg class="c-icon c-icon-3xl text-white my-4">--}}
{{--                                                    <use xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-linkedin"></use>--}}
{{--                                                </svg>--}}
{{--                                            </div>--}}
{{--                                            <div class="card-body row text-center">--}}
{{--                                                <div class="col">--}}
{{--                                                    <div class="text-value-xl">500+</div>--}}
{{--                                                    <div class="text-uppercase text-muted small">contacts</div>--}}
{{--                                                </div>--}}
{{--                                                <div class="c-vr"></div>--}}
{{--                                                <div class="col">--}}
{{--                                                    <div class="text-value-xl">292</div>--}}
{{--                                                    <div class="text-uppercase text-muted small">feeds</div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                </div>--}}

{{--                                <div class="row">--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <div class="card">--}}
{{--                                            <div class="card-header">Traffic &amp; Sales</div>--}}
{{--                                            <div class="card-body">--}}
{{--                                                <div class="row">--}}
{{--                                                    <div class="col-sm-6">--}}
{{--                                                        <div class="row">--}}
{{--                                                            <div class="col-6">--}}
{{--                                                                <div class="c-callout c-callout-info"><small class="text-muted">New Clients</small>--}}
{{--                                                                    <div class="text-value-lg">9,123</div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}

{{--                                                            <div class="col-6">--}}
{{--                                                                <div class="c-callout c-callout-danger"><small class="text-muted">Recuring Clients</small>--}}
{{--                                                                    <div class="text-value-lg">22,643</div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}

{{--                                                        </div>--}}

{{--                                                        <hr class="mt-0">--}}
{{--                                                        <div class="progress-group mb-4">--}}
{{--                                                            <div class="progress-group-prepend"><span class="progress-group-text">Monday</span></div>--}}
{{--                                                            <div class="progress-group-bars">--}}
{{--                                                                <div class="progress progress-xs">--}}
{{--                                                                    <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 34%" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="progress progress-xs">--}}
{{--                                                                    <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="progress-group mb-4">--}}
{{--                                                            <div class="progress-group-prepend"><span class="progress-group-text">Tuesday</span></div>--}}
{{--                                                            <div class="progress-group-bars">--}}
{{--                                                                <div class="progress progress-xs">--}}
{{--                                                                    <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 56%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="progress progress-xs">--}}
{{--                                                                    <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 94%" aria-valuenow="94" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="progress-group mb-4">--}}
{{--                                                            <div class="progress-group-prepend"><span class="progress-group-text">Wednesday</span></div>--}}
{{--                                                            <div class="progress-group-bars">--}}
{{--                                                                <div class="progress progress-xs">--}}
{{--                                                                    <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 12%" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="progress progress-xs">--}}
{{--                                                                    <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 67%" aria-valuenow="67" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="progress-group mb-4">--}}
{{--                                                            <div class="progress-group-prepend"><span class="progress-group-text">Thursday</span></div>--}}
{{--                                                            <div class="progress-group-bars">--}}
{{--                                                                <div class="progress progress-xs">--}}
{{--                                                                    <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 43%" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="progress progress-xs">--}}
{{--                                                                    <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 91%" aria-valuenow="91" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="progress-group mb-4">--}}
{{--                                                            <div class="progress-group-prepend"><span class="progress-group-text">Friday</span></div>--}}
{{--                                                            <div class="progress-group-bars">--}}
{{--                                                                <div class="progress progress-xs">--}}
{{--                                                                    <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="progress progress-xs">--}}
{{--                                                                    <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 73%" aria-valuenow="73" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="progress-group mb-4">--}}
{{--                                                            <div class="progress-group-prepend"><span class="progress-group-text">Saturday</span></div>--}}
{{--                                                            <div class="progress-group-bars">--}}
{{--                                                                <div class="progress progress-xs">--}}
{{--                                                                    <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 53%" aria-valuenow="53" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="progress progress-xs">--}}
{{--                                                                    <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 82%" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="progress-group mb-4">--}}
{{--                                                            <div class="progress-group-prepend"><span class="progress-group-text">Sunday</span></div>--}}
{{--                                                            <div class="progress-group-bars">--}}
{{--                                                                <div class="progress progress-xs">--}}
{{--                                                                    <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 9%" aria-valuenow="9" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="progress progress-xs">--}}
{{--                                                                    <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 69%" aria-valuenow="69" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}

{{--                                                    <div class="col-sm-6">--}}
{{--                                                        <div class="row">--}}
{{--                                                            <div class="col-6">--}}
{{--                                                                <div class="c-callout c-callout-warning"><small class="text-muted">Pageviews</small>--}}
{{--                                                                    <div class="text-value-lg">78,623</div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}

{{--                                                            <div class="col-6">--}}
{{--                                                                <div class="c-callout c-callout-success"><small class="text-muted">Organic</small>--}}
{{--                                                                    <div class="text-value-lg">49,123</div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}

{{--                                                        </div>--}}

{{--                                                        <hr class="mt-0">--}}
{{--                                                        <div class="progress-group">--}}
{{--                                                            <div class="progress-group-header">--}}
{{--                                                                <svg class="c-icon progress-group-icon">--}}
{{--                                                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>--}}
{{--                                                                </svg>--}}
{{--                                                                <div>Male</div>--}}
{{--                                                                <div class="mfs-auto font-weight-bold">43%</div>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="progress-group-bars">--}}
{{--                                                                <div class="progress progress-xs">--}}
{{--                                                                    <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: 43%" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="progress-group mb-5">--}}
{{--                                                            <div class="progress-group-header">--}}
{{--                                                                <svg class="c-icon progress-group-icon">--}}
{{--                                                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user-female"></use>--}}
{{--                                                                </svg>--}}
{{--                                                                <div>Female</div>--}}
{{--                                                                <div class="mfs-auto font-weight-bold">37%</div>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="progress-group-bars">--}}
{{--                                                                <div class="progress progress-xs">--}}
{{--                                                                    <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: 43%" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="progress-group">--}}
{{--                                                            <div class="progress-group-header align-items-end">--}}
{{--                                                                <svg class="c-icon progress-group-icon">--}}
{{--                                                                    <use xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-google"></use>--}}
{{--                                                                </svg>--}}
{{--                                                                <div>Organic Search</div>--}}
{{--                                                                <div class="mfs-auto font-weight-bold mfe-2">191.235</div>--}}
{{--                                                                <div class="text-muted small">(56%)</div>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="progress-group-bars">--}}
{{--                                                                <div class="progress progress-xs">--}}
{{--                                                                    <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 56%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="progress-group">--}}
{{--                                                            <div class="progress-group-header align-items-end">--}}
{{--                                                                <svg class="c-icon progress-group-icon">--}}
{{--                                                                    <use xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-facebook-f"></use>--}}
{{--                                                                </svg>--}}
{{--                                                                <div>Facebook</div>--}}
{{--                                                                <div class="mfs-auto font-weight-bold mfe-2">51.223</div>--}}
{{--                                                                <div class="text-muted small">(15%)</div>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="progress-group-bars">--}}
{{--                                                                <div class="progress progress-xs">--}}
{{--                                                                    <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="progress-group">--}}
{{--                                                            <div class="progress-group-header align-items-end">--}}
{{--                                                                <svg class="c-icon progress-group-icon">--}}
{{--                                                                    <use xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-twitter"></use>--}}
{{--                                                                </svg>--}}
{{--                                                                <div>Twitter</div>--}}
{{--                                                                <div class="mfs-auto font-weight-bold mfe-2">37.564</div>--}}
{{--                                                                <div class="text-muted small">(11%)</div>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="progress-group-bars">--}}
{{--                                                                <div class="progress progress-xs">--}}
{{--                                                                    <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 11%" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="progress-group">--}}
{{--                                                            <div class="progress-group-header align-items-end">--}}
{{--                                                                <svg class="c-icon progress-group-icon">--}}
{{--                                                                    <use xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-linkedin"></use>--}}
{{--                                                                </svg>--}}
{{--                                                                <div>LinkedIn</div>--}}
{{--                                                                <div class="mfs-auto font-weight-bold mfe-2">27.319</div>--}}
{{--                                                                <div class="text-muted small">(8%)</div>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="progress-group-bars">--}}
{{--                                                                <div class="progress progress-xs">--}}
{{--                                                                    <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 8%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}

{{--                                                </div>--}}
{{--                                                <br>--}}
{{--                                                <table class="table table-responsive-sm table-hover table-outline mb-0">--}}
{{--                                                    <thead class="thead-light">--}}
{{--                                                    <tr>--}}
{{--                                                        <th class="text-center">--}}
{{--                                                            <svg class="c-icon">--}}
{{--                                                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-people"></use>--}}
{{--                                                            </svg>--}}
{{--                                                        </th>--}}
{{--                                                        <th>User</th>--}}
{{--                                                        <th class="text-center">Country</th>--}}
{{--                                                        <th>Usage</th>--}}
{{--                                                        <th class="text-center">Payment Method</th>--}}
{{--                                                        <th>Activity</th>--}}
{{--                                                    </tr>--}}
{{--                                                    </thead>--}}
{{--                                                    <tbody>--}}
{{--                                                    <tr>--}}
{{--                                                        <td class="text-center">--}}
{{--                                                            <div class="c-avatar"><img class="c-avatar-img" src="assets/img/avatars/1.jpg" alt="user@email.com"><span class="c-avatar-status bg-success"></span></div>--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            <div>Yiorgos Avraamu</div>--}}
{{--                                                            <div class="small text-muted"><span>New</span> | Registered: Jan 1, 2015</div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-center">--}}
{{--                                                            <svg class="c-icon c-icon-xl">--}}
{{--                                                                <use xlink:href="vendors/@coreui/icons/svg/flag.svg#cif-us"></use>--}}
{{--                                                            </svg>--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="clearfix">--}}
{{--                                                                <div class="float-left"><strong>50%</strong></div>--}}
{{--                                                                <div class="float-right"><small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small></div>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="progress progress-xs">--}}
{{--                                                                <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-center">--}}
{{--                                                            <svg class="c-icon c-icon-xl">--}}
{{--                                                                <use xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-cc-mastercard"></use>--}}
{{--                                                            </svg>--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="small text-muted">Last login</div><strong>10 sec ago</strong>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td class="text-center">--}}
{{--                                                            <div class="c-avatar"><img class="c-avatar-img" src="assets/img/avatars/2.jpg" alt="user@email.com"><span class="c-avatar-status bg-danger"></span></div>--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            <div>Avram Tarasios</div>--}}
{{--                                                            <div class="small text-muted"><span>Recurring</span> | Registered: Jan 1, 2015</div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-center">--}}
{{--                                                            <svg class="c-icon c-icon-xl">--}}
{{--                                                                <use xlink:href="vendors/@coreui/icons/svg/flag.svg#cif-br"></use>--}}
{{--                                                            </svg>--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="clearfix">--}}
{{--                                                                <div class="float-left"><strong>10%</strong></div>--}}
{{--                                                                <div class="float-right"><small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small></div>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="progress progress-xs">--}}
{{--                                                                <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-center">--}}
{{--                                                            <svg class="c-icon c-icon-xl">--}}
{{--                                                                <use xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-cc-visa"></use>--}}
{{--                                                            </svg>--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="small text-muted">Last login</div><strong>5 minutes ago</strong>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td class="text-center">--}}
{{--                                                            <div class="c-avatar"><img class="c-avatar-img" src="assets/img/avatars/3.jpg" alt="user@email.com"><span class="c-avatar-status bg-warning"></span></div>--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            <div>Quintin Ed</div>--}}
{{--                                                            <div class="small text-muted"><span>New</span> | Registered: Jan 1, 2015</div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-center">--}}
{{--                                                            <svg class="c-icon c-icon-xl">--}}
{{--                                                                <use xlink:href="vendors/@coreui/icons/svg/flag.svg#cif-in"></use>--}}
{{--                                                            </svg>--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="clearfix">--}}
{{--                                                                <div class="float-left"><strong>74%</strong></div>--}}
{{--                                                                <div class="float-right"><small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small></div>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="progress progress-xs">--}}
{{--                                                                <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: 74%" aria-valuenow="74" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-center">--}}
{{--                                                            <svg class="c-icon c-icon-xl">--}}
{{--                                                                <use xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-cc-stripe"></use>--}}
{{--                                                            </svg>--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="small text-muted">Last login</div><strong>1 hour ago</strong>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td class="text-center">--}}
{{--                                                            <div class="c-avatar"><img class="c-avatar-img" src="assets/img/avatars/4.jpg" alt="user@email.com"><span class="c-avatar-status bg-secondary"></span></div>--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            <div>Enéas Kwadwo</div>--}}
{{--                                                            <div class="small text-muted"><span>New</span> | Registered: Jan 1, 2015</div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-center">--}}
{{--                                                            <svg class="c-icon c-icon-xl">--}}
{{--                                                                <use xlink:href="vendors/@coreui/icons/svg/flag.svg#cif-fr"></use>--}}
{{--                                                            </svg>--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="clearfix">--}}
{{--                                                                <div class="float-left"><strong>98%</strong></div>--}}
{{--                                                                <div class="float-right"><small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small></div>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="progress progress-xs">--}}
{{--                                                                <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 98%" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-center">--}}
{{--                                                            <svg class="c-icon c-icon-xl">--}}
{{--                                                                <use xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-cc-paypal"></use>--}}
{{--                                                            </svg>--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="small text-muted">Last login</div><strong>Last month</strong>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td class="text-center">--}}
{{--                                                            <div class="c-avatar"><img class="c-avatar-img" src="assets/img/avatars/5.jpg" alt="user@email.com"><span class="c-avatar-status bg-success"></span></div>--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            <div>Agapetus Tadeáš</div>--}}
{{--                                                            <div class="small text-muted"><span>New</span> | Registered: Jan 1, 2015</div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-center">--}}
{{--                                                            <svg class="c-icon c-icon-xl">--}}
{{--                                                                <use xlink:href="vendors/@coreui/icons/svg/flag.svg#cif-es"></use>--}}
{{--                                                            </svg>--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="clearfix">--}}
{{--                                                                <div class="float-left"><strong>22%</strong></div>--}}
{{--                                                                <div class="float-right"><small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small></div>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="progress progress-xs">--}}
{{--                                                                <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-center">--}}
{{--                                                            <svg class="c-icon c-icon-xl">--}}
{{--                                                                <use xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-cc-apple-pay"></use>--}}
{{--                                                            </svg>--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="small text-muted">Last login</div><strong>Last week</strong>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td class="text-center">--}}
{{--                                                            <div class="c-avatar"><img class="c-avatar-img" src="assets/img/avatars/6.jpg" alt="user@email.com"><span class="c-avatar-status bg-danger"></span></div>--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            <div>Friderik Dávid</div>--}}
{{--                                                            <div class="small text-muted"><span>New</span> | Registered: Jan 1, 2015</div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-center">--}}
{{--                                                            <svg class="c-icon c-icon-xl">--}}
{{--                                                                <use xlink:href="vendors/@coreui/icons/svg/flag.svg#cif-pl"></use>--}}
{{--                                                            </svg>--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="clearfix">--}}
{{--                                                                <div class="float-left"><strong>43%</strong></div>--}}
{{--                                                                <div class="float-right"><small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small></div>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="progress progress-xs">--}}
{{--                                                                <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 43%" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-center">--}}
{{--                                                            <svg class="c-icon c-icon-xl">--}}
{{--                                                                <use xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-cc-amex"></use>--}}
{{--                                                            </svg>--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="small text-muted">Last login</div><strong>Yesterday</strong>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    </tbody>--}}
{{--                                                </table>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                @endif
{{--                <div class="card" uk-height-viewport="offset-top: true, offset-bottom: true">--}}
{{--                    <div class="card-body">--}}
{{--						<div>--}}
{{--                            <h1 class="text-center my-5">Welcome to Yumapos</h1>--}}
{{--                            @if (auth()->user()->hasRole('admin'))--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-6">--}}
{{--                                    <h2>User Details</h2>--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-6">--}}
{{--                                        <div class="c-callout c-callout-info b-t-1 b-r-1 b-b-1">--}}
{{--                                            <small class="text-muted">All Approved users</small><br>--}}
{{--                                            <strong class="h4">{{ $data['totalUsersApproved'] }}</strong>--}}
{{--                                        </div>--}}
{{--                                        </div><!--/.col-->--}}
{{--                                        <div class="col-6">--}}
{{--                                        <div class="c-callout c-callout-danger b-t-1 b-r-1 b-b-1">--}}
{{--                                            <small class="text-muted">Users with role <strong>agent</strong></small><br>--}}
{{--                                            <strong class="h4">{{ $data['sales'] }}</strong>--}}
{{--                                        </div>--}}
{{--                                        </div><!--/.col-->--}}
{{--                                        <div class="col">--}}
{{--                                        <div class="c-callout c-callout-warning b-t-1 b-r-1 b-b-1">--}}
{{--                                            <small class="text-muted">Users waiting for approval</small><br>--}}
{{--                                            <strong class="h4">{{ $data['usersWaitingApproval'] }}</strong>--}}
{{--                                        </div>--}}
{{--                                        </div><!--/.col-->--}}
{{--                                    </div><!--/.row-->--}}
{{--                                    <div class="list-group mb-4">--}}
{{--                                        @foreach ($users as $user)--}}
{{--                                            <div class="list-group-item list-group-item-action">--}}
{{--                                                <div class="row justify-content-md-center">--}}
{{--                                                    <div class="col">--}}
{{--                                                        <span>{{  isset($user->name) ? $user->name : '' }}</span>@if($user->state == 0)<span class="badge bg-secondary ml-4">Pending</span>@endif--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-md-auto">--}}
{{--                                                        <div class="btn-group dropleft">--}}
{{--                                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">--}}
{{--                                                            Actions--}}
{{--                                                            </button>--}}
{{--                                                            <div class="dropdown-menu">--}}
{{--                                                            <a href="{{ route('users.show', $user) }}" class="dropdown-item">View details</a>--}}
{{--                                                            @if (!$user->state)--}}
{{--                                                                <a href="#" class="dropdown-item">Approve</a>--}}
{{--                                                                <a href="#" class="dropdown-item">Reject</a>--}}
{{--                                                            @endif--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                    {{ $users->links() }}--}}
{{--                                </div>--}}
{{--                                <div class="col-6">--}}
{{--                                    <h2>Payments Details</h2>--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-6">--}}
{{--                                        <div class="c-callout c-callout-info b-t-1 b-r-1 b-b-1">--}}
{{--                                            <small class="text-muted">All Approved payments</small><br>--}}
{{--                                            <strong class="h4">{{ $paymentsData['payments'] }}</strong>--}}
{{--                                        </div>--}}
{{--                                        </div><!--/.col-->--}}
{{--                                        <div class="col-6">--}}
{{--                                        <div class="c-callout c-callout-warning b-t-1 b-r-1 b-b-1">--}}
{{--                                            <small class="text-muted">Payments waiting for approval</small><br>--}}
{{--                                            <strong class="h4">{{ $paymentsData['pending'] }}</strong>--}}
{{--                                        </div>--}}
{{--                                        </div><!--/.col-->--}}
{{--                                        <div class="col">--}}
{{--                                            <div class="c-callout c-callout-warning b-t-1 b-r-1 b-b-1">--}}
{{--                                                <small class="text-muted">Total amounts</small><br>--}}
{{--                                                <strong class="h4">{{ $paymentsData['totals'] }}</strong>--}}
{{--                                            </div>--}}
{{--                                            </div>--}}
{{--                                    </div><!--/.row-->--}}
{{--                                    <div class="list-group mb-4">--}}
{{--                                        @foreach ($payments as $payment)--}}
{{--                                            <div class="list-group-item list-group-item-action">--}}
{{--                                                <div class="row justify-content-md-center">--}}
{{--                                                    <div class="col">--}}
{{--                                                        <div>--}}
{{--                                                            <span>{{  isset($payment->user->name) ? $payment->user->name : '' }}</span>@if (!$payment->approved)--}}
{{--                                                                <span class="badge bg-secondary ml-4">Pending</span>--}}
{{--                                                            @endif--}}
{{--                                                        </div>--}}
{{--                                                        <div>--}}
{{--                                                            <span>User balance is: {{ $payment->amount }}</span>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-md-auto">--}}
{{--                                                        <div class="btn-group dropleft">--}}
{{--                                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">--}}
{{--                                                            Actions--}}
{{--                                                            </button>--}}
{{--                                                            <div class="dropdown-menu">--}}
{{--                                                            <a href="{{ route('users.payments.show', $payment) }}" class="dropdown-item">View details</a>--}}
{{--                                                            @if (isset($payment->document))--}}
{{--                                                                @if (!$payment->approved)--}}
{{--                                                                    {!! Form::open(['route' => ['admin.payments.updatePaymentStatus', $payment->id],--}}
{{--                                                                    'method' => 'PUT', 'role' => 'form']) !!}--}}
{{--                                                                    {!! csrf_field() !!}--}}
{{--                                                                    <button class="dropdown-item" type="submit">Approve</button>--}}
{{--                                                                    {!! Form::close() !!}--}}
{{--                                                                    {!! Form::open(['route' => ['admin.payments.destroy', $payment->id],--}}
{{--                                                                    'method' => 'DELETE', 'role' => 'form']) !!}--}}
{{--                                                                    {!! csrf_field() !!}--}}
{{--                                                                    <button class="dropdown-item" type="submit">Reject</button>--}}
{{--                                                                    {!! Form::close() !!}--}}
{{--                                                                @else--}}
{{--                                                                    <a href="{{ $payment->document->filename }}" class="dropdown-item">Download file</a>--}}
{{--                                                                @endif--}}
{{--                                                            @endif--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                    {{ $payments->links() }}--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            @endif--}}
{{--						</div>--}}
{{--                    </div>--}}

{{--					</div>--}}
            </div>
        </div>
    </div>

@endsection

@section('javascript')
@endsection
