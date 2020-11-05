<div class="container-fluid">
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
        </div>

        <div class="card-body">
            <div id="alert_placeholder"></div>
            <div class="table-responsive">
                <table class="table table-striped table-sm datatable">
                    <thead class="thead">
                    <tr>
                        <th>Country</th>
                        <th>Nome</th>
                        <th>Default</th>
                        <th>Ding</th>
                        <th>Reloadly</th>
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
</div>
