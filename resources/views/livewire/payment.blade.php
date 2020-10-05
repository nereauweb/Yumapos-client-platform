<div>
    @include('livewire.loader')
    <div class="card">
        <div class="card-header">

            <div style="display: flex; justify-content: space-between; align-items: center;">

                <span id="card_title">
                    Payments
                </span>

                <div class="btn-group pull-right btn-group-xs">
                    <a class="dropdown-item" href="/admin/payments/create">
                        <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                        Add payment
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">

            <h1>Payments</h1>

            <div class="table-responsive users-table table">
                <table class="table table-striped table-bordered col-filtered-datatable">
                    <thead class="thead">
                        <tr>
                            <th wire:click="sortBy('date')">
                                <span>Date</span>
                                <svg width="20" height="20" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                                    </path>
                                </svg>
                            </th>
                            <th wire:click="filterBy('users.name')">
                                <span>User</span>
                                <svg width="20" height="20" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                                    </path>
                                </svg>
                            </th>
                            <th wire:click="sortBy('amount')">
                                <span>Amount</span>
                                <svg width="20" height="20" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                                    </path>
                                </svg>
                            </th>
                            <th wire:click="sortBy('details')">
                                <span>Details</span>
                                <svg width="20" height="20" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                                    </path>
                                </svg>
                            </th>
                            <th wire:click="sortBy('approved')">
                                <span>Approved</span>
                                <svg width="20" height="20" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                                    </path>
                                </svg>
                            </th>
                            <th class="no-search">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="users_table">
                        @foreach ($payments as $payment)
                            <tr>
                                <td>
                                    <span
                                        style="display:none;">{{ date('Y-m-d H:i:s', strtotime($payment->date)) }}</span>
                                    {{ date('d/m/Y', strtotime($payment->date)) }}
                                </td>
                                <td>{{ $payment->user->name ?? '' }}</td>
                                <td>{{ $payment->amount }}</td>
                                <td>{{ $payment->details }}</td>
                                <td>{!! $payment->approved == 1
                                    ? '<i class="cil-check-alt"></i>'
                                    : '<i class="cil-x"></i>' !!}</td>
                                <td>
                                    @if ($payment->approved == 0)
                                        {!! Form::open(['route' => ['admin.payments.update', $payment->id], 'method' =>
                                        'PUT', 'role' => 'form', 'class' => 'needs-validation']) !!}
                                        {!! csrf_field() !!}
                                        <button class="btn btn-sm btn-success" type="submit">Approve</button>
                                        {!! Form::close() !!}
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
                {!! Form::button('Export', ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                {!! Form::close() !!}
            </div>

            {{ $payments->links() }}
        </div>
    </div>
</div>
