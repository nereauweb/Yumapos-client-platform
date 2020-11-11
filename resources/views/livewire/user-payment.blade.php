<div>
    @include('livewire.loader')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">

                <div style="display: flex; justify-content: space-between; align-items: center;">

				<span id="card_title">
					Payments
				</span>

                    <div class="btn-group pull-right btn-group-xs">
                        <a class="dropdown-item" href="/users/payments/create">
                            <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                            Add payment
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <h1>Payments</h1>
                <div class="calculations my-4">
                    <div class="row">
                        <div class="col-2">
                            <span class="font-weight-bold">
                                Platform to you:
                            </span>
                        </div>
                        <div class="col-2">
                            <span class="font-weight-bold">
                                {{ $totalBalance }}&euro;
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <span class="font-weight-bold">
                                Your approved balance to platform:
                            </span>
                        </div>
                        <div class="col-2">
                            <span class="font-weight-bold">
                                {{ $negativeBalance }} &euro;
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <span class="font-weight-bold">Difference between balances:</span>
                        </div>
                        <div class="col-2">
                            <span class="font-weight-bold">{{ $totalBalance - $negativeBalance }} &euro;</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <span class="font-weight-bold">Your plafond amount:</span>
                        </div>
                        <div class="col-2">
                            <span class="font-weight-bold">{{ auth()->user()->plafond }} &euro;</span>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col mt-1">
                        @include('livewire.partials.daterange')
                    </div>
                    <div class="col mt-1">
                        <fieldset class="form-group">
                            <label for="state">State</label>
                            <select class="form-control" name="state" wire:model.defer="state" id="state">
                                <option value="" selected>All</option>
                                <option value="-1">Rejected</option>
                                <option value="00">Pending</option>
                                <option value="1">Approved</option>
                            </select>
                        </fieldset>
                    </div>
                    <div class="col">
                        <button id="commitData" class="mt-3 btn btn-success" wire:click="load">commit</button>
                    </div>
                </div>
                <div class="table-responsive users-table ">
                    <table class="table table-bordered col-filtered-datatable">
                        <thead class="thead">
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Details</th>
                            <th>Approved</th>
                            <th>Type</th>
                        </tr>
                        </thead>
                        <tbody id="users_table">
                            @foreach($payments as $payment)
                                <tr>
                                    <td>
                                        <span style="display:none;">{{ date("Y-m-d H:i:s",strtotime($payment->date)) }}</span>
                                        {{ date("d/m/Y",strtotime($payment->date)) }}
                                    </td>
                                    <td>{{ $payment->amount }}</td>
                                    <td>{{ $payment->details }}</td>
                                    <td>
                                        @if($payment->approved == 1)
                                            <i class="cil-check-alt"></i>
                                        @elseif($payment->approved == 0)
                                            <i class="cil-clock"></i>
                                        @elseif($payment->approved == -1)
                                            <i class="cil-x"></i>
                                        @endif
                                    </td>
                                    <td>{{ $payment->type == 1 ? 'You to platform' : 'Platform to you' }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>
                <div class="uk-margin-top">
                    {!! Form::open(array('route' => 'users.payments.export', 'method' => 'GET', 'role' => 'form', 'class' => 'needs-validation uk-margin-bottom')) !!}
                    {!! csrf_field() !!}
                    <input type="hidden" name="from" value="{{ $from }}">
                    <input type="hidden" name="to" value="{{ $to }}">
                    <input type="hidden" name="state" value="{{ $state }}">
                    {!! Form::button('Export', array('class' => 'btn btn-success','type' => 'submit' )) !!}
                    {!! Form::close() !!}
                </div>

                {!! $payments->links() !!}
            </div>
        </div>
    </div>
</div>
