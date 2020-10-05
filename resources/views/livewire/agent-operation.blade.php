<div>
    @include('livewire.loader')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>{{ $user_name }} operations {{ date('d/m/Y', strtotime($date_begin)) }} -
                                {{ date('d/m/Y', strtotime($date_end)) }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="uk-padding-small">
                            <dl class="row">
                                <dt class="col-sm-5">Operations
                                <dt>
                                <dd class="col-sm-7">{{ $totalOperations }}</dd>
                                <dt class="col-sm-5">Total amount
                                <dt>
                                <dd class="col-sm-7">{{ $operations->sum('original_amount') }} €</dd>
                                <dt class="col-sm-5">Total commissions
                                <dt>
                                <dd class="col-sm-7">{{ $operations->sum('commission') }} €</dd>
                            </dl>
                        </div>
                        <div class="uk-grid-small my-4" uk-grid>
                            <div wire:ignore class="uk-width-expand">
                                <fieldset class="form-group">
                                    <label>DateRangePicker</label>
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="cil-calendar"></i>
                                            </span>
                                        </span>
                                        <input class="form-control" id="daterange" type="text">
                                        <input type="hidden" name="date_begin" id="date_begin">
                                        <input type="hidden" name="date_end" id="date_end">
                                    </div>
                                </fieldset>
                            </div>
                            <div class="uk-width-auto uk-flex uk-flex-bottom">
                                <button wire:click="commit" class="btn btn-success"
                                    id="commitAgentOperationBtn">Commit</button>
                            </div>
                        </div>
                        <div style="overflow:auto;">
                            <table class="table table-striped table-bordered col-filtered-datatable" id="admin-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Operation ID</th>
                                        <th>Original operation ID</th>
                                        <th>Agent</th>
                                        <th>Point</th>
                                        <th>Original amount</th>
                                        <th>Applied percentage</th>
                                        <th>Agent commission</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($operations->count() > 0)
                                        @foreach ($operations as $operation)
                                            <tr>
                                                <td>{{ $operation->created_at }}</td>
                                                <td>{{ $operation->id }}</td>
                                                <td>{{ $operation->service_operation_id }}</td>
                                                <td>{{ $operation->user->name ?? '' }}</td>
                                                <td>{{ $operation->pointOperation->user->name ?? '' }}</td>
                                                <td>{{ round($operation->original_amount, 2) }}&nbsp;&euro;</td>
                                                <td>{{ round($operation->applied_percentage, 2) }}&nbsp;%</td>
                                                <td>{{ round($operation->commission, 2) }}&nbsp;&euro;</td>
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
        </div>
    </div>
    <script>
        $('#commitAgentOperationBtn').on('click', function(e) {
            @this.set('date_begin', $("#date_begin").val());
            @this.set('date_end', $("#date_end").val());
        });

    </script>
