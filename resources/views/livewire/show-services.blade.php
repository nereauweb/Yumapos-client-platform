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
                    <div class="uk-width-expand">
                        <fieldset>
                            <label>Date range</label>
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="cil-calendar"></i>
                                    </span>
                                </span>
                                <input class="form-control" id="daterange" type="text">
                                <input type="hidden" id="date_begin">
                                <input type="hidden" id="date_end">
                            </div>
                        </fieldset>
                    </div>
                    <div>
                        <select wire:model.defer="countryName" name="countryName" id="countryId" class="custom-select">
                            <option value="-">All countries</option>
                            @foreach ($countriesList as $item)
                                <option value="{{$item->name}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select wire:model.defer="type" name="typesList" id="typesId" class="custom-select">
                            <option value="-">Every typye</option>
                            @foreach ($typesList as $item)
                                <option value="{{$item->denominationType}}">{{$item->denominationType}}</option>
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
                            <th wire:click="filter('country.name')">
                                <span class="mr-4">Country</span>
                                @if($sortAscCustom && $customSort == 'country.name')
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
                            <th wire:click="filter('fx.currencyCode')">
                                <span class="mr-4">FX currency</span>
                                @if($sortAscCustom && $customSort == 'fx.currencyCode')
                                    <i class="cil-arrow-bottom"></i>
                                @else
                                    <i class="cil-arrow-top"></i>
                                @endif
                            </th>
                            <th wire:click="filter('fx.rate')"><span class="mr-4">FX rate</span>
                                @if($sortAscCustom && $customSort == 'fx.rate')
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
                        @foreach ($operators as $operator)
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
                                                <a class="btn btn-success details dropdown-item" href="#"
                                                   data-operator-id="{{ $operator->id }}">
                                                    <svg class="c-icon">
                                                        <use
                                                            xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-magnifying-glass">
                                                        </use>
                                                    </svg>
                                                </a>
                                                <a class="btn btn-info edit dropdown-item" href="#" data-operator-id="{{ $operator->id }}">
                                                    <svg class="c-icon">
                                                        <use
                                                            xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-description">
                                                        </use>
                                                    </svg>
                                                </a>
                                                @if ($operator->denominationType == 'FIXED' && $operator->localFixedAmounts->count() > 0)
                                                    <a class="btn btn-info edit-local dropdown-item" href="#"
                                                       data-operator-id="{{ $operator->id }}">
                                                        <svg class="c-icon">
                                                            <use
                                                                xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-description">
                                                            </use>
                                                        </svg>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $operator->country->name }} ({{ $operator->country->isoName }})</td>
                                <td>{{ $operator->name }}</td>
                                <td>{{ $operator->denominationType }}</td>
                                <td>{{ $operator->fx->currencyCode }}</td>
                                <td>{{ $operator->fx->rate }}</td>
                                <td>{{ $operator->commission }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $operators->links() }}
            </div>
        </div>
    </div>
</div>
<script>
    $('#commitBtn').on('click', function(e) {
        @this.set('start', $("#date_begin").val());
        @this.set('end', $("#date_end").val());
    });
</script>
