<div class="container-fluid">
    @include('livewire.loader')
    <div class="card">
        <div class="card-header">

            <div style="display: flex; justify-content: space-between; align-items: center;">

				<span id="card_title">
					<h1>Servizi</h1>
				</span>

                <div class="btn-group pull-right btn-group-xs">
                    <div>
                        <a href="/admin/service/categories" class="btn btn-primary btn-save uk-margin-right">
                            <span class="uk-margin-small-right" uk-icon="list"></span>Categorie
                        </a>
                    </div>
                </div>
            </div>
            <div>
                <div class="row">
                    <div class="col-4">
                        <select wire:model.defer="countrySelected" class="form-control">
                            <option value="0">All countries</option>
                            @foreach($countriesList as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <button wire:click="commit" class="btn btn-success">Commit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="alert_placeholder"></div>
            <div class="table">
                <table class="table table-striped">
                    <thead class="thead">
                    <tr>
                        <th wire:click="sortByRelationship('country')">
                            <span>Country</span>
                            @if($relationshipAsc && $relationshipSortField == 'country')
                                <i class="cil-arrow-bottom"></i>
                            @else
                                <i class="cil-arrow-top"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('name')">
                            <span>Nome</span>
                            @if($sortAsc && $sortField == 'name')
                                <i class="cil-arrow-bottom"></i>
                            @else
                                <i class="cil-arrow-top"></i>
                            @endif
                        </th>
                        <th>Default</th>
                        <th wire:click="sortByRelationship('ding')">
                            <span>Ding</span>
                            @if($relationshipAsc && $relationshipSortField == 'ding')
                                <i class="cil-arrow-bottom"></i>
                            @else
                                <i class="cil-arrow-top"></i>
                            @endif
                        </th>
                        <th wire:click="sortByRelationship('reloadly')">
                            <span>Reloadly</span>
                            @if($relationshipAsc && $relationshipSortField == 'reloadly')
                                <i class="cil-arrow-bottom"></i>
                            @else
                                <i class="cil-arrow-top"></i>
                            @endif
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($service_operators as $service_operator)
                        <tr>
                            <td>{{ $service_operator->country->name }}</td>
                            <td>{{ $service_operator->name }}</td>
                            <td>
                                <select class="form-control form-control-sm master-select" data-id="{{ $service_operator->id }}">
                                    <option value="ding" {{ $service_operator->master == "ding" ? 'selected' : '' }}>Ding</option>
                                    <option value="reloadly" {{ $service_operator->master == "reloadly" ? 'selected' : '' }}>Reloadly</option>
                                </select>
                            </td>
                            <td>
                                @if($service_operator->ding)
                                    {{ $service_operator->ding->Name ? $service_operator->ding->Name : 'undefined ('.$service_operator->ding_ProviderCode.')' }}
                                @else
{{--                                    <select class="form-control form-control-sm ding-select" data-id="{{ $service_operator->id }}">--}}
{{--                                        <option value=""></option>--}}
{{--                                        {!! $ding_operators_options !!}--}}
{{--                                    </select>--}}
                                @endif
                            </td>
                            <td>
                                @if($service_operator->reloadly)
                                    {{ $service_operator->reloadly->name ? $service_operator->reloadly->name : 'undefined ('.$service_operator->reloadly_operatorId.')' }}
                                @else
{{--                                    <select class="form-control form-control-sm reloadly-select" data-id="{{ $service_operator->id }}">--}}
{{--                                        <option value=""></option>--}}
{{--                                        {!! $reloadly_operators_options !!}--}}
{{--                                    </select>--}}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $service_operators->links() !!}
            </div>
        </div>
    </div>
    <style>
        th > span {
            cursor:pointer;
        }
    </style>
</div>
