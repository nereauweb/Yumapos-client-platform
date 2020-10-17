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
                        <div class="uk-padding-small">
                            <dl class="row">
                                <dt class="col-sm-5">Operations
                                <dt>
                                <dd class="col-sm-7">{{ $operationsCount }}</dd>
                                <dt class="col-sm-5">Total User discounts
                                <dt>
                                <dd class="col-sm-7">{{ $operations->sum('user_discount') }} €</dd>
                                <dt class="col-sm-5">Total Commissions
                                <dt>
                                <dd class="col-sm-7">{{ $operations->sum('platform_commission') }} €</dd>
                                <dt class="col-sm-5">Total gross Plaform gains
                                <dt>
                                <dd class="col-sm-7">{{ $operations->sum('platform_total_gain') }} €</dd>
                                <dt class="col-sm-5">Total net Platform gains
                                <dt>
                                <dd class="col-sm-7">
                                    {{ $operations->sum('platform_total_gain') - $operations->sum('user_discount') }} €
                                </dd>
                            </dl>
                        </div>
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
                                            <svg width="20" height="20" class="w-6 h-6" fill="currentColor"
                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                                                </path>
                                            </svg>
                                        </th>
                                        <th wire:click="sortBy('created_at')">
                                            <span>Date</span>
                                            <svg width="20" height="20" class="w-6 h-6" fill="currentColor"
                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                                                </path>
                                            </svg>
                                        </th>
                                        <th wire:click="sortBy('user_id')">
                                            <span>User</span>
                                            <svg width="20" height="20" class="w-6 h-6" fill="currentColor"
                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                                                </path>
                                            </svg>
                                        </th>
                                        <th wire:click="sortBy('type')">
                                            <span>Type</span>
                                            <svg width="20" height="20" class="w-6 h-6" fill="currentColor"
                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                                                </path>
                                            </svg>
                                        </th>
                                        <th wire:click="sortBy('path')">
                                            <span>Path</span>
                                            <svg width="20" height="20" class="w-6 h-6" fill="currentColor"
                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                                                </path>
                                            </svg>
                                        </th>
                                        <th wire:click="sortBy('parameters')">
                                            <span>Parameters</span>
                                            <svg width="20" height="20" class="w-6 h-6" fill="currentColor"
                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                                                </path>
                                            </svg>
                                        </th>
                                        <th wire:click="sortBy('log')">
                                            <span>Log</span>
                                            <svg width="20" height="20" class="w-6 h-6" fill="currentColor"
                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                                                </path>
                                            </svg>
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
                                                    @if ($operation->user_id)
                                                        {{ $operation->user_id }}
                                                    @elseif($operation->user->name)
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

