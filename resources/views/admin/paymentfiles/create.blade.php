@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    {{ trans('titles.cff-payment') }}: {{ $payment->id }}
                    <div class="pull-right">
                        <a href="{{ url('/admin/payments/') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('usersmanagement.tooltips.back-users') }}">
                            <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                            {{ trans('titles.rtl-payments') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => ['admin.paymentfile.store', $payment->id], 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation', 'enctype' => 'multipart/form-data')) !!}
                {!! csrf_field() !!}

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

                {!! Form::button(trans('titles.save-file'), array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
                {!! Form::close() !!}
            </div>

        </div>
    </div>

@endsection
