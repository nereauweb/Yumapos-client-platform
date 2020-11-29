<div>
    @include('livewire.loader')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>Your operations @if($from !== null) {{ (date('d/m/Y', strtotime($from))) }} - {{ (date('d/m/Y', strtotime($to))) }} @endif</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="uk-padding-small">
                            <dl class="row">
                                <dt class="col-sm-5">Operations<dt><dd class="col-sm-7">{{ $totalOperations }}</dd>
                                <dt class="col-sm-5">Total amount<dt><dd class="col-sm-7">{{ $finalAmount }} €</dd>
                                <dt class="col-sm-5">Platform discounts<dt><dd class="col-sm-7">{{ $userDiscount }} €</dd>
                                <dt class="col-sm-5">User added gains<dt><dd class="col-sm-7">{{ $userGain }} €</dd>
                                <dt class="col-sm-5">Total user gains<dt><dd class="col-sm-7">{{ $userTotalGain }} €</dd>
                            </dl>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-sm">
                                <fieldset class="form-group">
                                    <label>Search by operation ID</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" wire:model.defer="operationId" placeholder="search by operation id">
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
                                    <label for="js-select-countries">Choose country</label>
                                    <select wire:model.defer="selectedCountry" class="form-control">
                                        <option value="0" selected>All</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->isoName }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="js-select-countries">Choose operator</label>
                                    <select wire:model.defer="selectedOperator" class="form-control">
                                        <option value="0" selected>All</option>
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
                                <button class="btn btn-success" wire:click="load" id="commitData">commit</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered col-filtered-datatable" id="admin-table" style="overflow-x:auto;">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Operation ID</th>
                                    <th>Country</th>
                                    <th>Operator</th>
                                    <th>Phone number</th>
                                    <th>Total amount</th>
                                    <th>User gain</th>
                                    <th>Platform discount</th>
                                    <th>Total user gain</th>
                                    <th>Receipt</th>
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
                                                <td>{{ round($operation->final_amount,2) }}&nbsp;&euro;</td>
                                                <td>{{ round($operation->user_gain,2) }}&nbsp;&euro;</td>
                                                <td>{{ round($operation->user_discount,2) }}&nbsp;&euro;</td>
                                                <td>{{ round($operation->user_total_gain,2) }}&nbsp;&euro;</td>
                                                <td>
                                                    <a href="/users/services/print/{{ $operation->id }}" target="_BLANK">[OPEN]</a>
                                                    <a href="/users/services/print/{{ $operation->id }}/small" target="_BLANK">[small]</a>
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
                                Export
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

