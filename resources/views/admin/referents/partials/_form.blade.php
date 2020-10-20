@extends('dashboard.base')

@section('css')
@endsection

@section('content')
    <div class="container-fluid" id="app">
        @if(!isset($referent))
            @php
                $referent = false;
            @endphp
        @endif
        <div class="card">
            <div class="card-header" style="display: flex;justify-content: space-between;align-items: center">
                <div>
                    <h3>{{ $referent ? 'Update Referent and Provider\'s data' : 'Add Referent' }}</h3>
                </div>
                <div>
                    <a href="{{ route('admin.referents.index') }}" class="btn btn-info" id="index">Referents List</a>
                    <a href="{{ route('admin.referents.trash') }}" class="btn btn-danger" id="delr">Deleted Referents</a>
                </div>
            </div>
                <div class="row my-4">
                    @if($referent)
                        <div class="col-4 uk-child-width-1" uk-grid>
                            <div>
                                <ul class="uk-tab-left" uk-tab="connect: #form-boxes;">
                                    <li class="uk-active"><a href="#">Referent</a></li>
                                    <li><a href="#">Dati aziendali</a></li>
                                </ul>
                            </div>
                        </div>
                    @endif
                    <div class="@if($referent) col-8 @else col-12 @endif">
                        @if($referent)
                                    <form method="POST" action="{{ route('admin.referents.update', $referent)  }}">
                                        @method('PUT')
                                        @csrf
                                        <div class="card-body">
                                            <ul id="form-boxes" class="uk-switcher">
                                                <li>
                                                    <div class="form-group row">
                                                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                                                        <div class="col-sm-10">
                                                            <input value="{{ old('name') ?? $referent->name }}" type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                                                            @error('name')
                                                            <em class="invalid-feedback">{{ $message }}</em>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="surname" class="col-sm-2 col-form-label">Surname</label>
                                                        <div class="col-sm-10">
                                                            <input value="{{ old('surname') ?? $referent->surname }}" type="text" class="form-control @error('surname') is-invalid @enderror" id="surname" name="surname">
                                                            @error('surname')
                                                            <em class="invalid-feedback">{{ $message }}</em>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="referent_pec" class="col-sm-2 col-form-label">PEC</label>
                                                        <div class="col-sm-10">
                                                            <input value="{{ old('referent_pec') ?? $referent->pec }}" type="text" class="form-control @error('referent_pec') is-invalid @enderror" id="referent_pec" name="referent_pec">
                                                            @error('referent_pec')
                                                            <em class="invalid-feedback">{{ $message }}</em>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="referent_email" class="col-sm-2 col-form-label">Email</label>
                                                        <div class="col-sm-10">
                                                            <input value="{{ old('referent_email') ?? $referent->email }}" type="email" class="form-control @error('referent_email') is-invalid @enderror" id="referent_email" name="referent_email">
                                                            @error('referent_email')
                                                            <em class="invalid-feedback">{{ $message }}</em>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="referent_phone" class="col-sm-2 col-form-label">Phone</label>
                                                        <div class="col-sm-10">
                                                            <input value="{{ old('referent_phone') ?? $referent->phone }}" type="text" class="form-control @error('referent_phone') is-invalid @enderror" id="referent_phone" name="referent_phone">
                                                            @error('referent_phone')
                                                            <em class="invalid-feedback">{{ $message }}</em>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="referent_mobile" class="col-sm-2 col-form-label">Mobile</label>
                                                        <div class="col-sm-10">
                                                            <input value="{{ old('referent_mobile') ?? $referent->mobile }}" type="text" class="form-control @error('referent_mobile') is-invalid @enderror" id="referent_mobile" name="referent_mobile">
                                                            @error('referent_mobile')
                                                            <em class="invalid-feedback">{{ $message }}</em>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="skype" class="col-sm-2 col-form-label">Skype</label>
                                                        <div class="col-sm-10">
                                                            <input value="{{ old('skype') ?? $referent->skype }}" type="text" class="form-control @error('skype') is-invalid @enderror" id="skype" name="skype">
                                                            @error('skype')
                                                            <em class="invalid-feedback">{{ $message }}</em>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="role" class="col-sm-2 col-form-label">Role</label>
                                                        <div class="col-sm-10">
                                                            <input value="{{ old('role') ?? $referent->role }}" type="text" class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                                                            @error('role')
                                                            <em class="invalid-feedback">{{ $message }}</em>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <label for="companyName">Ragione sociale</label>
                                                        <input value="{{ old('company_name') ?? ($referent ? $referent->provider->company_name : '') }}" type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" id="companyName" placeholder="Ragione sociale">
                                                        @error('company_name')
                                                        <em class="invalid-feedback">{{ $message }}</em>
                                                        @enderror
                                                    </div>
                                                    <div class="my-4">
                                                        <div class="form-group row">
                                                            <div class="col-4">
                                                                <label for="legal_seat">Sede legale</label>
                                                                <input value="{{ old('legal_seat') ?? ($referent ? $referent->provider->legal_seat : '') }}" type="text" name="legal_seat" class="form-control @error('legal_seat') is-invalid @enderror" id="legal_seat" placeholder="Sede legale">
                                                                @error('legal_seat')
                                                                <em class="invalid-feedback">{{ $message }}</em>
                                                                @enderror
                                                            </div>
                                                            <div class="col-4">
                                                                <label for="legal_seat_address">Sede legale - indirizzo</label>
                                                                <input value="{{ old('legal_seat_address') ?? ($referent ? $referent->provider->legal_seat_address : '') }}" type="email" class="form-control @error('legal_seat_address') is-invalid @enderror" id="legal_seat_address" name="legal_seat_address" placeholder="Sede legale - indirizzo">
                                                                @error('legal_seat_address')
                                                                <em class="invalid-feedback">{{ $message }}</em>
                                                                @enderror
                                                            </div>
                                                            <div class="col-4">
                                                                <label for="legal_seat_zip">Sede legale - CAP</label>
                                                                <input value="{{ old('legal_seat_zip') ?? ($referent ? $referent->provider->legal_seat_zip : '') }}" type="text" class="form-control @error('legal_seat_zip') is-invalid @enderror" id="legal_seat_zip" name="legal_seat_zip" placeholder="Sede legale - CAP">
                                                                @error('legal_seat_zip')
                                                                <em class="invalid-feedback">{{ $message }}</em>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-4">
                                                                <label for="legal_seat_city">Sede legale - Città</label>
                                                                <input value="{{ old('legal_seat_city') ?? ($referent ? $referent->provider->legal_seat_city : '') }}" type="text" name="legal_seat_city" class="form-control @error('legal_seat_city') is-invalid @enderror" id="legal_seat_city" placeholder="Sede legale - Città">
                                                                @error('legal_seat_city')
                                                                <em class="invalid-feedback">{{ $message }}</em>
                                                                @enderror
                                                            </div>
                                                            <div class="col-4">
                                                                <label for="legal_seat_region">Sede legale - Regione</label>
                                                                <select class="form-control @error('legal_seat_region') is-invalid @enderror" id="legal_seat_region" name="legal_seat_region">
                                                                    @foreach($regions as $region)
                                                                        <option value="{{ $region }}" @if($referent->provider->region == $region) selected @endif>{{ $region }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('legal_seat_region')
                                                                <em class="invalid-feedback">{{ $message }}</em>
                                                                @enderror
                                                            </div>
                                                            <div class="col-4">
                                                                <label for="legal_seat_country">Sede legale - Nazione</label>
                                                                <input value="{{ old('legal_seat_country') ?? ($referent ? $referent->provider->legal_seat_country : '') }}" type="text" class="form-control @error('legal_seat_country') is-invalid @enderror" id="legal_seat_country" name="legal_seat_country" placeholder="Sede legale - Nazione">
                                                                @error('legal_seat_country')
                                                                <em class="invalid-feedback">{{ $message }}</em>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="my-4">
                                                            <button class="btn btn-success" type="button" id="btnCopy">Copia dati sede legale in sede operativa</button>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-4">
                                                                <label for="operative_seat">Sede operativa</label>
                                                                <input value="{{  old('operative_seat') ?? ($referent ? $referent->provider->operative_seat : '') }}" type="text" name="operative_seat" class="form-control @error('operative_seat') is-invalid @enderror" id="operative_seat" placeholder="Sede operativa">
                                                                @error('operative_seat')
                                                                <em class="invalid-feedback">{{ $message }}</em>
                                                                @enderror
                                                            </div>
                                                            <div class="col-4">
                                                                <label for="operative_seat_address">Sede operativa - indirizzo</label>
                                                                <input value="{{  old('operative_seat_address') ?? ($referent ? $referent->provider->operative_seat_address : '') }}" type="email" class="form-control @error('operative_seat_address') is-invalid @enderror" id="operative_seat_address" name="operative_seat_address" placeholder="Sede operativa - indirizzo">
                                                                @error('operative_seat_address')
                                                                <em class="invalid-feedback">{{ $message }}</em>
                                                                @enderror
                                                            </div>
                                                            <div class="col-4">
                                                                <label for="operative_seat_zip">Sede operativa - CAP</label>
                                                                <input value="{{  old('operative_seat_zip') ?? ($referent ? $referent->provider->operative_seat_zip : '') }}" type="text" class="form-control @error('operative_seat_zip') is-invalid @enderror" id="operative_seat_zip" name="operative_seat_zip" placeholder="Sede operativa - CAP">
                                                                @error('operative_seat_zip')
                                                                <em class="invalid-feedback">{{ $message }}</em>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-4">
                                                                <label for="operative_seat_city">Sede operativa - Città</label>
                                                                <input value="{{  old('operative_seat_city') ?? ($referent ? $referent->provider->operative_seat_city : '') }}" type="text" name="operative_seat_city" class="form-control @error('operative_seat_city') is-invalid @enderror" id="operative_seat_city" placeholder="Sede operativa - Città">
                                                                @error('operative_seat_city')
                                                                <em class="invalid-feedback">{{ $message }}</em>
                                                                @enderror
                                                            </div>
                                                            <div class="col-4">
                                                                <label for="operative_seat_region">Sede operativa - Regione</label>
                                                                <select class="form-control @error('operative_seat_region') is-invalid @enderror" id="operative_seat_region" name="operative_seat_region">
                                                                    @foreach($regions as $region)
                                                                        <option value="{{ $region }}" @if($referent->provider->operative_seat_region == $region) selected @endif>{{ $region }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('operative_seat_region')
                                                                <em class="invalid-feedback">{{ $message }}</em>
                                                                @enderror
                                                            </div>
                                                            <div class="col-4">
                                                                <label for="operative_seat_country">Sede operativa - Nazione</label>
                                                                <input value="{{  old('operative_seat_country') ?? ($referent ? $referent->provider->operative_seat_country : '') }}" type="text" class="form-control @error('operative_seat_country') is-invalid @enderror" id="operative_seat_country" name="operative_seat_country" placeholder="Sede operativa - Nazione">
                                                                @error('operative_seat_country')
                                                                <em class="invalid-feedback">{{ $message }}</em>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="my-4">
                                                        <div class="form-group row">
                                                            <div class="col">
                                                                <label for="vat">Partita IVA</label>
                                                                <input value="{{  old('vat') ?? ($referent ? $referent->provider->vat : '') }}" class="form-control @error('vat') is-invalid @enderror" id="vat" name="vat" placeholder="Partita IVA">
                                                                @error('vat')
                                                                <em class="invalid-feedback">{{ $message }}</em>
                                                                @enderror
                                                            </div>
                                                            <div class="col">
                                                                <label for="tax_unique_code">Codice unico destinatario</label>
                                                                <input value="{{  old('tax_unique_code') ?? ($referent ? $referent->provider->tax_unique_code : '') }}" class="form-control @error('tax_unique_code') is-invalid @enderror" id="tax_unique_code" name="tax_unique_code" placeholder="Codice unico destinatario">
                                                                @error('tax_unique_code')
                                                                <em class="invalid-feedback">{{ $message }}</em>
                                                                @enderror
                                                            </div>
                                                            <div class="col">
                                                                <label for="pec">PEC</label>
                                                                <input value="{{  old('pec') ?? ($referent ? $referent->provider->pec : '') }}" class="form-control @error('pec') is-invalid @enderror" id="pec" name="pec" placeholder="PEC">
                                                                @error('pec')
                                                                <em class="invalid-feedback">{{ $message }}</em>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="my-4">
                                                        <div class="form-group row">
                                                            <div class="col">
                                                                <label for="email">E-mail</label>
                                                                <input value="{{  old('email') ?? ($referent ? $referent->provider->email : '') }}" type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email">
                                                                @error('email')
                                                                <em class="invalid-feedback">{{ $message }}</em>
                                                                @enderror
                                                            </div>
                                                            <div class="col">
                                                                <label for="phone">Phone</label>
                                                                <input value="{{  old('phone') ?? ($referent ? $referent->provider->phone : '') }}" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Phone">
                                                                @error('phone')
                                                                <em class="invalid-feedback">{{ $message }}</em>
                                                                @enderror
                                                            </div>
                                                            <div class="col">
                                                                <label for="website">Insegna negozio</label>
                                                                <input value="{{  old('website') ?? ($referent ? $referent->provider->website : '') }}" class="form-control @error('website') is-invalid @enderror" id="website" name="website" placeholder="Insegna negozio">
                                                                @error('website')
                                                                <em class="invalid-feedback">{{ $message }}</em>
                                                                @enderror
                                                            </div>
                                                            <div class="col">
                                                                <label for="support_email">Support Email</label>
                                                                <input value="{{  old('support_email') ?? ($referent ? $referent->provider->support_email : '') }}" type="email" class="form-control @error('support_email') is-invalid @enderror" id="support_email" name="support_email" placeholder="Support Email">
                                                                @error('support_email')
                                                                <em class="invalid-feedback">{{ $message }}</em>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-footer" style="display: flex;justify-content: flex-end;align-items: center">
                                            <button class="btn btn-success">{{ $referent ? ' Salva modifiche' : 'Salva' }}</button>
                                        </div>
                                    </form>
                        @else
                            @include('admin.providers.partials._referent_form')
                        @endif
                    </div>
                </div>
        </div>
    </div>
@endsection

@section('javascript')
        <script>
            const copyBtn = document.querySelector('#btnCopy');
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

            window.onload = () => {
                if (copyBtn) {
                    copyBtn.onclick = () => {
                        copy();
                    }
                }
            }

        </script>
@endsection
