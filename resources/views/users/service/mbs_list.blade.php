@extends('dashboard.base')

@section('css')
@endsection

@section('content')
	<div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>Listino MBS</h3>
                        </div>
                    </div>
                    <div class="card-body">
						<table class="table">
							<thead>
								<tr>
									<th>Prodotto</th>
									<th>Operatore</th>
									<th>Tipo</th>
									<th>SottoTipo</th>
									<th>Descrizione</th>
									<th>Prezzo Cliente</th>
									<th>Sconto Utente</th>
									<th>Prezzo Utente</th>
								</tr>
							</thead>
							<tbody>
							@foreach($products as $product)
								<tr>
									<td>{{$product->Prodotto}}</td>			
									<td>{{$product->Operatore}}</td>
									<td>{{$product->Tipo}}</td>
									<td>{{$product->SottoTipo}}</td>
									<td>{{$product->Descrizione}}</td>
									<td>{{round($product->PrezzoUtente,2)}} €</td>
									<td>{{round($product->user_discount(),2)}} %</td>
									<td>{{round($product->user_price(),2)}} €</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection