<div>
    @include('livewire.loader')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>{{ $user_name }} {{ trans('descriptions.operations') }} {{ date('d/m/Y', strtotime($date_begin)) }} -
                                {{ date('d/m/Y', strtotime($date_end)) }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="uk-padding-small">
                            <dl class="row">
                                <dt class="col-sm-5">{{ trans('titles.operations') }}
                                <dt>
                                <dd class="col-sm-7">{{ $totalOperations }}</dd>
                                <dt class="col-sm-5">{{ trans('titles.total-amount') }}
                                <dt>
                                <dd class="col-sm-7">{{ $sumOfOperations }} €</dd>
                                <dt class="col-sm-5">{{ trans('titles.total-commissions') }}
                                <dt>
                                <dd class="col-sm-7">{{ $sumOfCom }} €</dd>
                            </dl>
                        </div>
                        <div class="row align-items-end">
                            <div class="col-6">
                                @include('livewire.partials.daterange')
                            </div>
                            <div class="col-4">
                                <div>
                                    <div class="form-group w-100">
                                        <label for="exampleFormControlSelect1">{{ trans('titles.agent') }}</label>
                                        <select wire:model.defer="agentSelected" class="form-control custom-select" name="user">
                                            <option value="0" selected>All agents</option>
                                            @foreach ($agents as $key => $agent)
                                                @if (!is_null($agent))
                                                    <option value="{{ $key }}">{{ $agent }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div>
                                    <div class="form-group">
                                        <div>
                                            <button wire:click="commit" class="btn btn-success" id="commitData">{{ trans('titles.commit') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="overflow:auto;">
                            <table class="table table-bordered" id="admin-table">
                                <thead>
                                    <tr>
                                        <th wire:click="sortBy('created_at')">
                                            <span>{{trans('titles.date')}}</span>
                                            @if($sortAsc && $sortField == 'created_at')
                                                <i class="cil-arrow-bottom"></i>
                                            @else
                                                <i class="cil-arrow-top"></i>
                                            @endif
                                        </th>
                                        <th wire:click="sortBy('id')">
                                            <span>{{ trans('titles.operation-id') }}</span>
                                            @if($sortAsc && $sortField == 'id')
                                                <i class="cil-arrow-bottom"></i>
                                            @else
                                                <i class="cil-arrow-top"></i>
                                            @endif
                                        </th>
                                        <th wire:click="sortBy('service_operation_id')">
                                            <span>{{ trans('titles.original-operation-id') }}</span>
                                            @if($sortAsc && $sortField == 'service_operation_id')
                                                <i class="cil-arrow-bottom"></i>
                                            @else
                                                <i class="cil-arrow-top"></i>
                                            @endif
                                        </th>
                                        <th>{{ trans('titles.agent') }}</th>
                                        <th>{{ trans('titles.point') }}</th>
                                        <th wire:click="sortBy('original_amount')">
                                            <span>{{ trans('titles.original-amount') }}</span>
                                            @if($sortAsc && $sortField == 'original_amount')
                                                <i class="cil-arrow-bottom"></i>
                                            @else
                                                <i class="cil-arrow-top"></i>
                                            @endif
                                        </th>
                                        <th>
                                            <span>{{ trans('titles.applied-commission-id') }}</span>
                                        </th>
                                        <th  wire:click="sortBy('commission')">
                                            <span>{{ trans('titles.agent-commission') }}</span>
                                            @if($sortAsc && $sortField == 'commission')
                                                <i class="cil-arrow-bottom"></i>
                                            @else
                                                <i class="cil-arrow-top"></i>
                                            @endif
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($operations->count() > 0)
                                        @foreach ($operations as $operation)
                                            <tr>
                                                <td>{{ date('d/m/Y', strtotime($operation->created_at)) }}</td>
                                                <td>{{ $operation->id }}</td>
                                                <td>{{ $operation->service_operation_id }}</td>
                                                <td>{{ $operation->user->name ?? 'not set' }}</td>
                                                <td>{{ $operation->pointOperation->user->name ?? '' }}</td>
                                                <td>{{ round($operation->original_amount, 2) }}&nbsp;&euro;</td>
                                                <td>{{ $operation->applied_commission_id }}</td>
                                                <td>{{ round($operation->commission, 2) }}&nbsp;&euro;</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{ $operations->links() }}
                        </div>
                        <form action="{{ route('admin.report.agent.export') }}" method="GET">
                            @csrf
                            <input type="hidden" name="to" value="{{ $to }}">
                            <input type="hidden" name="from" value="{{ $from }}">
                            <input type="hidden" name="agentSelected" value="{{ $agentSelected }}">
                            <button class="btn btn-success">{{ trans('titles.export') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

