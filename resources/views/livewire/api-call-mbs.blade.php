<div>
    @include('livewire.loader')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>{{ trans('titles.call') }} {{ date('d/m/Y', strtotime($date_begin)) }} -
                                {{ date('d/m/Y', strtotime($date_end)) }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-md-flex justify-content-between align-items-center">
                            <div class="uk-padding-small w-100">
                                <dl class="row">
                                    <dt class="col-sm-5">{{ trans('titles.operations') }}
                                    <dt>
                                    <dd class="col-sm-7">{{ $operationsCount }}</dd>
                                </dl>
                            </div>
                            <div class="w-100">
                                <div class="col-sm">
                                    <fieldset class="form-group">
                                        <label>{{ trans('titles.search-by-id') }}</label>
                                        <div class="input-group">
                                            <input class="form-control" type="text" wire:model.defer="operationId" placeholder="{{ trans('placeholders.search-by-id') }}">
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
                        <div class="row align-items-end">
                            <div class="col-6">
                                @include('livewire.partials.daterange')
                            </div>
                            <div class="col-4">
                                <div>
                                    <div class="form-group w-100">
                                        <label for="exampleFormControlSelect1">{{ trans('titles.user') }}</label>
                                        <select wire:model.defer="userSelected" class="form-control custom-select" name="user">
                                            <option value="0" selected>{{ trans('titles.all-users') }}</option>
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
                                            <button wire:click="commit" class="btn btn-success" id="commitData">{{ trans('titles.commit') }}</button>
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
                                            <span>{{ trans('titles.id') }}</span>
                                            @if($sortAsc && $sortField == 'id')
                                                <i class="cil-arrow-bottom"></i>
                                            @else
                                                <i class="cil-arrow-top"></i>
                                            @endif
                                        </th>
                                        <th wire:click="sortBy('created_at')">
                                            <span>{{ trans('titles.date') }}</span>
                                            @if($sortAsc && $sortField == 'created_at')
                                                <i class="cil-arrow-bottom"></i>
                                            @else
                                                <i class="cil-arrow-top"></i>
                                            @endif
                                        </th>
                                        <th wire:click="sortBy('user_id')">
                                            <span>{{ trans('titles.user') }}</span>
                                            @if($sortAsc && $sortField == 'user_id')
                                                <i class="cil-arrow-bottom"></i>
                                            @else
                                                <i class="cil-arrow-top"></i>
                                            @endif
                                        </th>
                                        <th wire:click="sortBy('fields')">
                                            <span>{{ trans('titles.fields') }}</span>
                                            @if($sortAsc && $sortField == 'fields')
                                                <i class="cil-arrow-bottom"></i>
                                            @else
                                                <i class="cil-arrow-top"></i>
                                            @endif
                                        </th>
                                        <th>
                                            <span>{{ trans('titles.log') }}</span>
                                        </th>
                                        <th>{{ trans('titles.answer') }}</th>
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
                                                <td>{{ $operation->fields }}</td>
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

