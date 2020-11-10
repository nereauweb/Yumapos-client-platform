<div>
    @include('livewire.loader')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>Your operations {{ date('d/m/Y', strtotime($date_begin)) }} -
                                {{ date('d/m/Y', strtotime($date_end)) }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="uk-padding-small">
                            <dl class="row">
                                <dt class="col-sm-5">Operations
                                <dt>
                                <dd class="col-sm-7">{{ $totalOperations }}</dd>
                                <dt class="col-sm-5">Total amount
                                <dt>
                                <dd class="col-sm-7">{{ $sumOfOperations }} €</dd>
                                <dt class="col-sm-5">Total commissions
                                <dt>
                                <dd class="col-sm-7">{{ $sumOfCom }} €</dd>
                            </dl>
                        </div>
                        <div class="row align-items-end">
                            <div class="col-6">
                                @include('livewire.partials.daterange')
                            </div>
                            <div class="col-2">
                                <div>
                                    <div class="form-group">
                                        <div>
                                            <button wire:click="commit" class="btn btn-success" id="commitData">Commit</button>
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
                                        <span>Date</span>
                                        @if($sortAsc && $sortField == 'created_at')
                                            <i class="cil-arrow-bottom"></i>
                                        @else
                                            <i class="cil-arrow-top"></i>
                                        @endif
                                    </th>
                                    <th wire:click="sortBy('id')">
                                        <span>Operation ID</span>
                                        @if($sortAsc && $sortField == 'id')
                                            <i class="cil-arrow-bottom"></i>
                                        @else
                                            <i class="cil-arrow-top"></i>
                                        @endif
                                    </th>
                                    <th wire:click="sortBy('service_operation_id')">
                                        <span>Original operation ID</span>
                                        @if($sortAsc && $sortField == 'service_operation_id')
                                            <i class="cil-arrow-bottom"></i>
                                        @else
                                            <i class="cil-arrow-top"></i>
                                        @endif
                                    </th>
                                    <th>Point</th>
                                    <th wire:click="sortBy('original_amount')">
                                        <span>Original amount</span>
                                        @if($sortAsc && $sortField == 'original_amount')
                                            <i class="cil-arrow-bottom"></i>
                                        @else
                                            <i class="cil-arrow-top"></i>
                                        @endif
                                    </th>
                                    <th>
                                        <span>Applied percentage</span>
                                    </th>
                                    <th  wire:click="sortBy('commission')">
                                        <span>Agent commission</span>
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
                                            <td>{{ $operation->pointOperation->user->name ?? '' }}</td>
                                            <td>{{ round($operation->original_amount, 2) }}&nbsp;&euro;</td>
                                            <td>{{ round($operation->applied_percentage, 2) }}&nbsp;%</td>
                                            <td>{{ round($operation->commission, 2) }}&nbsp;&euro;</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            {{ $operations->links() }}
                        </div>
{{--                        <form action="{{ route('admin.report.agent.export') }}" method="GET">--}}
{{--                            @csrf--}}
{{--                            <input type="hidden" name="to" value="{{ $to }}">--}}
{{--                            <input type="hidden" name="from" value="{{ $from }}">--}}
{{--                            <input type="hidden" name="agentSelected" value="{{ $agentSelected }}">--}}
{{--                            <button class="btn btn-success">Export</button>--}}
{{--                        </form>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

