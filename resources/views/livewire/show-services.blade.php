<div>
    <div wire:loading class="loader">
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3>Operatori</h3>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input wire:model.lazy="search" type="text" class="form-control" id="search" placeholder="Search..">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered col-filtered-datatable" id="admin-table">
                    <thead>
                        <tr>
                            <th>Country</th>
                            <th wire:click="sortBy('operatorId')">ID</th>
                            <th wire:click="sortBy('name')">Name</th>
                            <th wire:click="sortBy('denominationType')">Type</th>
                            <th>FX currency</th>
                            <th>FX rate</th>
                            <th wire:click="sortBy('commission')">Commission&nbsp;(€)</th>
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
<style>
.loader {
    position:fixed;
    width:100%;
    left:0;right:0;top:0;bottom:0;
    background-color: rgba(255,255,255,0.7);
    z-index:9999;
    display:none;
}

@-webkit-keyframes spin {
	from {-webkit-transform:rotate(0deg);}
	to {-webkit-transform:rotate(360deg);}
}

@keyframes spin {
	from {transform:rotate(0deg);}
	to {transform:rotate(360deg);}
}

.loader::after {
    content:'';
    display:block;
    position:absolute;
    left:48%;top:40%;
    width:40px;height:40px;
    border-style:solid;
    border-color:black;
    border-top-color:transparent;
    border-width: 4px;
    border-radius:50%;
    -webkit-animation: spin .8s linear infinite;
    animation: spin .8s linear infinite;
}
</style>