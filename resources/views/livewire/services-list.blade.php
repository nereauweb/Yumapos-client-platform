<div class="container-fluid">
    @include('livewire.loader')
    <div class="card">
        <div class="card-header">

            <div style="display: flex; justify-content: space-between; align-items: center;">

				<span id="card_title">
					<h1>{{ trans('titles.services') }}</h1>
				</span>

                <div class="btn-group pull-right btn-group-xs">
                    <div>
                        <a href="/admin/service/categories" class="btn btn-primary btn-save uk-margin-right">
                            <span class="uk-margin-small-right" uk-icon="list"></span>{{ trans('titles.category') }}
                        </a>
                    </div>
                </div>
            </div>
            <div>
                <div class="row">
                    <div class="col-4">
                        <select wire:model.defer="countrySelected" class="form-control">
                            <option value="0">{{ trans('titles.all-countries') }}</option>
                            @foreach($countriesList as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <button wire:click="commit" class="btn btn-success">{{ trans('titles.commit') }}</button>
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
                            <span>{{ trans('titles.country') }}</span>
                            @if($relationshipAsc && $relationshipSortField == 'country')
                                <i class="cil-arrow-bottom"></i>
                            @else
                                <i class="cil-arrow-top"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('name')">
                            <span>{{ trans('titles.name') }}</span>
                            @if($sortAsc && $sortField == 'name')
                                <i class="cil-arrow-bottom"></i>
                            @else
                                <i class="cil-arrow-top"></i>
                            @endif
                        </th>
                        <th>{{ trans('titles.default') }}</th>
                        <th wire:click="sortByRelationship('ding')">
                            <span>{{ trans('titles.ding') }}</span>
                            @if($relationshipAsc && $relationshipSortField == 'ding')
                                <i class="cil-arrow-bottom"></i>
                            @else
                                <i class="cil-arrow-top"></i>
                            @endif
                        </th>
                        <th wire:click="sortByRelationship('reloadly')">
                            <span>{{ trans('titles.reloadly') }}</span>
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
