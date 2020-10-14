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
                {{-- <div class="col-md-4">
                    <div class="input-group">
                        <input wire:model.defer="search" type="text" class="form-control" placeholder="search"
                            aria-label="search" id="search" aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn {{ $search == '' ? 'btn-primary' : 'btn-danger' }}" type="button"
                                id="button-addon2"
                                wire:click="{{ $search == '' ? 'search()' : 'resetSearch()' }}">{{ $search == '' ? 'Search' : 'Reset' }}</button>
                        </div>
                    </div>
                </div> --}}
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
                            <th wire:click="filter('country.name')"><span class="mr-4">Country</span>
                                <svg width="20" height="20" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                                    </path>
                                </svg>
                            </th>
                            <th wire:click="sortBy('operatorId')"><span class="mr-4">ID</span>
                                <svg width="20" height="20" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                                    </path>
                                </svg>
                            </th>
                            <th wire:click="sortBy('name')"><span class="mr-4">Name</span>
                                <svg width="20" height="20" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                                    </path>
                                </svg>
                            </th>
                            <th wire:click="sortBy('denominationType')"><span class="mr-4">Type</span>
                                <svg width="20" height="20" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                                    </path>
                                </svg>
                            </th>
                            <th wire:click="filter('fx.currencyCode')"><span class="mr-4">FX currency</span>
                                <svg width="20" height="20" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                                    </path>
                                </svg>
                            </th>
                            <th wire:click="filter('fx.rate')"><span class="mr-4">FX rate</span>
                                <svg width="20" height="20" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                                    </path>
                                </svg>
                            </th>
                            <th wire:click="sortBy('commission')"><span class="mr-4">Commission&nbsp;(€)</span>
                                <svg width="20" height="20" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                                    </path>
                                </svg>
                            </th>
                            <th class="no-search">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($operators as $operator)
                            <tr>
                                <td>{{ $operator->country->name }} ({{ $operator->country->isoName }})</td>
                                <td>{{ $operator->operatorId }}</td>
                                <td>{{ $operator->name }}</td>
                                <td>{{ $operator->denominationType }}</td>
                                <td>{{ $operator->fx->currencyCode }}</td>
                                <td>{{ $operator->fx->rate }}</td>
                                <td>{{ $operator->commission }}</td>
                                <td>
                                    <div class="uk-width-small">
                                        <a class="btn btn-success details" href="#"
                                            data-operator-id="{{ $operator->id }}">
                                            <svg class="c-icon">
                                                <use
                                                    xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-magnifying-glass">
                                                </use>
                                            </svg>
                                        </a>
                                        <a class="btn btn-info edit" href="#" data-operator-id="{{ $operator->id }}">
                                            <svg class="c-icon">
                                                <use
                                                    xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-description">
                                                </use>
                                            </svg>
                                        </a>
                                        @if ($operator->denominationType == 'FIXED' && $operator->localFixedAmounts->count() > 0)
                                            <a class="btn btn-info edit-local" href="#"
                                                data-operator-id="{{ $operator->id }}">
                                                <svg class="c-icon">
                                                    <use
                                                        xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-description">
                                                    </use>
                                                </svg>
                                            </a>
                                        @endif

                                        {{-- <a class="btn btn-danger" href="#">
                                            <svg class="c-icon">
                                                <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-trash">
                                                </use>
                                            </svg>
                                        </a> --}}

                                    </div>
                                </td>
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
