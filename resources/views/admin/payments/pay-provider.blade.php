@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    {{ trans('titles.pay-provider') }}
                    <div class="pull-right">
                        <a href="{{ url('/admin/payments/') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('providersmanagement.tooltips.back-providers') }}">
                            <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                            {{ trans('titles.rtl-payments') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                {!! Form::open(array('route' => 'admin.payProviderStore', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation', 'enctype' => 'multipart/form-data')) !!}
                {!! csrf_field() !!}
                <div class="form-group has-feedback row {{ $errors->has('date') ? ' has-error ' : '' }}">
                    {!! Form::label('date', trans('titles.date'), array('class' => 'col-md-3 control-label')); !!}
                    <div class="col-md-9">
                        <div class="input-group">
                            {!! Form::text('date', date('d m Y'), array('id' => 'date', 'class' => 'form-control', 'placeholder' => 'Date','required' => 'required')) !!}
                        </div>
                        @if ($errors->has('date'))
                            <span class="help-block">
									<strong>{{ $errors->first('date') }}</strong>
								</span>
                        @endif
                    </div>
                </div>

                <div class="form-group has-feedback row {{ $errors->has('provider_id') ? ' has-error ' : '' }}">
                    {!! Form::label('provider_id', trans('titles.provider'), array('class' => 'col-md-3 control-label','required' => 'required')); !!}
                    <div class="col-md-9">
                        <div class="input-group">
                            <select name="provider_id" id="provider_id" class="form-control">
                                @foreach($providers as $provider)
                                    <option value="{{ $provider->id }}">{{ $provider->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('provider_id'))
                            <span class="help-block">
									<strong>{{ $errors->first('provider_id') }}</strong>
								</span>
                        @endif
                    </div>
                </div>

                <div class="form-group has-feedback row {{ $errors->has('amount') ? ' has-error ' : '' }}">
                    {!! Form::label('amount', trans('titles.amount').' (€)', array('class' => 'col-md-3 control-label')); !!}
                    <div class="col-md-9">
                        <div class="input-group">
                            {!! Form::number('amount', 0, array('id' => 'amount', 'class' => 'form-control', 'min' => '0', 'step' => '0.01','required' => 'required')) !!}
                            <div class="input-group-append">
                                <label for="amount" class="input-group-text">
                                    €
                                </label>
                            </div>
                        </div>
                        @if ($errors->has('amount'))
                            <span class="help-block">
									<strong>{{ $errors->first('amount') }}</strong>
								</span>
                        @endif
                    </div>
                </div>

                <div class="form-group has-feedback row {{ $errors->has('details') ? ' has-error ' : '' }}">
                    {!! Form::label('details', trans('titles.details'), array('class' => 'col-md-3 control-label')); !!}
                    <div class="col-md-9">
                        <div class="input-group">
                            <textarea name="details" id="details" rows="5" class="form-control"></textarea>
                        </div>
                        @if ($errors->has('details'))
                            <span class="help-block">
									<strong>{{ $errors->first('details') }}</strong>
								</span>
                        @endif
                    </div>
                </div>

                <div class="form-group has-feedback row {{ $errors->has('file') ? ' has-error ' : '' }}">
                    <div class="col-md-3 control-label">
                        {{ trans('titles.file-upload') }}
                    </div>
                    <div class="col-md-9">
                        <div class="custom-file">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="document">
                                <label class="custom-file-label" for="customFile">{{ trans('titles.choose-file') }}</label>
                            </div>
                        </div>
                        @if ($errors->has('document'))
                            <span class="help-block">
									<strong>{{ $errors->first('document') }}</strong>
								</span>
                        @endif
                    </div>
                </div>

                <input type="hidden" name="type" value="3">
                <input type="hidden" name="update_balance" value="0">
                <input type="hidden" name="approved" value="1">

                {!! Form::button(trans('titles.pay-provider'), array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
                {!! Form::close() !!}
            </div>

        </div>
    </div>

@endsection

@section('javascript')
    <script src="/js/jquery.maskedinput.js" type="text/javascript"></script>
    <script type="text/javascript">
        $("#date").mask("99/99/9999");
    </script>
@endsection
