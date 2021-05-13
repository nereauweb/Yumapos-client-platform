<!doctype html>

<html lang="en">
	<head>
	  <meta charset="utf-8">
	  <title>{{ trans('titles.yumaps-receipt') }}</title>
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
			font-size: 11px;
		}
		.uk-table th{
			font-size: 11px;
		}
		.uk-table tfoot{
			font-size: 9px;
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
				<th>{{ trans('titles.social-region') }}</th>
				<td>
				  <div class="content">{{ Auth::user()->company_data->company_name }}</div>
				</td>
			</tr>
			<tr>
				<th>{{ trans('titles.address') }}</th>
				<td>{{ Auth::user()->company_data->operative_seat_address }} <br>
					{{ Auth::user()->company_data->operative_seat_zip }} {{ Auth::user()->company_data->operative_seat_city }}</td>
			</tr>
			<tr>
				<th>{{ trans('titles.postal-code') }}</th>
				<td>{{ Auth::user()->company_data->vat }} </td>
			</tr>
		  <tbody>
			<tr>
				<th colspan="2">
					<hr>
					<h3 class="uk-margin-remove">{{ trans('titles.refill-receipt') }}</h3>
					<hr>
				</th>
			</tr>
			<tr>
				<th>{{ trans('titles.operation-id') }}</th>
				<td>{{ $operation->id }}</td>
			</tr>
			<tr>
				<th>{{ trans('titles.operation-date') }}</th>
				<td>{{ date("d/m/Y H:i:s", strtotime($operation->created_at)) }}</td>
			</tr>
			<tr>
				<th>{{ trans('titles.operator') }}</th>
				<td>{{ $operation->operator_name() }}</td>
			</tr>
			<tr>
				<th>{{ trans('titles.country') }}</th>
				<td>{{ $operation->country_name() }}</td>
			</tr>
			<tr>
				<th>{{ trans('titles.phone-number') }}</th>
				<td>{{ $operation->request_recipient_phone }}</td>
			</tr>
			<tr>
				<th>{{ trans('titles.final-amount') }}</th>
				<td>{{ round($operation->final_amount,2) }} &euro;</td>
			</tr>
			<tr>
				<th>{{ trans('titles.estimated-recharge') }}</th>
				<td>{{ round($operation->final_expected_destination_amount,2) }} {{ $operation->destination_currency_symbol() }}</td>
			</tr>
			<tr>
				<th>{{ trans('titles.state') }}</th>
				<td>OK</td>
			</tr>
			@if($operation->pin)
				<tr>
					<th>PIN</th>
					<td>{{ $operation->pin }}</td>
				</tr>
			@endif
		  </tbody>
		  <tfoot>
			<tr>
				<td colspan="2">
				  <div class="footer"><br><br>{{ trans('titles.print-time') }} {{ date("d/m/Y H:i:s") }}</div>
				</td>
			</tr>
		  </tfoot>
		</table>
	</body>
</html>
