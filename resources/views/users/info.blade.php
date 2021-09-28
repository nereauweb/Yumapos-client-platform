@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
						<div class="uk-flex uk-flex-middle uk-flex-center">
							<h1>{{ trans('titles.info') }}</h1>
						</div>
                    </div>
					<div class="uk-padding">
						@if(strpos($_SERVER["SERVER_NAME"],'ping')!== false)
						<dl class="row">
							<dt class="col-sm-5">{{ trans('titles.support') }}</dt>
							<dd class="col-sm-7">
								<ul class="uk-list">
									<li><i class="c-icon cil-phone"></i> +39 3396908512 / +39 3484321116 (whatsapp)</li>
									<li><i class="c-icon cil-at"></i> playluxsrls@gmail.com </li>
								</ul>
							</dd>
						</dl>
						<dl class="row">
							<dt class="col-sm-5">{{ trans('titles.bank-details') }}</dt>
							<dd class="col-sm-7">IT06 S030 6905 1101 0000 0017 585 <br>PLAYLUX S.R.L.</dd>
						</dl>	
						@else
						<dl class="row">
							<dt class="col-sm-5">{{ trans('titles.support') }}</dt>
							<dd class="col-sm-7">
								<ul class="uk-list">
									<li><i class="c-icon cil-phone"></i> +39 391 386 4315 </li>
									<li><i class="c-icon cil-at"></i> info@yumapos.it </li>
								</ul>
							</dd>
						</dl>
						<dl class="row">
							<dt class="col-sm-5">{{ trans('titles.bank-details') }}</dt>
							<dd class="col-sm-7">IT 70 U 07601 15800 001050287018 <br>AL.MO.MA. DI MANUELA MANCARELLA & C S.A.S</dd>
						</dl>
						@endif
					</div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
@endsection
