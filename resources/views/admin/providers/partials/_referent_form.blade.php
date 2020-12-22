<form id="addReferentForm" method="POST" action="{{ route('admin.referents.store') }}">
    @csrf
    <div class="modal-body">
        <div class="container">
            <input type="hidden" name="provider_id" value="{{ $provider->id }}" id="provider_id">
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">{{ trans('titles.name') }}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                    @error('name')
                    <em class="invalid-feedback">{{ $message }}</em>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="surname" class="col-sm-2 col-form-label">{{ trans('titles.surname') }}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('surname') is-invalid @enderror" id="surname" name="surname">
                    @error('surname')
                    <em class="invalid-feedback">{{ $message }}</em>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="referent_pec" class="col-sm-2 col-form-label">{{ trans('titles.pec') }}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('referent_pec') is-invalid @enderror" id="referent_pec" name="referent_pec">
                    @error('referent_pec')
                    <em class="invalid-feedback">{{ $message }}</em>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="referent_email" class="col-sm-2 col-form-label">{{ trans('titles.email') }}</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control @error('referent_email') is-invalid @enderror" id="referent_email" name="referent_email">
                    @error('referent_email')
                    <em class="invalid-feedback">{{ $message }}</em>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="referent_phone" class="col-sm-2 col-form-label">{{ trans('titles.phone') }}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('referent_phone') is-invalid @enderror" id="referent_phone" name="referent_phone">
                    @error('referent_phone')
                    <em class="invalid-feedback">{{ $message }}</em>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="referent_mobile" class="col-sm-2 col-form-label">{{ trans('titles.mobile') }}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('referent_mobile') is-invalid @enderror" id="referent_mobile" name="referent_mobile">
                    @error('referent_mobile')
                    <em class="invalid-feedback">{{ $message }}</em>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="skype" class="col-sm-2 col-form-label">{{ trans('titles.skype') }}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('skype') is-invalid @enderror" id="skype" name="skype">
                    @error('skype')
                    <em class="invalid-feedback">{{ $message }}</em>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="role" class="col-sm-2 col-form-label">{{ trans('titles.role') }}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                    @error('role')
                    <em class="invalid-feedback">{{ $message }}</em>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('titles.close') }}</button>
        <button type="submit" class="btn btn-success">{{ trans('titles.save-changes') }}</button>
    </div>
</form>
