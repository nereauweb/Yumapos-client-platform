@extends('dashboard.base')

@section('css')
@endsection

@section('content')
	@livewireStyles()
    @livewire('services-list')
    @livewireScripts()
@endsection

@section('javascript')
	<script>
		function changeMaster(thisSelect,operatorId,master){
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
		};
		function changeDing(thisSelect,operatorId,identifier){
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
		};
		function changeReloadly(thisSelect,operatorId,identifier){
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
		};
	</script>
@endsection
