<div>
    @include('livewire.loader')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">

                <div style="display: flex; justify-content: space-between; align-items: center;">

				<span id="card_title">
					{{ trans('titles.payments') }}
				</span>

                    <div class="btn-group pull-right btn-group-xs">
                        <a class="dropdown-item" href="/users/payments/create">
                            <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                            {{ trans('titles.add-payment') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <h1>{{ trans('titles.payments') }}</h1>
                <div class="calculations my-4">
                    <div class="row">
                        <div class="col-4">
                            <span class="font-weight-bold">
                                {{ trans('titles.platform-to-you') }}:
                            </span>
                        </div>
                        <div class="col-4">
                            <span class="font-weight-bold">
                                {{ $totalBalance }}&euro;
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <span class="font-weight-bold">
                                {{ trans('titles.approved-balance-to-platform') }}:
                            </span>
                        </div>
                        <div class="col-4">
                            <span class="font-weight-bold">
                                {{ $negativeBalance }} &euro;
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <span class="font-weight-bold">{{ trans('titles.difference-between-balances') }}:</span>
                        </div>
                        <div class="col-4">
                            <span class="font-weight-bold">{{ $totalBalance - $negativeBalance }} &euro;</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <span class="font-weight-bold">{{ trans('titles.your-plafond-amount') }}:</span>
                        </div>
                        <div class="col-4">
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
                            <label for="state">{{ trans('titles.state') }}</label>
                            <select class="form-control" name="state" wire:model.defer="state" id="state">
                                <option value="" selected>{{ trans('titles.all') }}</option>
                                <option value="-1">{{ trans('titles.rejected') }}</option>
                                <option value="00">{{ trans('titles.pending') }}</option>
                                <option value="1">{{ trans('titles.approved') }}</option>
                            </select>
                        </fieldset>
                    </div>
                    <div class="col">
                        <button id="commitData" class="mt-3 btn btn-success" wire:click="load">{{ trans('titles.commit') }}</button>
                    </div>
                </div>
                <div class="table-responsive users-table ">
                    <table class="table table-bordered col-filtered-datatable">
                        <thead class="thead">
                        <tr>
                            <th>ID</th>
                            <th>{{ trans('titles.date') }}</th>
                            <th>{{ trans('titles.amount') }}</th>
                            <th>{{ trans('titles.details') }}</th>
                            <th>{{ trans('titles.approved') }}</th>
                            <th>{{ trans('titles.type') }}</th>
                            <th>{{ trans('titles.documents') }}</th>
                        </tr>
                        </thead>
                        <tbody id="users_table">
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->id }}</td>
                                    <td>
                                        <span style="display:none;">{{ date("Y-m-d H:i:s",strtotime($payment->date)) }}</span>
                                        {{ date("d/m/Y",strtotime($payment->date)) }}
                                    </td>
                                    <td>{{ $payment->amount }}</td>
                                    <td>{{ $payment->details }}</td>
                                    <td class="uk-text-center">
                                        @if($payment->approved == 1)
                                            <i class="cil-check-alt"></i>
                                        @elseif($payment->approved == 0)
                                            <i class="cil-clock"></i>
											@if ($payment->type == 5 && $payment->target_id == Auth::user()->id)
                                                {!! Form::open(['route' => ['users.payments.approve', $payment->id],
                                                'method' => 'PUT', 'role' => 'form']) !!}
                                                {!! csrf_field() !!}
                                                <button class="btn btn-success mt-1" type="submit">{{ trans('titles.approve') }}</button>
                                                {!! Form::close() !!}
											@endif
                                        @elseif($payment->approved == -1)
                                            <i class="cil-x"></i>
                                        @endif
                                    </td>
                                    <td>{{ $payment->type(true,true,Auth::user()->hasRole('sales')) }}</td>
									<td>
										@if (count($payment->documents) > 0)
										<div class="row">
											@foreach ($payment->documents as $doc)
													<a target="_blank" href="{{url($doc->filename)}}">
														<svg width="30" height="30" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path></svg>
													</a>
													@if($payment->approved == 0)
														<form action="{{ route('admin.paymentfile.destroy', $doc) }}" method="post">
															@method('DELETE')
															@csrf
															<button class="btn"><i class="cid-delete mx-2">X</i></button>
														</form>
													@endif
											@endforeach
										</div>
										@endif
									</td>
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
                    {!! Form::button(trans('titles.export'), array('class' => 'btn btn-success','type' => 'submit' )) !!}
                    {!! Form::close() !!}
                </div>

                {!! $payments->links() !!}
            </div>
        </div>
    </div>
</div>
