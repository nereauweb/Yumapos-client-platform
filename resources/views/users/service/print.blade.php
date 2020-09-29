<!doctype html>

<html lang="en">
	<head>
	  <meta charset="utf-8">
	  <title>Yumapos receipt</title>
	  <meta name="author" content="Yumapos">
	  <!-- UIkit CSS -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/css/uikit.min.css" />

		<!-- UIkit JS -->
		<script src="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/js/uikit.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/js/uikit-icons.min.js"></script>
	</head>	
	<style>
		body{
			text-align:left;
			font-size: 14px;
		}
	</style>
	<body class="uk-margin">
		<table class="uk-table uk-table-small uk-text-left uk-width-auto">
		  <thead>
			<tr>
				<th colspan="2">
					<hr>
					<h3 class="uk-margin-remove">{{ Auth::user()->company_data->shop_sign }}</h3>
					<hr>
				</th>
			</tr>
			<tr>
				<th>Ragione sociale</th>
				<td>
				  <div class="content">{{ Auth::user()->company_data->company_name }}</div>
				</td>
			</tr>
			<tr>
				<th>Indirizzo</th>
				<td>{{ Auth::user()->company_data->operative_seat_address }} <br>					
					{{ Auth::user()->company_data->operative_seat_zip }} {{ Auth::user()->company_data->operative_seat_city }}</td>
			</tr>
			<tr>
				<th>P.IVA</th>
				<td>{{ Auth::user()->company_data->vat }} </td>
			</tr>
		  <tbody>
			<tr>
				<th colspan="2">
					<hr>
					<h3 class="uk-margin-remove">Ricevuta ricarica</h3>
					<hr>
				</th>
			</tr>
			<tr>
				<th>ID Operazione</th>
				<td>{{ $operation->id }}</td>
			</tr>
			<tr>
				<th>Data operazione</th>
				<td>{{ date("d/m/Y H:i:s", strtotime($operation->created_at)) }}</td>
			</tr>
			<tr>
				<th>Operatore</th>
				<td>{{ $operation->operator->name }}</td>
			</tr>
			<tr>
				<th>Paese</th>
				<td>{{ $operation->operator->country->name }}</td>
			</tr>
			<tr>
				<th>Numero telefonico</th>
				<td>{{ $operation->request_recipient_phone }}</td>
			</tr>
			<tr>
				<th>Costo operazione</th>
				<td>{{ round($operation->final_amount,2) }} &euro;</td>
			</tr>
			<tr>
				<th>Ricarica stimata</th>
				<td>{{ round($operation->final_expected_destination_amount,2) }} {{ $operation->operator->	destinationCurrencySymbol }}</td>
			</tr>
			<tr>
				<th>Stato</th>
				<td>OK</td>
			</tr>
		  </tbody>
		  <tfoot>
			<tr>
				<td colspan="2">
				  <div class="footer"><br><br>Print time {{ date("d/m/Y H:i:s") }}</div>
				</td>
			</tr>
		  </tfoot>
		</table>  
	</body>
</html>