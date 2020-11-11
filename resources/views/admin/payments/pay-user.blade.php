@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    Pay user
                    <div class="pull-right">
                        <a href="{{ url('/admin/payments/') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('usersmanagement.tooltips.back-users') }}">
                            <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                            Return to payments list
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                {!! Form::open(array('route' => 'admin.payments.payUserStore', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation', 'enctype' => 'multipart/form-data')) !!}
                {!! csrf_field() !!}
                <div class="form-group has-feedback row {{ $errors->has('date') ? ' has-error ' : '' }}">
                    {!! Form::label('date', 'Date', array('class' => 'col-md-3 control-label')); !!}
                    <div class="col-md-9">
                        <div class="input-group">
                            {!! Form::text('date', date('d m Y'), array('id' => 'date', 'class' => 'form-control','required' => 'required')) !!}
                        </div>
                        @if ($errors->has('date'))
                            <span class="help-block">
									<strong>{{ $errors->first('date') }}</strong>
								</span>
                        @endif
                    </div>
                </div>

                <div class="form-group has-feedback row {{ $errors->has('user_id') ? ' has-error ' : '' }}">
                    {!! Form::label('user_id', 'User', array('class' => 'col-md-3 control-label','required' => 'required')); !!}
                    <div class="col-md-9">
                        <div class="input-group">
                            {!! Form::select('user_id', $users, NULL, array('class' => 'custom-select')); !!}
                        </div>
                        @if ($errors->has('user_id'))
                            <span class="help-block">
									<strong>{{ $errors->first('user_id') }}</strong>
								</span>
                        @endif
                    </div>
                </div>

                <div class="form-group has-feedback row {{ $errors->has('amount') ? ' has-error ' : '' }}">
                    {!! Form::label('amount', 'Amount (€)', array('class' => 'col-md-3 control-label')); !!}
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
                    {!! Form::label('details', 'Details', array('class' => 'col-md-3 control-label')); !!}
                    <div class="col-md-9">
                        <div class="input-group">
                            {!! Form::text('details', NULL, array('id' => 'details', 'class' => 'form-control', 'placeholder' => 'Add payment details')) !!}
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
                        File upload
                    </div>
                    <div class="col-md-9">
                        <div class="custom-file">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="document">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        @if ($errors->has('document'))
                            <span class="help-block">
									<strong>{{ $errors->first('document') }}</strong>
								</span>
                        @endif
                    </div>
                </div>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="updateUserBalance">
                    <label class="custom-control-label" for="customCheck1">add the payment amount to the user's balance</label>
                </div>

                <input type="hidden" name="type" value="2">

                {!! Form::button('Save payment', array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
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
