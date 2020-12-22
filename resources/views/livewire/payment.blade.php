<div>
    @include('livewire.loader')
    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span id="card_title">
                    {{ trans('titles.payments') }}
                </span>
                <div class="pull-right">
                    <a class="btn btn-danger" href="{{ route('admin.trashedPayments') }}">
                        <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                        {{ trans('titles.list-trashed-payments') }}
                    </a>
                    <a class="btn btn-info" href="{{ route('admin.payUser') }}">
                        <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                        {{ trans('titles.pay-user') }}
                    </a>
                    <a class="btn btn-info" href="{{ route('admin.payProvider') }}">
                        <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                        {{ trans('titles.pay-provider') }}
                    </a>
                    <a class="btn btn-success" href="/admin/payments/create">
                        <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                        {{ trans('titles.add-payment') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">

            <h1>{{ trans('titles.payments') }}</h1>
            <div class="uk-padding-small">
                <dl class="row">
                    <dt class="col-sm-5">{{ trans('descriptions.total-positive-balance') }}:</dt>
                    <dd class="col-sm-7">{{ $positiveBalance }}&euro;</dd>
                    <dt class="col-sm-5">{{ trans('descriptions.total-negative-balance') }}:</dt>
                    <dd class="col-sm-7">{{ $negativeBalance }}&euro;</dd>
                    <dt class="col-sm-5">{{ trans('descriptions.difference-between-negpos-balance') }}:</dt>
                    <dd class="col-sm-7">{{ $diffBalance }}&euro;</dd>
                </dl>
            </div>
            <div class="row align-items-end">
                <div class="col">
                    @include('livewire.partials.daterange')
                </div>
                <div class="col">
                    <div>
                        <div class="form-group w-100">
                            <label for="exampleFormControlSelect1">{{ trans('titles.type') }}</label>
                            <select wire:model.defer="typeSelected" class="form-control custom-select" name="user">
                                <option value="0" selected>{{ trans('titles.all-types') }}</option>
                                <option value="1">{{ trans('titles.user-to-platform') }}</option>
                                <option value="2">{{ trans('titles.platform-to-user') }}</option>
                                <option value="3">{{ trans('titles.platform-to-provider') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div>
                        <div class="form-group w-100">
                            <label for="exampleFormControlSelect1">{{ trans('titles.state') }}</label>
                            <select wire:model.defer="stateSelected" class="form-control custom-select" name="state">
                                <option selected value="null">{{ trans('titles.all') }}</option>
                                <option value="-1">{{ trans('titles.canceled') }}</option>
                                <option value="0">{{ trans('titles.pending') }}</option>
                                <option value="1">{{ trans('titles.approved') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div>
                        <div class="form-group w-100">
                            <label for="exampleFormControlSelect1">{{ trans('titles.user') }}</label>
                            <select wire:model.defer="userSelected" class="form-control custom-select" name="user">
                                <option value="0" selected>{{ trans('titles.all-users') }}</option>
                                @foreach ($users as $user)
                                    @if (!is_null($user) && $user->hasRole(['user', 'sales']))
                                        <option value="{{ $user->id }}">{{ $user->email }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div>
                        <div class="form-group">
                            <div>
                                <button wire:click="commit" class="btn btn-success w-100" id="commitData">{{ trans('titles.commit') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive-lg users-table table">
                <table class="table table-striped table-bordered col-filtered-datatable">
                    <thead class="thead">
                        <tr>
                            <th class="no-search"></th>
                            <th wire:click="sortBy('date')">
                                <span>{{ trans('titles.date') }}</span>
                                @if($sortAsc && $sortField == 'date')
                                    <i class="cil-arrow-bottom"></i>
                                @else
                                    <i class="cil-arrow-top"></i>
                                @endif
                            </th>
                            <th wire:click="filterBy('users.name')">
                                <span>{{ trans('titles.user') }}</span>
                                @if($sortAsc && $filterByModel == 'users.name')
                                    <i class="cil-arrow-bottom"></i>
                                @else
                                    <i class="cil-arrow-top"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('amount')">
                                <span>{{ trans('titles.amount') }}</span>
                                @if($sortAsc && $sortField == 'amount')
                                    <i class="cil-arrow-bottom"></i>
                                @else
                                    <i class="cil-arrow-top"></i>
                                @endif
                            </th>
                            <th>
                                <span>{{ trans('titles.details') }}</span>
                            </th>
                            <th>
                                <span>{{ trans('titles.documents') }}</span>
                            </th>
                            <th wire:click="sortBy('type')">
                                <span>{{ trans('titles.type') }}</span>
                                @if($sortAsc && $sortField == 'type')
                                    <i class="cil-arrow-bottom"></i>
                                @else
                                    <i class="cil-arrow-top"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('approved')">
                                <span>{{ trans('titles.approved') }}</span>
                                @if($sortAsc && $sortField == 'approved')
                                    <i class="cil-arrow-bottom"></i>
                                @else
                                    <i class="cil-arrow-top"></i>
                                @endif
                            </th>
                        </tr>
                    </thead>
                    <tbody id="users_table">
                        @foreach ($payments as $payment)
                            <tr>
                                <td>
                                    <div class="btn-group btn-group-xs">
										<button type="button" class="btn btn-table-action dropdown-toggle" data-toggle="dropdown">
											{{ $payment->id }}
											<i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
											<span class="sr-only">
												Actions
											</span>
										</button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if ($payment->approved == 0)
                                                {!! Form::open(['route' => ['admin.payments.updatePaymentStatus', $payment->id],
                                                'method' => 'PUT', 'role' => 'form']) !!}
                                                {!! csrf_field() !!}
                                                <button class="dropdown-item" type="submit">{{ trans('titles.approve') }}</button>
                                                {!! Form::close() !!}
                                                {!! Form::open(['route' => ['admin.payments.reject', $payment->id],
                                                'method' => 'DELETE', 'role' => 'form']) !!}
                                                {!! csrf_field() !!}
                                                <button class="dropdown-item" type="submit">{{ trans('titles.reject') }}</button>
                                                {!! Form::close() !!}
                                                <a href="{{ route('admin.payments.edit', $payment) }}" class="dropdown-item">{{ trans('titles.edit-payment') }}</a>
                                            @elseif($payment->approved == 1)
                                                <form action="{{ route('admin.payments.cancel', $payment->id) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="btn dropdown-item" type="submit">{{ trans('titles.cancel-payment') }}</button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.payments.recover', $payment->id) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="btn dropdown-item">{{ trans('titles.recover') }}</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        style="display:none;">{{ date('Y-m-d H:i:s', strtotime($payment->date)) }}</span>
                                    {{ date('d/m/Y', strtotime($payment->date)) }}
                                </td>
                                <td>
                                    @if($payment->isProvider())
                                        {{ $payment->provider->company_name }}
                                    @else
                                        {{ $payment->user->name ?? '' }}
                                    @endif
                                </td>
                                <td>
                                    {{ $payment->amount }}
                                </td>
                                <td>{{ $payment->details }}</td>
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
                                <td>
                                    @if($payment->type == 1)
                                        User to platform
                                    @elseif($payment->type == 2)
                                        Platform to user
                                    @elseif($payment->type ==3)
                                        Platform to provider
                                    @elseif($payment->type == 4)
                                        Reduced payment
                                    @endif
                                </td>
                                <td>
                                    @if($payment->approved == 1)
                                        <span class="badge bg-success">{{ trans('titles.approved') }}</span>
                                    @elseif($payment->approved == -1)
                                        <span class="badge bg-danger">{{ trans('titles.canceled') }}</span>
                                    @else
                                        <span class="badge bg-warning">{{ trans('titles.pending') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
            <div class="uk-margin-top">
                {!! Form::open(['route' => 'admin.payments.export', 'method' => 'GET', 'role' => 'form', 'class' =>
                'needs-validation uk-margin-bottom']) !!}
                {!! csrf_field() !!}
                <input type="hidden" value="{{ $from }}" name="from">
                <input type="hidden" value="{{ $to }}" name="to">
                <input type="hidden" value="{{ $userSelected }}" name="userSelected">
                <input type="hidden" value="{{ $typeSelected }}" name="typeSelected">
                <input type="hidden" value="{{ $stateSelected }}" name="stateSelected">
                {!! Form::button(trans('titles.export'), ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                {!! Form::close() !!}
            </div>

            {{ $payments->links() }}
        </div>
    </div>
</div>
<style>
    table.table {
        width: auto;
    }
    table.table-bordered th, .table-bordered td {
        width: 10%;
    }

    table.table-bordered th, .table-bordered td:last-of-type {
        width: 2%;
    }

</style>

