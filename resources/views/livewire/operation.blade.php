<div class="card">
    <div>
    @include('livewire.loader')
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3>{{ $user_name }} {{ trans('titles.operations') }} {{ date('d/m/Y', strtotime($date_begin)) }} -
                    {{ date('d/m/Y', strtotime($date_end)) }}</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="uk-width-1-1 uk-grid uk-child-width-1-2" uk-grid>
                <div class="">
                    <dl class="row uk-padding-small">
                        <dt class="col-sm-5">{{ trans('titles.operations') }}</dt>
                        <dd class="col-sm-7">{{ $totalOperationsCount }}</dd>
                        <dt class="col-sm-5">{{ trans('titles.total-user-discounts') }}</dt>
                        <dd class="col-sm-7">{{ $operationsSum }} €</dd>
                        <dt class="col-sm-5">{{ trans('titles.total-commissions') }}</dt>
                        <dd class="col-sm-7">{{ $totalCommissions }} €</dd>
                        <dt class="col-sm-5">{{ trans('titles.total-gross-plaform-gains') }}</dt>
                        <dd class="col-sm-7">{{ $totalGrossPlatformGain }} €</dd>
                        <dt class="col-sm-5">{{ trans('titles.total-net-platform-gains') }}</dt>
                        <dd class="col-sm-7">{{ $totalNetPlatformGains }} €</dd>
                        <dt class="col-sm-5">{{ trans('titles.volume-user-amount') }} {{ $selectedCountry ? trans('titles.country').' ISO '.$selectedCountry : trans('titles.country') }}</dt>
                        <dd class="col-sm-7">{{ $sentAmount }} €</dd>
                        <dt class="col-sm-5">{{ trans('titles.platform-total-gain') }} {{ $selectedOperator ? 'Operator id '.$selectedOperator : 'operator' }}</dt>
                        <dd class="col-sm-7">{{ $platformTotalGain }} €</dd>
                </div>
                <div class="">
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
                    <div class="col-sm">
                        @include('livewire.partials.daterange')
                    </div>
                    <div class="col-sm">
                        <fieldset class="form-group">
                            <label>{{ trans('titles.user') }}</label>
                            <div class="input-group">
                            <span class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="cil-user"></i>
                                </span>
                            </span>
                                <select wire:model.defer="userSelected" class="form-control custom-select" name="user">
                                    <option value="0" @if ($user_id == 0) selected
                                        @endif>{{ trans('titles.all-users') }}</option>
                                    @foreach ($users as $list_user_id => $list_user_name)
                                        <option value="{{ $list_user_id }}" @if ($user_id == $list_user_id) selected
                                            @endif>{{ $list_user_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
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
                            <label for="js-select-operators">{{ trans('titles.choose-operator') }}</label>
                            <select wire:model.defer="selectedOperator" class="form-control">
                                <option value="0" selected>{{ trans('titles.all') }}</option>
                                @foreach($usedOperators as $key => $operator)
                                    <option value="{{ $key }}">{{ $operator }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm mt-2">
                        <button class="btn btn-success" id="commitData" wire:click="commit">{{ trans('titles.commit') }}</button>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-1 table-responsive uk-margin-top">
                <table class="table table-striped table-bordered col-filtered-datatable" id="admin-table">
                    <thead>
                    <tr class="cursorPointer">
                        <th wire:click="sortBy('created_at')">
                            <span>{{ trans('titles.date') }}</span>
                            @if($sortAsc && $sortField == 'created_at')
                                <i class="cil-arrow-bottom"></i>
                            @else
                                <i class="cil-arrow-top"></i>
                            @endif
                        </th>
                        <th>
                            <span>{{ trans('titles.user') }}</span>
                            {{-- <svg width="20" height="20" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                                </path>
                            </svg> --}}
                        </th>
                        <th wire:click="sortBy('id')">
                            <span>{{ trans('titles.operation-id') }}</span>
                            @if($sortAsc && $sortField == 'id')
                                <i class="cil-arrow-bottom"></i>
                            @else
                                <i class="cil-arrow-top"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('provider')">
                            <span>{{ trans('titles.provider') }}</span>
                            @if($sortAsc && $sortField == 'reloadly_transactionId')
                                <i class="cil-arrow-bottom"></i>
                            @else
                                <i class="cil-arrow-top"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('request_country_iso')">
                            <span>{{ trans('titles.country') }}</span>
                            @if($sortAsc && $sortField == 'request_country_iso')
                                <i class="cil-arrow-bottom"></i>
                            @else
                                <i class="cil-arrow-top"></i>
                            @endif
                        </th>
                        <th>{{ trans('titles.operator') }}</th>
                        <th wire:click="sortBy('request_recipient_phone')">
                            <span>{{ trans('titles.phone-number') }}</span>
                            @if($sortAsc && $sortField == 'request_country_iso')
                                <i class="cil-arrow-bottom"></i>
                            @else
                                <i class="cil-arrow-top"></i>
                            @endif
                        </th>
                        <th>{{ trans('titles.expected-destination-amount') }}</th>
                        <th>&Delta; {{ trans('titles.paid-sent-amount') }}</th>
                        <th>{{ trans('titles.agent-commission') }}</th>
                        <th>{{ trans('titles.platform-commission') }}</th>
                        <th>{{ trans('titles.gross-platform-gain') }}</th>
                        <th>{{ trans('titles.user-discount') }}</th>
                        <th>{{ trans('titles.net-platform-gain') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if ($operations->count() > 0)
                        @foreach ($operations as $operation)
                            <tr>
                                <td>{{ date('d/m/Y H:i:s', strtotime($operation->created_at)) }}</td>
                                <td>{{ $operation->user->name ?? '' }} [Id {{ $operation->user->id ?? '' }}]
                                </td>
                                <td>{{ $operation->id }}</td>
                                <td><a href="#"  onclick="details({{ $operation->id }})">{{ $operation->provider }}</a></td>
                                <td>{{ $operation->request_country_iso }}</td>
                                <td>{{ $operation->operator_name() }}</td>
                                <td>{{ $operation->request_recipient_phone }}</td>
                                <td>{{ round($operation->final_expected_destination_amount, 2) ?? '' }}&nbsp;{{ $operation->reloadly_operation->deliveredAmountCurrencyCode ?? '' }}
                                </td>
                                <td>{{ round($operation->final_amount - $operation->user_gain - $operation->sent_amount, 2) }}&nbsp;&euro;
                                </td>
                                <td>{{ $operation->agent_commission ? round($operation->agent_commission, 2) : 0 }}&nbsp;&euro;</td>
                                <td>{{ round($operation->platform_commission, 2) }}&nbsp;&euro;</td>
                                <td>{{ round($operation->platform_total_gain, 2) }}&nbsp;&euro;</td>
                                <td>{{ round($operation->user_discount, 2) }}&nbsp;&euro;</td>
                                <td>{{ round($operation->platform_total_gain - $operation->user_discount, 2) }}&nbsp;&euro;
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                {{ $operations->links() }}
            </div>
            <div class="uk-width-1-1 uk-margin-top">
                {!! Form::open(['route' => 'admin.report.operations.export', 'method' => 'GET', 'role' => 'form',
                'class' => 'needs-validation uk-margin-bottom']) !!}
                {!! csrf_field() !!}
                {!! Form::button(trans('titles.export'), ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                <input type="hidden" name="date_begin" value="{{ date('Y-m-d', strtotime($date_begin)) }}">
                <input type="hidden" name="date_end" value="{{ date('Y-m-d', strtotime($date_end)) }}">
                <input type="hidden" name="isoName" value="{{ $selectedCountry }}">
                <input type="hidden" name="operatorId" value="{{ $selectedOperator }}">
                {!! Form::close() !!}
                {!! Form::open(['route' => 'admin.report.operations.export.simple', 'method' => 'GET', 'role' =>
                'form', 'class' => 'needs-validation uk-margin-bottom']) !!}
                {!! csrf_field() !!}
                {!! Form::button(trans('titles.formatted-export'), ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                <input type="hidden" name="date_begin" value="{{ date('Y-m-d', strtotime($date_begin)) }}">
                <input type="hidden" name="date_end" value="{{ date('Y-m-d', strtotime($date_end)) }}">
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
