@extends('dashboard.errorBase')

@section('content')

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="clearfix">
            <h1 class="float-left display-3 mr-4">403</h1>
            <h4 class="pt-3">Non autorizzato.</h4>
            <p class="text-muted">Non sei autorizzato a visualizzare questa pagina, oppure la tua sessione è scaduta.</p>
          </div>
		  <div class="uk-text-center">
			Sarai riportato alla pagina iniziale in <span id="not_found_counter">3</span> secondi...
		  </div>
        </div>
      </div>
    </div>

@endsection

@section('javascript')
<script type="text/javascript">
	$(document).ready(function(){
		t = 3;
		var countdown = setInterval(function () {
			$('#not_found_counter').html(t);
			t -= 1;
			if (t<0) {
				clearInterval(countdown);
				window.open('/', "_self");
			}
		},1000);		
	});	
</script>
@endsection