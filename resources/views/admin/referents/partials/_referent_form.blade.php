<form method="POST" action="{{ route('admin.referents.store') }}">
    @csrf
    <div class="container">
        <div class="form-group row">
            <label for="provider_id" class="col-sm-2 col-form-label">Provider</label>
            <div class="col-sm-10">
                <select class="form-control @error('provider_id') is-invalid @enderror" name="provider_id" id="provider_id">
                    @foreach($providers as $provider)
                        <option value="{{ $provider->id }}">{{ $provider->company_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                @error('name')
                <em class="invalid-feedback">{{ $message }}</em>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="surname" class="col-sm-2 col-form-label">Surname</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('surname') is-invalid @enderror" id="surname" name="surname">
                @error('surname')
                <em class="invalid-feedback">{{ $message }}</em>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="referent_pec" class="col-sm-2 col-form-label">PEC</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('referent_pec') is-invalid @enderror" id="referent_pec" name="referent_pec">
                @error('referent_pec')
                <em class="invalid-feedback">{{ $message }}</em>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="referent_email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control @error('referent_email') is-invalid @enderror" id="referent_email" name="referent_email">
                @error('referent_email')
                <em class="invalid-feedback">{{ $message }}</em>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="referent_phone" class="col-sm-2 col-form-label">Phone</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('referent_phone') is-invalid @enderror" id="referent_phone" name="referent_phone">
                @error('referent_phone')
                <em class="invalid-feedback">{{ $message }}</em>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="referent_mobile" class="col-sm-2 col-form-label">Mobile</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('referent_mobile') is-invalid @enderror" id="referent_mobile" name="referent_mobile">
                @error('referent_mobile')
                <em class="invalid-feedback">{{ $message }}</em>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="skype" class="col-sm-2 col-form-label">Skype</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('skype') is-invalid @enderror" id="skype" name="skype">
                @error('skype')
                <em class="invalid-feedback">{{ $message }}</em>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="role" class="col-sm-2 col-form-label">Role</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                @error('role')
                <em class="invalid-feedback">{{ $message }}</em>
                @enderror
            </div>
        </div>
        <div style="display: flex;justify-content: flex-end">
            <button class="btn btn-success">Create referent</button>
        </div>
    </div>
</form>
