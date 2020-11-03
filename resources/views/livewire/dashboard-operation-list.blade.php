<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                        Traffic &amp; Sales
                    </div>
                    <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                        <div class="d-flex">
                            <div class="btn-group btn-group-toggle mx-3" data-toggle="buttons">
                                <label class="btn btn-outline-secondary {{ $filterSelected == 'day' ? 'active' : '' }}">
                                    <input wire:model="filterSelected" value="day" name="filterSelectedOperation" type="radio" autocomplete="off" checked> Day
                                </label>
                                <label class="btn btn-outline-secondary {{ $filterSelected == 'yesterday' ? 'active' : '' }}">
                                    <input wire:model="filterSelected" value="yesterday" name="filterSelectedOperation" type="radio" autocomplete="off"> Yesterday
                                </label>
                                <label class="btn btn-outline-secondary {{ $filterSelected == 'week' ? 'active' : '' }}">
                                    <input wire:model="filterSelected" value="week" name="filterSelectedOperation" type="radio" autocomplete="off"> Week
                                </label>
                                <label class="btn btn-outline-secondary {{ $filterSelected == 'month' ? 'active' : '' }}">
                                    <input wire:model="filterSelected" value="month" name="filterSelectedOperation" type="radio" autocomplete="off"> Month
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-6">
                                <div class="c-callout c-callout-info"><small class="text-muted">New Clients</small>
                                    <div class="text-value-lg">9,123</div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="c-callout c-callout-danger"><small class="text-muted">Recuring Clients</small>
                                    <div class="text-value-lg">22,643</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <table class="table table-responsive-sm table-hover table-outline mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th class="text-center">
                            <svg class="c-icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-people"></use>
                            </svg>
                        </th>
                        <th>User</th>
                        <th>Amount</th>
                        <th>Cost</th>
                        <th>Gain</th>
                        <th>Country</th>
                        <th>Operator</th>
                        <th>Provider</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($services as $service)
                        <tr>
                            <td class="text-center">
                                {{ date('d/m/Y h:s', strtotime($service->created_at)) }}
                            </td>
                            <td>
                                <div>{{ $service->user->name ?? '' }}</div>
                                @if(!is_null($service->user->operative_seat_city))
                                    <div class="small text-muted">{{ $service->user->operative_seat_city }}</div>
                                @endif
                            </td>
                            <td>
                                <div>
                                    {{ $service->sent_amount }}
                                </div>
                            </td>
                            <td>
                                {{ $service->sent_amount - $service->platform_commission }}
                            </td>
                            <td>
                                {{ $service->platform_total_gain - $service->user_discount }}
                            </td>
                            <td>
                                {{ $service->operator->country->name }}
                            </td>
                            <td>
                                {{ $service->operator->name }}
                            </td>
                            <td>
                                // todo show provider
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
