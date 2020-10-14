@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @if (session()->has('status'))
                    <div class="alert @if(session()->get('status') == 'success') alert-success @else alert-danger @endif" role="alert">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="card" uk-height-viewport="offset-top: true, offset-bottom: true">
                    <div class="card-body">
						<div>
                            <h1 class="text-center my-5">Welcome to Yumapos</h1>
                            @if (auth()->user()->hasRole('admin'))
                            <div class="row">
                                <div class="col-6">
                                    <h2>User Details</h2>
                                    <div class="row">
                                        <div class="col-6">
                                        <div class="c-callout c-callout-info b-t-1 b-r-1 b-b-1">
                                            <small class="text-muted">All Approved users</small><br>
                                            <strong class="h4">{{ $data['totalUsersApproved'] }}</strong>
                                        </div>
                                        </div><!--/.col-->
                                        <div class="col-6">
                                        <div class="c-callout c-callout-danger b-t-1 b-r-1 b-b-1">
                                            <small class="text-muted">Users with role <strong>agent</strong></small><br>
                                            <strong class="h4">{{ $data['sales'] }}</strong>
                                        </div>
                                        </div><!--/.col-->
                                        <div class="col">
                                        <div class="c-callout c-callout-warning b-t-1 b-r-1 b-b-1">
                                            <small class="text-muted">Users waiting for approval</small><br>
                                            <strong class="h4">{{ $data['usersWaitingApproval'] }}</strong>
                                        </div>
                                        </div><!--/.col-->
                                    </div><!--/.row-->
                                    <div class="list-group mb-4">
                                        @foreach ($users as $user)
                                            <div class="list-group-item list-group-item-action">
                                                <div class="row justify-content-md-center">
                                                    <div class="col">
                                                        <span>{{  isset($user->name) ? $user->name : '' }}</span>@if($user->state == 0)<span class="badge bg-secondary ml-4">Pending</span>@endif
                                                    </div>
                                                    <div class="col-md-auto">
                                                        <div class="btn-group dropleft">
                                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            Actions
                                                            </button>
                                                            <div class="dropdown-menu">
                                                            <a href="{{ route('users.show', $user) }}" class="dropdown-item">View details</a>
                                                            @if (!$user->state)
                                                                <a href="#" class="dropdown-item">Approve</a>
                                                                <a href="#" class="dropdown-item">Reject</a>
                                                            @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    {{ $users->links() }}
                                </div>
                                <div class="col-6">
                                    <h2>Payments Details</h2>
                                    <div class="row">
                                        <div class="col-6">
                                        <div class="c-callout c-callout-info b-t-1 b-r-1 b-b-1">
                                            <small class="text-muted">All Approved payments</small><br>
                                            <strong class="h4">{{ $paymentsData['payments'] }}</strong>
                                        </div>
                                        </div><!--/.col-->
                                        <div class="col-6">
                                        <div class="c-callout c-callout-warning b-t-1 b-r-1 b-b-1">
                                            <small class="text-muted">Payments waiting for approval</small><br>
                                            <strong class="h4">{{ $paymentsData['pending'] }}</strong>
                                        </div>
                                        </div><!--/.col-->
                                        <div class="col">
                                            <div class="c-callout c-callout-warning b-t-1 b-r-1 b-b-1">
                                                <small class="text-muted">Total amounts</small><br>
                                                <strong class="h4">{{ $paymentsData['totals'] }}</strong>
                                            </div>
                                            </div>
                                    </div><!--/.row-->
                                    <div class="list-group mb-4">
                                        @foreach ($payments as $payment)
                                            <div class="list-group-item list-group-item-action">
                                                <div class="row justify-content-md-center">
                                                    <div class="col">
                                                        <div>
                                                            <span>{{  isset($payment->user->name) ? $payment->user->name : '' }}</span>@if (!$payment->approved)
                                                                <span class="badge bg-secondary ml-4">Pending</span>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <span>User balance is: {{ $payment->amount }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-auto">
                                                        <div class="btn-group dropleft">
                                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            Actions
                                                            </button>
                                                            <div class="dropdown-menu">
                                                            <a href="{{ route('users.payments.show', $payment) }}" class="dropdown-item">View details</a>
                                                            @if (isset($payment->document))
                                                                @if (!$payment->approved)
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
                                                                @else
                                                                    <a href="{{ $payment->document->filename }}" class="dropdown-item">Download file</a>
                                                                @endif
                                                            @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    {{ $payments->links() }}
                                </div>
                            </div>
                            @endif
						</div>
                    </div>
                        
					</div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
@endsection