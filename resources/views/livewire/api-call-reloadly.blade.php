<div>
    @include('livewire.loader')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>Calls {{ date('d/m/Y', strtotime($date_begin)) }} -
                                {{ date('d/m/Y', strtotime($date_end)) }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-md-flex justify-content-between align-items-center">
                            <div class="uk-padding-small w-100">
                                <dl class="row">
                                    <dt class="col-sm-5">Operations
                                    <dt>
                                    <dd class="col-sm-7">{{ $operationsCount }}</dd>
                                    {{--                                <dt class="col-sm-5">Total User discounts--}}
                                    {{--                                <dt>--}}
                                    {{--                                <dd class="col-sm-7">{{ $operations->sum('user_discount') }} €</dd>--}}
                                    {{--                                <dt class="col-sm-5">Total Commissions--}}
                                    {{--                                <dt>--}}
                                    {{--                                <dd class="col-sm-7">{{ $operations->sum('platform_commission') }} €</dd>--}}
                                    {{--                                <dt class="col-sm-5">Total gross Plaform gains--}}
                                    {{--                                <dt>--}}
                                    {{--                                <dd class="col-sm-7">{{ $operations->sum('platform_total_gain') }} €</dd>--}}
                                </dl>
                            </div>
                            <div class="w-100">
                                <div class="col-sm">
                                    <fieldset class="form-group">
                                        <label>Search by ID</label>
                                        <div class="input-group">
                                            <input class="form-control" type="text" wire:model.defer="operationId" placeholder="Search by id..">
                                            <span class="input-group-append">
                                            <span class="input-group-text bg-primary">
                                                <button wire:click="searchById" style="border: none;outline: none; background: none;" class="cil-search btn-behance"></button>
                                            </span>
                                        </span>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
{{--                        <div class="uk-padding-small">--}}
{{--                            <dl class="row">--}}
{{--                                <dt class="col-sm-5">Operations--}}
{{--                                <dt>--}}
{{--                                <dd class="col-sm-7">{{ $operationsCount }}</dd>--}}
{{--                                <dt class="col-sm-5">Total User discounts<dt>--}}
{{--                                <dd class="col-sm-7">{{ $operations->sum('user_discount') }} €</dd>--}}
{{--                                <dt class="col-sm-5">Total Commissions<dt>--}}
{{--                                <dd class="col-sm-7">{{ $operations->sum('platform_commission') }} €</dd>--}}
{{--                                <dt class="col-sm-5">Total gross Plaform gains--}}
{{--                                <dt>--}}
{{--                                <dd class="col-sm-7">{{ $operations->sum('platform_total_gain') }} €</dd>--}}
{{--                            </dl>--}}
{{--                        </div>--}}
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
                                            @foreach ($users as $user)
                                                @if (!is_null($user))
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
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
                        <div style="overflow:auto;">
                            <table class="table table-striped table-bordered col-filtered-datatable" id="admin-table">
                                <thead>
                                    <tr>
                                        <th wire:click="sortBy('id')">
                                            <span>ID</span>
                                            @if($sortAsc && $sortField == 'id')
                                                <i class="cil-arrow-bottom"></i>
                                            @else
                                                <i class="cil-arrow-top"></i>
                                            @endif
                                        </th>
                                        <th wire:click="sortBy('created_at')">
                                            <span>Date</span>
                                            @if($sortAsc && $sortField == 'created_at')
                                                <i class="cil-arrow-bottom"></i>
                                            @else
                                                <i class="cil-arrow-top"></i>
                                            @endif
                                        </th>
                                        <th wire:click="sortBy('user_id')">
                                            <span>User</span>
                                            @if($sortAsc && $sortField == 'user_id')
                                                <i class="cil-arrow-bottom"></i>
                                            @else
                                                <i class="cil-arrow-top"></i>
                                            @endif
                                        </th>
                                        <th wire:click="sortBy('type')">
                                            <span>Type</span>
                                            @if($sortAsc && $sortField == 'type')
                                                <i class="cil-arrow-bottom"></i>
                                            @else
                                                <i class="cil-arrow-top"></i>
                                            @endif
                                        </th>
                                        <th wire:click="sortBy('path')">
                                            <span>Path</span>
                                            @if($sortAsc && $sortField == 'path')
                                                <i class="cil-arrow-bottom"></i>
                                            @else
                                                <i class="cil-arrow-top"></i>
                                            @endif
                                        </th>
                                        <th wire:click="sortBy('parameters')">
                                            <span>Parameters</span>
                                            @if($sortAsc && $sortField == 'parameters')
                                                <i class="cil-arrow-bottom"></i>
                                            @else
                                                <i class="cil-arrow-top"></i>
                                            @endif
                                        </th>
                                        <th>
                                            <span>Log</span>
                                        </th>
                                        <th>Answer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($operations->count() > 0)
                                        @foreach ($operations as $operation)
                                            <tr>
                                                <td>{{ $operation->id }}</td>
                                                <td>{{ date('d/m/Y H:i:s', strtotime($operation->created_at)) }}</td>
                                                <td>
                                                    @if(isset($operation->user->name))
                                                        {{ $operation->user->name }}
                                                    @endif
                                                </td>
                                                <td>{{ $operation->type }}</td>
                                                <td>{{ $operation->path }}</td>
                                                <td>{{ $operation->parameters }}</pre>
                                                </td>
                                                <td>{{ $operation->log }}</td>
                                                <td>{{ $operation->raw_answer }}</pre>
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
        </div>
    </div>
</div>

