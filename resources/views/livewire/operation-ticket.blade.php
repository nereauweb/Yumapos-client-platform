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
                        <th>{{ trans('titles.signal-status') }}</th>
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
								<td>
									<div class="btn-group btn-group-xs">
										@if ($operation->report_status)
											@if ($operation->report_status != 'rejected' && $operation->report_status != 'refunded' )
												<button type="button" class="btn btn-table-action dropdown-toggle" data-toggle="dropdown">
													{{ $operation->report_status }}
													<i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
													<span class="sr-only">
														{{ trans('titles.actions') }}
													</span>
												</button>
												<div class="dropdown-menu dropdown-menu-right">
													<button class="dropdown-item btn-success" data-toggle="modal" data-target="#modalApprove"
														wire:click="manage_ticket({{ $operation->id }}, 'rejected')">Reject</button>
													<button class="dropdown-item btn-success" data-toggle="modal" data-target="#modalApprove"
														wire:click="manage_ticket({{ $operation->id }}, 'confirmed')">Confirm</button>
													<button class="dropdown-item btn-success" data-toggle="modal" data-target="#modalApprove"
														wire:click="manage_ticket({{ $operation->id }}, 'sent')">Send</button>
													<button class="dropdown-item btn-success" data-toggle="modal" data-target="#modalApprove"
														wire:click="manage_ticket({{ $operation->id }}, 'refunded')">Refund</button>
												</div>
											@else
												<span>{{ $operation->report_status }}</span>
											@endif
										@else
											<span>{{ trans('titles.signal-ok') }}</span>
										@endif
									</div>
								</td>								
                                <td><a href="#"  onclick="details({{ $operation->id }})">{{ $operation->provider }}</a></td>
                                <td>{{ $operation->request_country_iso }}</td>
                                <td>{{ $operation->operator_name() }}</td>
                                <td>{{ $operation->request_recipient_phone }}</td>
                                <td>{{ round($operation->final_expected_destination_amount, 3) ?? '' }}&nbsp;{{ $operation->reloadly_operation->deliveredAmountCurrencyCode ?? '' }}
                                </td>
                                <td>{{ round($operation->final_amount - $operation->user_gain - $operation->sent_amount, 3) }}&nbsp;&euro;
                                </td>
                                <td>{{ $operation->agent_commission ? round($operation->agent_commission, 3) : 0 }}&nbsp;&euro;</td>
                                <td>{{ round($operation->platform_commission, 3) }}&nbsp;&euro;</td>
                                <td>{{ round($operation->platform_total_gain, 3) }}&nbsp;&euro;</td>
                                <td>{{ round($operation->user_discount, 3) }}&nbsp;&euro;</td>
                                <td>{{ round($operation->platform_total_gain - $operation->user_discount, 3) }}&nbsp;&euro;
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                {{ $operations->links() }}
            </div>
        </div>
    </div>
</div>
