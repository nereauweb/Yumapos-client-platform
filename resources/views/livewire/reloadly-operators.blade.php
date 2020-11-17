<div>
    @include('livewire.loader')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3>Operatori</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="uk-grid-small my-4 d-flex align-items-end" uk-grid>
                    <div>
                        <select wire:model.defer="countryName" name="countryName" id="countryId" class="custom-select">
                            <option value="0">All countries</option>
                            @foreach ($countries as $item)
                                <option value="{{$item->name}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group-append">
                        <button wire:click="commit" class="btn btn-success" type="button"
                            id="commitBtn">Commit</button>
                    </div>
                </div>
                <table class="table table-striped table-bordered col-filtered-datatable" id="admin-table">
                    <thead>
                        <tr class="cursorPointer">
                            <th wire:click="sortBy('operatorId')">
                                <span class="mr-4">ID</span>
                                @if($sortAsc && $sortField == 'operatorId')
                                    <i class="cil-arrow-bottom"></i>
                                @else
                                    <i class="cil-arrow-top"></i>
                                @endif
                            </th>
                            <th wire:click="filter('countryName')">
                                <span class="mr-4">Country</span>
                                @if($sortAscCustom && $customSort == 'countryName')
                                    <i class="cil-arrow-bottom"></i>
                                @else
                                    <i class="cil-arrow-top"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('name')"><span class="mr-4">Name</span>
                                @if($sortAsc && $sortField == 'name')
                                    <i class="cil-arrow-bottom"></i>
                                @else
                                    <i class="cil-arrow-top"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('denominationType')">
                                <span class="mr-4">Type</span>
                                @if($sortAsc && $sortField == 'denominationType')
                                    <i class="cil-arrow-bottom"></i>
                                @else
                                    <i class="cil-arrow-top"></i>
                                @endif
                            </th>
                            <th wire:click="filter('currencyCode')">
                                <span class="mr-4">FX currency</span>
                                @if($sortAscCustom && $customSort == 'currencyCode')
                                    <i class="cil-arrow-bottom"></i>
                                @else
                                    <i class="cil-arrow-top"></i>
                                @endif
                            </th>
                            <th wire:click="filter('rate')"><span class="mr-4">FX rate</span>
                                @if($sortAscCustom && $customSort == 'rate')
                                    <i class="cil-arrow-bottom"></i>
                                @else
                                    <i class="cil-arrow-top"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('commission')">
                                <span class="mr-4">Commission&nbsp;(€)</span>
                                @if($sortAsc && $sortField == 'commission')
                                    <i class="cil-arrow-bottom"></i>
                                @else
                                    <i class="cil-arrow-top"></i>
                                @endif
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($livewireOperators->unique() as $operator)
                            <tr>
                                <td>
                                    <div class="btn-group btn-group-xs">
                                        <button type="button" class="btn btn-table-action dropdown-toggle" data-toggle="dropdown">
                                            {{ $operator->operatorId }}
                                            <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                            <span class="sr-only">
									            Actions
								            </span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <div class="uk-width-small">
                                                <a class="btn btn-success details dropdown-item" onclick="details({{ $operator->id }})">
                                                    <svg class="c-icon">
                                                        <use
                                                            xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-magnifying-glass">
                                                        </use>
                                                    </svg>
													<span>Details</span>
                                                </a>
                                                <a class="btn btn-info edit dropdown-item" href="#" onclick="edit({{ $operator->id }})">
                                                    <svg class="c-icon">
                                                        <use
                                                            xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-description">
                                                        </use>
                                                    </svg>
													<span>Edit<span>
                                                </a>
                                                @if ($operator->denominationType == 'FIXED' && $operator->localFixedAmounts->count() > 0)
                                                    <a class="btn btn-info edit-local dropdown-item" onclick="editLocal({{ $operator->id }})">
                                                        <svg class="c-icon">
                                                            <use
                                                                xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-description">
                                                            </use>
                                                        </svg>
														<span>Edit local</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $operator->countryName }} ({{ $operator->isoName }})</td>
                                <td>{{ $operator->name }}</td>
                                <td>{{ $operator->denominationType }}</td>
                                <td>{{ $operator->currencyCode }}</td>
                                <td>{{ $operator->rate }}</td>
                                <td>{{ $operator->commission }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $livewireOperators->links() }}
            </div>
        </div>
    </div>
</div>
