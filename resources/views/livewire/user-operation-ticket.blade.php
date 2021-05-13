<div class="card">
    <div>
    @include('livewire.loader')
        <div class="card-header">
            <h3>Tickets</h3>
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
                        <th wire:click="sortBy('id')">
                            <span>{{ trans('titles.operation-id') }}</span>
                            @if($sortAsc && $sortField == 'id')
                                <i class="cil-arrow-bottom"></i>
                            @else
                                <i class="cil-arrow-top"></i>
                            @endif
                        </th>
                        <th>{{ trans('titles.signal-status') }}</th>
                        <th wire:click="sortBy('request_country_iso')">
                            <span>{{ trans('titles.country') }}</span>
                            @if($sortAsc && $sortField == 'request_country_iso')
                                <i class="cil-arrow-bottom"></i>
                            @else
                                <i class="cil-arrow-top"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('request_recipient_phone')">
                            <span>{{ trans('titles.phone-number') }}</span>
                            @if($sortAsc && $sortField == 'request_country_iso')
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
                                <td>{{ date('d/m/Y H:i:s', strtotime($operation->created_at)) }}</td>
                                <td>{{ $operation->id }}</td>
								<td>{{ $operation->report_status }}</td>								
                                <td>{{ $operation->request_country_iso }}</td>
                                <td>{{ $operation->request_recipient_phone }}</td>
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
