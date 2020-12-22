@extends('dashboard.base')

@section('css')
@endsection

@section('content')
    <div class="container-fluid" id="app">
    <div class="card">
        <div class="card-header" style="display: flex;justify-content: space-between;">
            <h3>{{ trans('titles.add-referent') }}</h3>
            <div class="pull-right">
                <a href="{{ route('admin.providers.index') }}" class="btn btn-info">{{ trans('titles.back') }}</a>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.referents.store') }}">
            @csrf
            <div class="card-body">
                <div>
                    <div class="form-group row">
                        <label for="provider_id" class="col-sm-2 col-form-label">{{ trans('titles.provider') }}</label>
                        <div class="col-sm-10">
                            <select class="form-control @error('provider_id') is-invalid @enderror"  id="provider_id" name="provider_id">
                                @foreach($providers as $provider)
                                    <option value="{{ $provider->id }}">{{ $provider->company_name }}</option>
                                @endforeach
                            </select>
                            @error('name')
                            <em class="invalid-feedback">{{ $message }}</em>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">{{ trans('titles.name') }}</label>
                        <div class="col-sm-10">
                            <input value="{{ old('name') }}" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name"  id="name" name="name">
                            @error('name')
                            <em class="invalid-feedback">{{ $message }}</em>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="surname" class="col-sm-2 col-form-label">{{ trans('titles.surname') }}</label>
                        <div class="col-sm-10">
                            <input value="{{ old('surname') }}" type="text" class="form-control @error('surname') is-invalid @enderror" placeholder="Surname"  id="surname" name="surname">
                            @error('surname')
                            <em class="invalid-feedback">{{ $message }}</em>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="referent_pec" class="col-sm-2 col-form-label">{{ trans('titles.pec') }}</label>
                        <div class="col-sm-10">
                            <input value="{{ old('referent_pec') }}" type="text" class="form-control @error('referent_pec') is-invalid @enderror" placeholder="PEC"  id="referent_pec" name="referent_pec">
                            @error('referent_pec')
                            <em class="invalid-feedback">{{ $message }}</em>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="referent_email" class="col-sm-2 col-form-label">{{ trans('titles.email') }}</label>
                        <div class="col-sm-10">
                            <input value="{{ old('referent_email') }}" type="email" class="form-control @error('referent_email') is-invalid @enderror" placeholder="Email"  id="referent_email" name="referent_email">
                            @error('referent_email')
                            <em class="invalid-feedback">{{ $message }}</em>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="referent_phone" class="col-sm-2 col-form-label">{{ trans('titles.phone') }}</label>
                        <div class="col-sm-10">
                            <input value="{{ old('referent_phone') }}" type="text" class="form-control @error('referent_phone') is-invalid @enderror" placeholder="Phone"  id="referent_phone" name="referent_phone">
                            @error('referent_phone')
                            <em class="invalid-feedback">{{ $message }}</em>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="referent_mobile" class="col-sm-2 col-form-label">{{ trans('titles.mobile') }}</label>
                        <div class="col-sm-10">
                            <input value="{{ old('referent_mobile') }}" type="text" class="form-control @error('referent_mobile') is-invalid @enderror" placeholder="Mobile"  id="referent_mobile" name="referent_mobile">
                            @error('referent_mobile')
                            <em class="invalid-feedback">{{ $message }}</em>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="skype" class="col-sm-2 col-form-label">{{ trans('titles.skype') }}</label>
                        <div class="col-sm-10">
                            <input value="{{ old('skype') }}" type="text" class="form-control @error('skype') is-invalid @enderror" placeholder="Skype"  id="skype" name="skype">
                            @error('skype')
                            <em class="invalid-feedback">{{ $message }}</em>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="role" class="col-sm-2 col-form-label">{{ trans('titles.role') }}</label>
                        <div class="col-sm-10">
                            <input value="{{ old('role') }}" type="text" class="form-control @error('role') is-invalid @enderror" placeholder="Role"  id="role" name="role">
                            @error('role')
                            <em class="invalid-feedback">{{ $message }}</em>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer" style="display: flex;justify-content: flex-end;">
                <button type="submit" class="btn btn-success">{{ trans('title.save-changes') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
