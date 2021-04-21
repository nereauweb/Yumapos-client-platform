<div>
    @include('livewire.loader')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>{{ trans('titles.your-operations') }} @if($from !== null) {{ (date('d/m/Y', strtotime($from))) }} - {{ (date('d/m/Y', strtotime($to))) }} @endif</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="uk-padding-small">
                            <dl class="row">
                                <dt class="col-sm-5">{{ trans('titles.operations') }}<dt><dd class="col-sm-7">{{ $totalOperations }}</dd>
                                <dt class="col-sm-5">{{ trans('titles.total-amount') }}<dt><dd class="col-sm-7">{{ $finalAmount }} €</dd>
                                <dt class="col-sm-5">{{ trans('titles.platform-discounts') }}<dt><dd class="col-sm-7">{{ $userDiscount }} €</dd>
                                <dt class="col-sm-5">{{ trans('titles.user-added-gains') }}<dt><dd class="col-sm-7">{{ $userGain }} €</dd>
                                <dt class="col-sm-5">{{ trans('titles.total-user-gains') }}<dt><dd class="col-sm-7">{{ $userTotalGain }} €</dd>
                            </dl>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-sm">
                                <fieldset class="form-group">
                                    <label>{{ trans('titles.search-by-operation-id') }}</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" wire:model.defer="operationId" placeholder="{{ trans('placeholders.search-by-operation-id') }}">
                                        <span class="input-group-append">
                                            <span class="input-group-text bg-primary">
                                                <button wire:click="searchById" style="border: none;outline: none; background: none;" class="cil-search btn-behance"></button>
                                            </span>
                                        </span>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col">
                                @include('livewire.partials.daterange')
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="js-select-countries">{{ trans('titles.choose-country') }}</label>
                                    <select wire:model.defer="selectedCountry" class="form-control">
                                        <option value="0" selected>{{ trans('titles.all') }}</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->isoName }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="js-select-countries">{{ trans('titles.choose-operator') }}</label>
                                    <select wire:model.defer="selectedOperator" class="form-control">
                                        <option value="0" selected>{{ trans('titles.all') }}</option>
                                        @php
                                            $check = '';
                                        @endphp
                                        @foreach($operatorsData as $key => $operator)
                                            <option value="{{ $key }}">{{ $operator }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col mt-2">
                                <button class="btn btn-success" wire:click="load" id="commitData">{{ trans('titles.commit') }}</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered col-filtered-datatable" id="admin-table" style="overflow-x:auto;">
                                <thead>
                                <tr>
                                    <th>{{ trans('titles.date') }}</th>
                                    <th>{{ trans('titles.operation-id') }}</th>
                                    <th>{{ trans('titles.country') }}</th>
                                    <th>{{ trans('titles.operator') }}</th>
                                    <th>{{ trans('titles.phone-number') }}</th>
                                    <th>{{ trans('titles.total-amount') }}</th>
                                    <th>{{ trans('titles.user-gain') }}</th>
                                    <th>{{ trans('titles.platform-discount') }}</th>
                                    <th>{{ trans('titles.total-user-gain') }}</th>
                                    <th>{{ trans('titles.receipt') }}</th>
                                    <th>{{ trans('titles.signal-status') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if($operations->count()>0)
                                        @foreach($operations as $operation)
                                            <tr>
                                                <td>{{ date('d/m/Y', strtotime($operation->created_at)) }}</td>
                                                <td>{{ $operation->id }}</td>
                                                <td>{{ $operation->country_name() }}</td>
                                                <td>{{ $operation->operator_name()  }}</td>
                                                <td>{{ $operation->request_recipient_phone }}</td>
                                                <td>{{ round($operation->final_amount,3) }}&nbsp;&euro;</td>
                                                <td>{{ round($operation->user_gain,3) }}&nbsp;&euro;</td>
                                                <td>{{ round($operation->user_discount,3) }}&nbsp;&euro;</td>
                                                <td>{{ round($operation->user_total_gain,3) }}&nbsp;&euro;</td>
                                                <td>
                                                    <a href="/users/services/print/{{ $operation->id }}" target="_BLANK">[{{ trans('titles.open') }}]</a>
                                                    <a href="/users/services/print/{{ $operation->id }}/small" target="_BLANK">[{{trans('titles.small')}}]</a>
                                                </td>
												<td>
													<div class="btn-group btn-group-xs">
														@if (!$operation->report_status)
														<button type="button" class="btn btn-table-action dropdown-toggle" data-toggle="dropdown">
															{{ trans('titles.signal-ok') }}
															<i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
															<span class="sr-only">
																{{ trans('titles.actions') }}
															</span>
														</button>
														<div class="dropdown-menu dropdown-menu-right">
															<button class="dropdown-item btn-success" data-toggle="modal" data-target="#modalApprove"
																wire:click="signal({{ $operation->id }})">{{ trans('titles.signal') }}</button>
														</div>
														@else
															<span>{{ $operation->report_status }}</span>
														@endif
													</div>
												</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {!! $operations->links() !!}
                        </div>
                        <form action="{{ route('user.operations.export') }}" method="get">
                            @csrf
                            <input type="hidden" name="to" value="{{ $to }}">
                            <input type="hidden" name="from" value="{{ $from }}">
                            <input type="hidden" name="selectedCountry" value="{{ $selectedCountry }}">
                            <input type="hidden" name="selectedOperator" value="{{ $selectedOperator }}">
                            <button class="btn btn-success">
                                {{ trans('titles.export') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

