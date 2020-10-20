@extends('dashboard.base')

@section('css')
@endsection

@section('content')
    <div class="container-fluid" id="app">
        <div class="card">
            <div class="card-header" style="display: flex;justify-content: space-between;align-items: center">
                <div>
                    <h3>Update provider and its referents</h3>
                </div>
                <div>
                    <a href="{{ route('admin.providers.index') }}" class="btn btn-info" id="index">Providers List</a>
                    <a href="{{ route('admin.providers.trash') }}" class="btn btn-danger" id="deleted">Deleted Providers</a>
                    <a href="{{ route('admin.referents.trash') }}" class="btn btn-danger" id="deleted-referents">Deleted Referents</a>
                </div>
            </div>
            <div uk-grid class="card-body">
                <div class="uk-width-1-3@s">
                    <ul class="uk-tab-left" uk-tab="connect: #form-boxes;">
                        <li class="uk-active"><a href="#">Provider</a></li>
                        @foreach($provider->referents as $referent)
                            <li><a href="#">{{ $referent->name }}</a></li>
                        @endforeach
                    </ul>
                </div>

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="uk-width-1-2@s">
                    <form  method="POST" action="{{ route('admin.providers.update', $provider) }}">
                        @csrf
                        @method('PUT')
                        <ul id="form-boxes" class="uk-switcher">
                            <li class="uk-active">
                                <div style="display: flex;justify-content: flex-end;" class="my-4">
                                    <a class="btn btn-info" href="{{ route('admin.referents.create') }}">Add a referent</a>
                                </div>
                                <div class="form-group row">
                                    <label for="company_name" class="col-sm-2 col-form-label">Ragione sociale</label>
                                    <div class="col-sm-10">
                                        <input value="{{ old('company_name') ?? $provider->company_name }}" type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name">
                                        @error('company_name')
                                        <em class="invalid-feedback">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="company_name" class="col-sm-2 col-form-label">Sede legale</label>
                                    <div class="col-sm-10">
                                        <input value="{{ old('legal_seat') ?? $provider->legal_seat }}" type="text" name="legal_seat" class="form-control @error('legal_seat') is-invalid @enderror" id="legal_seat" placeholder="Sede legale">
                                        @error('legal_seat')
                                        <em class="invalid-feedback">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="legal_seat_address" class="col-sm-2 col-form-label">Sede legale - indirizzo</label>
                                    <div class="col-sm-10">
                                        <input value="{{ old('legal_seat_address') ?? $provider->legal_seat_address }}" type="email" class="form-control @error('legal_seat_address') is-invalid @enderror" id="legal_seat_address" name="legal_seat_address" placeholder="Sede legale - indirizzo">
                                        @error('legal_seat_address')
                                        <em class="invalid-feedback">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="legal_seat_zip" class="col-sm-2 col-form-label">SSede legale - CAP</label>
                                    <div class="col-sm-10">
                                        <input value="{{ old('legal_seat_zip') ?? $provider->legal_seat_zip }}" type="text" class="form-control @error('legal_seat_zip') is-invalid @enderror" id="legal_seat_zip" name="legal_seat_zip" placeholder="Sede legale - CAP">
                                        @error('legal_seat_zip')
                                        <em class="invalid-feedback">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="legal_seat_city" class="col-sm-2 col-form-label">Sede legale - Città</label>
                                    <div class="col-sm-10">
                                        <input value="{{ old('legal_seat_city') ?? $provider->legal_seat_city }}" type="text" name="legal_seat_city" class="form-control @error('legal_seat_city') is-invalid @enderror" id="legal_seat_city" placeholder="Sede legale - Città">
                                        @error('legal_seat_city')
                                        <em class="invalid-feedback">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="legal_seat_region" class="col-sm-2 col-form-label">Sede legale - Regione</label>
                                    <div class="col-sm-10">
                                        <select class="form-control @error('legal_seat_region') is-invalid @enderror" id="legal_seat_region" name="legal_seat_region">
                                            <option>---</option>
                                            @foreach($regions as $region)
                                                <option value="{{ $region }}" @if($region == old('legal_seat_region') || $region == $provider->legal_seat_region) selected @endif>{{ $region }}</option>
                                            @endforeach
                                        </select>
                                        @error('legal_seat_region')
                                        <em class="invalid-feedback">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="legal_seat_country" class="col-sm-2 col-form-label">Sede legale - Nazione</label>
                                    <div class="col-sm-10">
                                        <input value="{{ old('legal_seat_country') ?? $provider->legal_seat_country }}" type="text" class="form-control @error('legal_seat_country') is-invalid @enderror" id="legal_seat_country" name="legal_seat_country" placeholder="Sede legale - Nazione">
                                        @error('legal_seat_country')
                                        <em class="invalid-feedback">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="my-4">
                                    <button class="btn btn-success" type="button" id="btnCopy">Copia dati sede legale in sede operativa</button>
                                </div>
                                <div class="form-group row">
                                    <label for="operative_seat" class="col-sm-2 col-form-label">Sede operativa</label>
                                    <div class="col-sm-10">
                                        <input value="{{  old('operative_seat') ?? $provider->operative_seat }}" type="text" name="operative_seat" class="form-control @error('operative_seat') is-invalid @enderror" id="operative_seat" placeholder="Sede operativa">
                                        @error('operative_seat')
                                        <em class="invalid-feedback">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="operative_seat_address" class="col-sm-2 col-form-label">Sede operativa - indirizzo</label>
                                    <div class="col-sm-10">
                                        <input value="{{  old('operative_seat_address') ?? $provider->operative_seat_address }}" type="email" class="form-control @error('operative_seat_address') is-invalid @enderror" id="operative_seat_address" name="operative_seat_address" placeholder="Sede operativa - indirizzo">
                                        @error('operative_seat_address')
                                        <em class="invalid-feedback">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="operative_seat_zip" class="col-sm-2 col-form-label">Sede operativa - CAP</label>
                                    <div class="col-sm-10">
                                        <input value="{{  old('operative_seat_zip') ?? $provider->operative_seat_zip }}" type="text" class="form-control @error('operative_seat_zip') is-invalid @enderror" id="operative_seat_zip" name="operative_seat_zip" placeholder="Sede operativa - CAP">
                                        @error('operative_seat_zip')
                                        <em class="invalid-feedback">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="operative_seat_city" class="col-sm-2 col-form-label">Sede operativa - Città</label>
                                    <div class="col-sm-10">
                                        <input value="{{  old('operative_seat_city') ?? $provider->operative_seat_city }}" type="text" name="operative_seat_city" class="form-control @error('operative_seat_city') is-invalid @enderror" id="operative_seat_city" placeholder="Sede operativa - Città">
                                        @error('operative_seat_city')
                                        <em class="invalid-feedback">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="operative_seat_region" class="col-sm-2 col-form-label">Sede operativa - Regione</label>
                                    <div class="col-sm-10">
                                        <select class="form-control @error('operative_seat_region') is-invalid @enderror" id="operative_seat_region" name="operative_seat_region">
                                            <option>---</option>
                                            @foreach($regions as $region)
                                                <option value="{{ $region }}" @if($region == old('operative_seat_region') || $region == $provider->operative_seat_region) selected @endif>{{ $region }}</option>
                                            @endforeach
                                        </select>
                                        @error('operative_seat_region')
                                        <em class="invalid-feedback">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="operative_seat_country" class="col-sm-2 col-form-label">Sede operativa - Nazione</label>
                                    <div class="col-sm-10">
                                        <input value="{{  old('operative_seat_country') ?? $provider->operative_seat_country }}" type="text" class="form-control @error('operative_seat_country') is-invalid @enderror" id="operative_seat_country" name="operative_seat_country" placeholder="Sede operativa - Nazione">
                                        @error('operative_seat_country')
                                        <em class="invalid-feedback">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="vat" class="col-sm-2 col-form-label">SPartita IVA</label>
                                    <div class="col-sm-10">
                                        <input value="{{  old('vat') ?? $provider->vat }}" class="form-control @error('vat') is-invalid @enderror" id="vat" name="vat" placeholder="Partita IVA">
                                        @error('vat')
                                        <em class="invalid-feedback">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tax_unique_code" class="col-sm-2 col-form-label">Codice unico destinatario</label>
                                    <div class="col-sm-10">
                                        <input value="{{  old('tax_unique_code') ?? $provider->tax_unique_code }}" class="form-control @error('tax_unique_code') is-invalid @enderror" id="tax_unique_code" name="tax_unique_code" placeholder="Partita IVA">
                                        @error('vat')
                                        <em class="invalid-feedback">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pec" class="col-sm-2 col-form-label">Codice unico destinatario</label>
                                    <div class="col-sm-10">
                                        <input value="{{  old('pec') ?? $provider->pec }}" class="form-control @error('pec') is-invalid @enderror" id="pec" name="pec" placeholder="PEC">
                                        @error('pec')
                                        <em class="invalid-feedback">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pec" class="col-sm-2 col-form-label">PEC</label>
                                    <div class="col-sm-10">
                                        <input value="{{  old('pec') ?? $provider->pec }}" class="form-control @error('pec') is-invalid @enderror" id="pec" name="pec" placeholder="PEC">
                                        @error('pec')
                                        <em class="invalid-feedback">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input value="{{  old('email') ?? $provider->email }}" type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email">
                                        @error('email')
                                        <em class="invalid-feedback">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                                    <div class="col-sm-10">
                                        <input value="{{  old('phone') ?? $provider->phone }}" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Phone">
                                        @error('phone')
                                        <em class="invalid-feedback">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="website" class="col-sm-2 col-form-label">Insegna negozio</label>
                                    <div class="col-sm-10">
                                        <input value="{{  old('website') ?? $provider->website }}" class="form-control @error('website') is-invalid @enderror" id="website" name="website" placeholder="Insegna negozio">
                                        @error('website')
                                        <em class="invalid-feedback">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="support_email" class="col-sm-2 col-form-label">Support Email</label>
                                    <div class="col-sm-10">
                                        <input value="{{  old('support_email') ?? $provider->support_email }}" type="email" class="form-control @error('support_email') is-invalid @enderror" id="support_email" name="support_email" placeholder="Support Email">
                                        @error('support_email')
                                        <em class="invalid-feedback">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                            </li>
                            @foreach($provider->referents as $referent)
                                <li>
                                    <div style="display: flex; justify-content: flex-end" class="my-4">
                                        <button class="btn btn-danger deleteBtn" type="button" data-delete="{{ $referent->id }}" data-surname="{{ $referent->surname }}" data-toggle="modal" data-target="#deleteModal">Delete referent</button>
                                    </div>
                                    <div class="form-group row">
                                        <label for="referents[{{ $referent->id }}][name]" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{ $referent->name }}" name="referents[{{ $referent->id }}][name]" id="referents[{{ $referent->id }}][name]">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="referents[{{ $referent->id }}][surname]" class="col-sm-2 col-form-label">Surname</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{ $referent->surname }}" name="referents[{{ $referent->id }}][surname]" id="referents[{{ $referent->id }}][surname]">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="referents[{{ $referent->id }}][pec]" class="col-sm-2 col-form-label">Surname</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{ $referent->pec }}" name="referents[{{ $referent->id }}][pec]" id="referents[{{ $referent->id }}][pec]">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="referents[{{ $referent->id }}][email]" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{ $referent->email }}" name="referents[{{ $referent->id }}][email]" id="referents[{{ $referent->id }}][email]">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="referents[{{ $referent->id }}][phone]" class="col-sm-2 col-form-label">Surname</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{ $referent->phone }}" name="referents[{{ $referent->id }}][phone]" id="referents[{{ $referent->id }}][phone]">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="referents[{{ $referent->id }}][mobile]" class="col-sm-2 col-form-label">Mobile</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{ $referent->mobile }}" name="referents[{{ $referent->id }}][mobile]" id="referents[{{ $referent->id }}][mobile]">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="referents[{{ $referent->id }}][skype]" class="col-sm-2 col-form-label">Skype</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{ $referent->skype }}" name="referents[{{ $referent->id }}][skype]" id="referents[{{ $referent->id }}][skype]">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="referents[{{ $referent->id }}][role]" class="col-sm-2 col-form-label">Role</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{ $referent->role }}" name="referents[{{ $referent->id }}][role]" id="referents[{{ $referent->id }}][role]">
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="my-2" style="display: flex;justify-content: flex-end;">
                            <button class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalTitle">Are you sure you want to delete referent with id: <span id="modalReferentId"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    You are deleting referent: <span id="modalReferentSurname"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form method="post" id="deleteReferentBtn">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        const copyBtn = document.querySelector('#btnCopy');

        // delete related data
        const delete_modal_id = document.querySelector('#modalReferentId');
        const delete_modal_surname = document.querySelector('#modalReferentSurname');
        const delete_modal_form = document.querySelector('#deleteReferentBtn');

        // return data with the values to be copied from
        const legal_seat = document.querySelector("input[name='legal_seat']");
        const legal_seat_address = document.querySelector("input[name='legal_seat_address']");
        const legal_seat_zip = document.querySelector("input[name='legal_seat_zip']");
        const legal_seat_city = document.querySelector("input[name='legal_seat_city']");
        const legal_seat_region = document.querySelector("select[name='legal_seat_region']");
        const legal_seat_country = document.querySelector("input[name='legal_seat_country']");

        // return data with the values to be pass coiped values to
        const operative_seat = document.querySelector("input[name='operative_seat']");
        const operative_seat_address = document.querySelector("input[name='operative_seat_address']");
        const operative_seat_zip = document.querySelector("input[name='operative_seat_zip']");
        const operative_seat_city = document.querySelector("input[name='operative_seat_city']");
        const operative_seat_region = document.querySelector("select[name='operative_seat_region']");
        const operative_seat_country = document.querySelector("input[name='operative_seat_country']");


        function copy() {
            operative_seat.value = legal_seat !== null ? legal_seat.value : '';
            operative_seat_address.value = legal_seat_address !== null ? legal_seat_address.value : '';
            operative_seat_zip.value = legal_seat_zip !== null ? legal_seat_zip.value : '';
            operative_seat_city.value = legal_seat_city !== null ? legal_seat_city.value : '';
            operative_seat_region.value = legal_seat_region !== null ? legal_seat_region.options[legal_seat_region.selectedIndex].value : '';
            operative_seat_country.value = legal_seat_country !== null ? legal_seat_country.value : '';
        }



        window.onload = (e) => {
            copyBtn.onclick = () => {
                copy();
            }
            // when modal opens
            document.addEventListener('show.coreui.modal', (el) => {
                delete_modal_id.textContent = el.relatedTarget.getAttribute('data-delete');
                delete_modal_surname.textContent = el.relatedTarget.getAttribute('data-surname');
                delete_modal_form.setAttribute('action', `/admin/referents/${delete_modal_id.textContent}`);
            });
        }

    </script>
@endsection
