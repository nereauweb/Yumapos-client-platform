<div class="row">
    @include('livewire.loader')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
					<div>
						<h4 class="card-title mb-0 mt-1">{{ trans('titles.traffic-sales') }}</h4>
					</div>
                    <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                        <div class="d-flex">
                            <div class="btn-group btn-group-toggle mx-3" data-toggle="buttons">
                                <label class="btn btn-outline-secondary {{ $filterSelected == 'day' ? 'active' : '' }}">
                                    <input wire:model="filterSelected" value="day" name="filterSelectedOperation" type="radio" autocomplete="off" checked> {{ trans('days.day') }}
                                </label>
                                <label class="btn btn-outline-secondary {{ $filterSelected == 'yesterday' ? 'active' : '' }}">
                                    <input wire:model="filterSelected" value="yesterday" name="filterSelectedOperation" type="radio" autocomplete="off"> {{ trans('days.yesterday') }}
                                </label>
                                <label class="btn btn-outline-secondary {{ $filterSelected == 'week' ? 'active' : '' }}">
                                    <input wire:model="filterSelected" value="week" name="filterSelectedOperation" type="radio" autocomplete="off"> {{ trans('days.week') }}
                                </label>
                                <label class="btn btn-outline-secondary {{ $filterSelected == 'month' ? 'active' : '' }}">
                                    <input wire:model="filterSelected" value="month" name="filterSelectedOperation" type="radio" autocomplete="off"> {{ trans('days.month') }}
                                </label>
                            </div>
							<a href="{{ auth()->user()->hasRole('admin') ? route('admin.report.operations') : url('users/reports/operations')  }}" class="btn btn-primary" type="button">
								<i class="cil-library"></i>
							</a>
                            @if(auth()->user()->hasRole('admin'))
                            <div class="ml-2">
                                <div class="d-flex">
                                    <input class="form-control" wire:model.defer="userEmail" type="text" placeholder="{{ trans('placeholders.search-by-email') }}">
                                    <button class="btn btn-primary" wire:click="searchByEmail">{{ trans('titles.search') }}</button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-header">{{ trans('titles.user') }}</div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            @foreach($usersDetails as $operation)
                                                <li class="list-group-item d-flex list-group-item-action justify-content-between align-items-center">{{ $operation->user->name }}<span class="badge badge-primary badge-pill">{{ $operation->amount }}</span></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card">
                                    <div class="card-header">{{ trans('titles.country') }}</div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            @foreach($countriesList as $country)
                                                <li class="list-group-item d-flex list-group-item-action justify-content-between align-items-center">{{ $country->country_name() }}<span class="badge badge-primary badge-pill">{{ $country->amount }}</span></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card">
                                    <div class="card-header">{{ trans('titles.operator') }}</div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            @foreach($operationsList as $serviceOperation)
                                                <li class="list-group-item d-flex list-group-item-action justify-content-between align-items-center">{{ $serviceOperation->operator_name() }}<span class="badge badge-primary badge-pill">{{ $serviceOperation->amount }}</span></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <table class="table table-responsive-sm table-hover table-outline mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th class="text-center">
                            <svg class="c-icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-people"></use>
                            </svg>
                        </th>
                        <th>{{ trans('titles.user') }}</th>
                        <th>{{ trans('titles.amount') }}</th>
                        <th>{{ trans('titles.cost') }}</th>
                        <th>{{ trans('titles.gain') }}</th>
                        <th>{{ trans('titles.country') }}</th>
                        <th>{{ trans('titles.operator') }}</th>
                        <th>{{ trans('titles.provider') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($services as $service)
                        <tr>
                            <td class="text-center">
                                {{ date('d/m/Y h:s', strtotime($service->created_at)) }}
                            </td>
                            <td>
                                <div>{{ $service->user->name ?? '' }}</div>
                                @if(!is_null($service->user->operative_seat_city))
                                    <div class="small text-muted">{{ $service->user->operative_seat_city }}</div>
                                @endif
                            </td>
                            <td>
                                <div>
                                    {{ $service->sent_amount }}
                                </div>
                            </td>
                            <td>
                                {{ $service->sent_amount - $service->platform_commission }}
                            </td>
                            <td>
                                {{ $service->platform_total_gain - $service->user_discount }}
                            </td>
                            <td>
                                {{ $service->country_name() }}
                            </td>
                            <td>
                                {{ $service->operator_name() }}
                            </td>
                            <td>
                                {{ $service->provider }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
