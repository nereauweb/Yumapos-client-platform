@extends('dashboard.base')

@section('css')
@endsection

@section('content')

    <div class="container-fluid">
        @if (auth()->user()->hasRole('admin'))
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <h3>Update password</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.updatePassword', auth()->id()) }}">
                                @method('PUT')
                                @csrf
                                <div class="form-group row">
                                    <label for="password" class="col-sm-2 col-form-label">New password</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password" class="form-control" id="password">
                                        @error('password')
                                        <div>
                                            <span class="text-small text-danger">{{ $message }}</span>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="confirm_password" class="col-sm-2 col-form-label">Confirm password</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="confirm_password" class="form-control" id="confirm_password">
                                        @error('confirm_password')
                                        <div>
                                            <span class="text-small text-danger">{{ $message }}</span>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex align-items-end flex-column">
                                        <button type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection
