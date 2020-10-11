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
            <div class="row align-items-end">
                <div class="col-6">
                    @include('livewire.partials.daterange')
                </div>
                <div class="col-4">
                    <div>
                        <div class="form-group w-100">
                            <label for="exampleFormControlSelect1">User</label>
                            <select wire:model.defer="userSelected" class="form-control custom-select" name="user">
                                <option value="0" selected>All users</option>
                                @foreach ($payments as $payment)
                                    @if (!is_null($payment->user))
                                        <option value="{{ $payment->user->id }}">{{ $payment->user->name }}</option>
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
                                <button wire:click="commit" class="btn btn-success" id="commitData">Commit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive-lg users-table table">
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
                                    <div class="btn-group dropleft">
                                        <button type="button" class="btn dropdown-toggle"
                                            data-toggle="dropdown" aria-expanded="false">
                                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                                        </button>
                                        <div class="dropdown-menu">
                                            @if ($payment->approved == 0)
                                                {!! Form::open(['route' => ['admin.payments.updatePaymentStatus', $payment->id],
                                                'method' => 'PUT', 'role' => 'form']) !!}
                                                {!! csrf_field() !!}
                                                <button class="dropdown-item" type="submit">Approve</button>
                                                {!! Form::close() !!}
                                                {!! Form::open(['route' => ['admin.payments.destroy', $payment->id],
                                                'method' => 'DELETE', 'role' => 'form']) !!}
                                                {!! csrf_field() !!}
                                                <button class="dropdown-item" type="submit">Reject</button>
                                                {!! Form::close() !!}
                                                <a class="dropdown-item" type="button">View details</a>
                                            @else
                                                <a href="{{ route('admin.payments.edit', $payment->id) }}" class="dropdown-item" type="button">Edit payment</a>
                                                <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="dropdown-item" type="submit">Remove payment</button>
                                                </form>
                                            @endif
                                            @if (isset($payment->document))
                                                <a href="{{ url($payment->document->filename) }}" class="dropdown-item" type="button">Download file</a>
                                            @endif
                                        </div>
                                    </div>
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
<script>
    $('#commitData').on('click', () => {
        @this.set('from', $("#date_begin").val());
        @this.set('to', $("#date_end").val());
    });

</script>
