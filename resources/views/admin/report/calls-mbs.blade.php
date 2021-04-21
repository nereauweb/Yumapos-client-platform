@extends('dashboard.base')

@section('content')
<div class="container-fluid">
<div style="overflow:auto;">
                            <table class="table table-striped table-bordered col-filtered-datatable" >
	<thead>
		<tr>
			<th>created at</th>
			<th>user id</th>
			<th>mbs operation id</th>
			<th>fields</th>
			<th>raw answer</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($operations as $operation)
			<tr>
				<td>{{$operation->created_at}}</td>
				<td>{{$operation->user_id}}</td>
				<td>{{$operation->operation_id}}</td>
				<td>{{$operation->fields}}</td>
				<td>{{$operation->raw_answer}}</td>
			</tr>			
		@endforeach
	</tbody>
</table>
</div>
</div>
@endsection