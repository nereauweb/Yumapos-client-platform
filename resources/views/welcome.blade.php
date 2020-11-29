@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @if (auth()->user()->hasRole('admin'))
                        <div>
                            <div class="fade-in">
                                <div class="row" style="height: 200px">
                                    <div class="col-sm-6 col-lg-3" style="height: 100%">
                                        <div class="card text-white bg-gradient-primary" style="height: 90%">
                                            <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                                <div>
                                                    <div class="text-value-lg">
                                                        @if(Cache::has('reloadly_cache_balance_'.date('w')))
                                                            <span id="reloadly-balance">{{ Cache::get('reloadly_cache_balance_'.date('w'))[date('w')] }}</span> €
                                                        @else
                                                           <span id="reloadly-balance">Out of sync</span>
                                                        @endif
                                                    </div>
                                                    <div class="uk-text-uppercase">Reloadly balance</div>
                                                </div>
                                                <div class="btn-group">
                                                    <a href="#" class="btn btn-pill btn-success" type="button" aria-haspopup="true" aria-expanded="false" id="reload-reloadly-balance">
                                                         <i class="cil-sync"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                                <canvas id="card-chart1" height="80" style="display: block; width: 343px; height: 70px;" width="343"></canvas>
                                                <div id="card-chart1-tooltip" class="c-chartjs-tooltip top" style="opacity: 0; left: 243.667px; top: 127.858px;"><div class="c-tooltip-header"><div class="c-tooltip-header-item">May</div></div><div class="c-tooltip-body"><div class="c-tooltip-body-item"><span class="c-tooltip-body-item-color" style="background-color: rgb(50, 31, 219);"></span><span class="c-tooltip-body-item-label">My First dataset</span><span class="c-tooltip-body-item-value">51</span></div></div></div></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-3" style="height: 100%">
                                        <div class="card text-white bg-gradient-info" style="height: 90%">
                                            <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                                <div>
                                                    <div class="text-value-lg">
                                                        @if(Cache::has('ding_cache_balance_'.date('w')))
                                                            <span id="ding-balance">{{ Cache::get('ding_cache_balance_'.date('w'))[date('w')] }}</span> €
                                                        @else
                                                           <span id="ding-balance">Out of sync</span>
                                                        @endif
                                                    </div>
                                                    <div class="uk-text-uppercase">Api Ding balance</div>
                                                </div>
                                                <div class="btn-group">
                                                    <a href="#" class="btn btn-pill btn-success" type="button" aria-haspopup="true" aria-expanded="false" id="reload-ding-balance">
                                                        <i class="cil-sync"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                                <canvas id="card-chart2" height="80" width="343" style="display: block; width: 343px; height: 70px;"></canvas>
                                                <div id="card-chart2-tooltip" class="c-chartjs-tooltip top" style="opacity: 0; left: 188.39px; top: 116.979px;"><div class="c-tooltip-header"><div class="c-tooltip-header-item">April</div></div><div class="c-tooltip-body"><div class="c-tooltip-body-item"><span class="c-tooltip-body-item-color" style="background-color: rgb(51, 153, 255);"></span><span class="c-tooltip-body-item-label">My First dataset</span><span class="c-tooltip-body-item-value">17</span></div></div></div></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-3" style="height: 100%">
                                        <div class="card text-white bg-gradient-warning" style="height: 90%">
                                            <div class="card-body card-body pb-0">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <div class="text-value-lg">{{ $paymentsData['totals'] }}</div>
                                                        <div class="uk-text-uppercase">Pending payments</div>
                                                    </div>
                                                    <div class="btn-group">
                                                        <a class="btn btn-pill btn-primary" type="button" aria-haspopup="true" aria-expanded="false" href="{{ route('admin.payments.index') }}">
                                                             <i class="cil-library"></i>
                                                        </a>
                                                    </div>
                                                </div>

                                            <div class="c-chart-wrapper" style="height:70px;">
                                                <div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand">
                                                    <div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                                    <ul class="uk-list m-0 p-1">
                                                        @foreach($paymentsData['pending'] as $pendingPayment)
                                                            <li class="m-0">
                                                                <div class="btn-group btn-group-xs my-1">
                                                                    <button type="button" class=" uk-button uk-button-link btn-table-action dropdown-toggle" data-toggle="dropdown">
                                                                        <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                                                        <span class="sr-only">
																		Actions
																	</span>
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        @if ($pendingPayment->approved == 0)
                                                                            {!! Form::open(['route' => ['admin.payments.updatePaymentStatus', $pendingPayment->id],
                                                                            'method' => 'PUT', 'role' => 'form']) !!}
                                                                            {!! csrf_field() !!}
                                                                            <button class="dropdown-item" type="submit">Approve</button>
                                                                            {!! Form::close() !!}
                                                                            {!! Form::open(['route' => ['admin.payments.reject', $pendingPayment],
                                                                            'method' => 'DELETE', 'role' => 'form']) !!}
                                                                            {!! csrf_field() !!}
                                                                            <button class="dropdown-item" type="submit">Reject</button>
                                                                            {!! Form::close() !!}
                                                                            <a href="{{ route('admin.payments.edit', $pendingPayment) }}" class="dropdown-item">Edit payment</a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                {{ substr($pendingPayment->user->name,0,15) }}
                                                                <strong>{{ $pendingPayment->amount }} €</strong>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    <div class="col-sm-6 col-lg-3" style="height: 100%">
                                        <div class="card text-white bg-gradient-danger" style="height: 90%">
                                            <div class="card-body card-body pb-0">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <div class="text-value-lg">{{ $usersData['totals'] }}</div>
                                                        <div class="uk-text-uppercase">Pending users</div>
                                                    </div>
                                                    <div class="btn-group">
                                                        <a class="btn btn-pill btn-primary" type="button" aria-haspopup="true" aria-expanded="false" href="{{ route('users.index') }}">
                                                            <i class="cil-library"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="c-chart-wrapper mt-2" style="height:70px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                                        @foreach($usersData['pending'] as $user)
                                                            @livewire('dashboard-user-managment', ['user' => $user])
                                                        @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

								<div class="card">
                                    <div class="card-body">
										<div>
											<h4 class="card-title">Operations Report</h4>
										</div>
                                        <div class="d-flex justify-content-between">
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
                                                            @foreach(\App\Models\ServiceOperator::orderBy('name', 'asc')->pluck('name','id') as $key => $operator)
                                                                <option value="{{ $key }}">{{ $operator}}</option>
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
                                                        <i class="cil-library"></i>
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
                            </div>
                        </div>
<script>
$(document).ready(function(){
	// api reloadly cached values
	let dingValues = [];
	let labelsForDing = [];
	fetch('/admin/api/ding/graph').then(data => data.json()).then(data => {
		for (const [key, value] of Object.entries(data['graph_data'])) {
			labelsForDing.push(key);
			dingValues.push(parseInt(value));
		}

	}).then(item => {
		var cardChart2 = new Chart(document.getElementById('card-chart2'), {
			type: 'line',
			data: {
				labels: labelsForDing,
				datasets: [{
					label: 'Balance',
					backgroundColor: 'transparent',
					borderColor: 'rgba(255,255,255,.55)',
					pointBackgroundColor: coreui.Utils.getStyle('--info'),
					data: dingValues
				}]
			},
			options: {
				maintainAspectRatio: false,
				legend: {
					display: false
				},
				scales: {
					xAxes: [{
						gridLines: {
							color: 'transparent',
							zeroLineColor: 'transparent'
						},
						ticks: {
							fontSize: 2,
							fontColor: 'transparent'
						}
					}],
					yAxes: [{
						display: false,
						ticks: {
							display: false,
							// min: -4,
							// max: 39
						}
					}]
				},
				elements: {
					line: {
						tension: 0.00001,
						borderWidth: 1
					},
					point: {
						radius: 4,
						hitRadius: 10,
						hoverRadius: 4
					}
				}
			}
		}); // eslint-disable-next-line no-unused-vars
	}).catch(e => {
		console.log(e);
	});
	// api reloadly cached values
	let reloadlyValues = [];
	let labelsForReloadly = [];
	fetch('/admin/api/reloadly/graph').then(data => data.json()).then(data => {
		for (const [key, value] of Object.entries(data['graph_data'])) {
			labelsForReloadly.push(key);
			reloadlyValues.push(parseInt(value));
		}

	}).then(item => {
		var cardChart1 = new Chart(document.getElementById('card-chart1'), {
			type: 'line',
			data: {
				labels: labelsForReloadly,
				datasets: [{
					label: 'Balance',
					backgroundColor: 'transparent',
					borderColor: 'rgba(255,255,255,.55)',
					pointBackgroundColor: coreui.Utils.getStyle('--primary'),
					data: reloadlyValues
				}]
			},
			options: {
				maintainAspectRatio: false,
				legend: {
					display: false
				},
				scales: {
					xAxes: [{
						gridLines: {
							color: 'transparent',
							zeroLineColor: 'transparent'
						},
						ticks: {
							fontSize: 2,
							fontColor: 'transparent'
						}
					}],
					yAxes: [{
						display: false,
						ticks: {
							display: false,
							// min: 35,
							// max: 89
						}
					}]
				},
				elements: {
					line: {
						borderWidth: 1
					},
					point: {
						radius: 4,
						hitRadius: 10,
						hoverRadius: 4
					}
				}
			}
		});
	}).catch(e => {
		console.log(e);
	});
});
</script>
                @else
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-center">
                                    <div>
                                        <div class="d-flex align-items-center">
                                            <h4 class="card-title mb-0">Operations Report</h4>
                                            @role('sales')
                                            <div class="ml-3">
                                                <select id="graph-selected" autocomplete="off" class="form-control">
                                                    <option value="1" selected>User Chart</option>
                                                    <option value="2">Agent Chart</option>
                                                </select>
                                            </div>
                                            @endrole
                                        </div>
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
                                                    @foreach(\App\Models\ServiceOperator::orderBy('name', 'asc')->pluck('name','id') as $key => $operator)
                                                        <option value="{{ $key }}">{{ $operator}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input hidden value="{{ auth()->id() }}" id="identifier-custom">
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
                                            <a href="{{ url('users/reports/operations') }}" class="btn btn-primary" type="button">
                                                        <i class="cil-library"></i>
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
                        @livewire('dashboard-operation-list', ['isUser' => true])
                        @livewireScripts()
                @endif
            </div>
        </div>
    </div>
{{--    <div class="modal fade" id="modalApprove" tabindex="-1" role="dialog" aria-labelledby="modalApproveLabel" aria-hidden="true">--}}
{{--        <div class="modal-dialog" role="document">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title" id="modalApproveLabel">Approve user</h5>--}}
{{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true">&times;</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    ...--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
{{--                    <button type="button" class="btn btn-primary" id="saveUserModalBtn">Save changes</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection

@section('javascript')
	<script>
		$("#reload-reloadly-balance").click(function(e){
			e.preventDefault();
			$.get( "{{ route('admin.api.reloadly.cached_balance') }}", function( data ) {
				if(data!='error'){
					$( "#reloadly-balance" ).html( data );
				}
			});
        });
		$("#reload-ding-balance").click(function(e){
			e.preventDefault();
			$.get( "{{ route('admin.api.ding.cached_balance') }}", function( data ) {
				if(data!='error'){
					$( "#ding-balance" ).html( data );
				}
			});
		});

		// $('#saveUserModalBtn').click((e) => {
		//     e.preventDefault();
		//     fetch('/admin/agent/user/approve', {
		//         method: "POST",
        //         headers: {
        //             "Content-Type": "application/json",
        //             "Accept": "application/json, text-plain, */*",
        //             'X-CSRF-TOKEN': document.getElementsByName('csrf-token')[0].getAttribute('content')
        //         },
        //         body: JSON.stringify({
        //             parent_percent: '',
        //             debt_limit:'',
        //             group_id: '',
        //             plafond: '',
        //             user_id: '',
        //         })
        //     }).then(response => response.json()).then(res => () => {
        //         console.log(res);
        //     }).catch();
        // })

	</script>
@endsection
