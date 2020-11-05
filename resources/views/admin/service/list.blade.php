@extends('dashboard.base')

@section('css')
{{--    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">--}}
@endsection

@section('content')
	@livewireStyles()
    @livewire('services-list')
    @livewireScripts()

{{--    <div class="container-fluid">--}}
{{--        <div class="card">--}}
{{--            <div class="card-header">--}}

{{--                <div style="display: flex; justify-content: space-between; align-items: center;">--}}

{{--				<span id="card_title">--}}
{{--					<h1>Servizi</h1>--}}
{{--				</span>--}}

{{--                    <div class="btn-group pull-right btn-group-xs">--}}
{{--                        <div>--}}
{{--                            <a href="/admin/service/categories" class="btn btn-primary btn-save uk-margin-right">--}}
{{--                                <span class="uk-margin-small-right" uk-icon="list"></span>Categorie--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="card-body">--}}
{{--                <div id="alert_placeholder"></div>--}}
{{--                <div class="table-responsive">--}}
{{--                    <table class="table table-striped table-sm datatable">--}}
{{--                        <thead class="thead">--}}
{{--                        <tr>--}}
{{--                            <th>Country</th>--}}
{{--                            <th>Nome</th>--}}
{{--                            <th>Default</th>--}}
{{--                            <th>Ding</th>--}}
{{--                            <th>Reloadly</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                        @foreach($service_operators as $service_operator)--}}
{{--                            <tr>--}}
{{--                                <td>{{ $service_operator->country->name }}</td>--}}
{{--                                <td>{{ $service_operator->name }}</td>--}}
{{--                                <td>--}}
{{--                                    <select class="form-control form-control-sm master-select" data-id="{{ $service_operator->id }}">--}}
{{--                                        <option value="ding" {{ $service_operator->master == "ding" ? 'selected' : '' }}>Ding</option>--}}
{{--                                        <option value="reloadly" {{ $service_operator->master == "reloadly" ? 'selected' : '' }}>Reloadly</option>--}}
{{--                                    </select>--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    @if($service_operator->ding)--}}
{{--                                        {{ $service_operator->ding->Name ? $service_operator->ding->Name : 'undefined ('.$service_operator->ding_ProviderCode.')' }}--}}
{{--                                    @else--}}
{{--                                        <select class="form-control form-control-sm ding-select" data-id="{{ $service_operator->id }}">--}}
{{--                                            <option value=""></option>--}}
{{--                                            {!! $ding_operators_options !!}--}}
{{--                                        </select>--}}
{{--                                    @endif--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    @if($service_operator->reloadly)--}}
{{--                                        {{ $service_operator->reloadly->name ? $service_operator->reloadly->name : 'undefined ('.$service_operator->reloadly_operatorId.')' }}--}}
{{--                                    @else--}}
{{--                                        <select class="form-control form-control-sm reloadly-select" data-id="{{ $service_operator->id }}">--}}
{{--                                            <option value=""></option>--}}
{{--                                            {!! $reloadly_operators_options !!}--}}
{{--                                        </select>--}}
{{--                                    @endif--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                        @endforeach--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                    {!! $service_operators->links() !!}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}


@endsection

@section('javascript')
{{--	<script src="{{ asset('js/jquery.dataTables.js') }}"></script>--}}
{{--	<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>--}}
{{--	<script src="{{ asset('js/datatables.js') }}"></script>--}}
	<script>
		$(document).ready(function(){

			$(document).on('change','.master-select',function(){
				thisSelect = $(this);
				operatorId = thisSelect.data('id');
				master = thisSelect.val();
				$.ajaxSetup({
				   headers: {
					 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				   }
				});
				$.ajax({
					type: 'PUT',
					url: '/admin/service/'+operatorId+'/set-master',
					data: {
						master: master
					}
				}).done(function (response) {
					UIkit.notification({
						message: response == 'OK' ? 'Done.' : 'Update FAILED <br><small>' + response +'</small>',
						status: response == 'OK' ? 'success' : 'warning',
						pos: 'top-center',
						timeout: 15000
					});
					if (response!='OK'){
						thisSelect.val(master=='ding'?'reloadly':'ding');
					}
				}).fail(function (msg) {
					thisSelect.val(master=='ding'?'reloadly':'ding');
					UIkit.notification({
						message: 'Update FAILED <br><small>' + msg.responseText.slice(0, 500) +'</small>',
						status: 'danger',
						pos: 'top-center',
						timeout: 15000
					});
				});
			});

			$(document).on('change','.ding-select',function(){
				thisSelect = $(this);
				operatorId = $(this).data('id');
				identifier = $(this).val();
				$.ajaxSetup({
				   headers: {
					 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				   }
				});
				$.ajax({
					type: 'PUT',
					url: '/admin/service/'+operatorId+'/associate',
					data: {
						provider: 'ding',
						identifier: identifier
					}
				}).done(function (response) {
					if (response!='OK'){ thisSelect.val(""); }
					UIkit.notification({
						message: response == 'OK' ? 'Done.' : 'Update FAILED <br><small>' + response +'</small>',
						status: response == 'OK' ? 'success' : 'warning',
						pos: 'top-center',
						timeout: 15000
					});
				}).fail(function (msg) {
					thisSelect.val("");
					UIkit.notification({
						message: 'Update FAILED <br><small>' + msg.responseText.slice(0, 500) +'</small>',
						status: 'danger',
						pos: 'top-center',
						timeout: 15000
					});
				});
			});

			$(document).on('change','.reloadly-select',function(){
				thisSelect = $(this);
				operatorId = $(this).data('id');
				identifier = $(this).val();
				$.ajaxSetup({
				   headers: {
					 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				   }
				});
				$.ajax({
					type: 'PUT',
					url: '/admin/service/'+operatorId+'/associate',
					data: {
						provider: 'reloadly',
						identifier: identifier
					}
				}).done(function (response) {
					if (response!='OK'){ thisSelect.val(""); }
					UIkit.notification({
						message: response == 'OK' ? 'Done.' : 'Update FAILED <br><small>' + response +'</small>',
						status: response == 'OK' ? 'success' : 'warning',
						pos: 'top-center',
						timeout: 15000
					});
				}).fail(function (msg) {
					thisSelect.val("");
					UIkit.notification({
						message: 'Update FAILED <br><small>' + msg.responseText +'</small>',
						status: 'danger',
						pos: 'top-center',
						timeout: 15000
					});
				});
			});

		});
	</script>
@endsection
