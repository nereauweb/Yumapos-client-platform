@extends('dashboard.base')

@section('css')
@endsection

@section('content')
    <div class="container-fluid" id="app">
        <div class="card">
            <div class="card-header" style="display: flex;justify-content: space-between;align-items: center">
                <div>
                    <h3>{{ trans('titles.create-provider') }}</h3>
                </div>
                <div>
                    <a href="{{ route('admin.providers.index') }}" class="btn btn-info" id="index">{{ trans('titles.provider-list') }}</a>
                    <a href="#" class="btn btn-danger" id="create">{{ trans('titles.deleted-providers') }}</a>
                </div>
            </div>
                <form method="POST" action="{{ route('admin.providers.store')  }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="companyName">{{ trans('titles.social-region') }}</label>
                            <input value="{{ old('company_name') }}" type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" id="companyName" placeholder="{{ trans('titles.social-region') }}">
                            @error('company_name')
                            <em class="invalid-feedback">{{ $message }}</em>
                            @enderror
                        </div>
                        <div class="my-4">
                            <div class="form-group row">
                                <div class="col-4">
                                    <label for="legal_seat">Sede legale</label>
                                    <input value="{{ old('legal_seat') }}" type="text" name="legal_seat" class="form-control @error('legal_seat') is-invalid @enderror" id="legal_seat" placeholder="Sede legale">
                                    @error('legal_seat')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="legal_seat_address">Sede legale - indirizzo</label>
                                    <input value="{{ old('legal_seat_address') }}" type="email" class="form-control @error('legal_seat_address') is-invalid @enderror" id="legal_seat_address" name="legal_seat_address" placeholder="Sede legale - indirizzo">
                                    @error('legal_seat_address')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="legal_seat_zip">Sede legale - CAP</label>
                                    <input value="{{ old('legal_seat_zip') }}" type="text" class="form-control @error('legal_seat_zip') is-invalid @enderror" id="legal_seat_zip" name="legal_seat_zip" placeholder="Sede legale - CAP">
                                    @error('legal_seat_zip')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label for="legal_seat_city">Sede legale - Città</label>
                                    <input value="{{ old('legal_seat_city') }}" type="text" name="legal_seat_city" class="form-control @error('legal_seat_city') is-invalid @enderror" id="legal_seat_city" placeholder="Sede legale - Città">
                                    @error('legal_seat_city')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="legal_seat_region">Sede legale - Regione</label>
                                    <select class="form-control @error('legal_seat_region') is-invalid @enderror" id="legal_seat_region" name="legal_seat_region">
                                        <option>---</option>
                                        @foreach($regions as $region)
                                            <option value="{{ $region }}" @if($region == old('legal_seat_region')) selected @endif>{{ $region }}</option>
                                        @endforeach
                                    </select>
                                    @error('legal_seat_region')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="legal_seat_country">Sede legale - Nazione</label>
                                    <input value="{{ old('legal_seat_country') }}" type="text" class="form-control @error('legal_seat_country') is-invalid @enderror" id="legal_seat_country" name="legal_seat_country" placeholder="Sede legale - Nazione">
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
                                    <input value="{{  old('operative_seat') }}" type="text" name="operative_seat" class="form-control @error('operative_seat') is-invalid @enderror" id="operative_seat" placeholder="Sede operativa">
                                    @error('operative_seat')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="operative_seat_address">Sede operativa - indirizzo</label>
                                    <input value="{{  old('operative_seat_address') }}" type="email" class="form-control @error('operative_seat_address') is-invalid @enderror" id="operative_seat_address" name="operative_seat_address" placeholder="Sede operativa - indirizzo">
                                    @error('operative_seat_address')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="operative_seat_zip">Sede operativa - CAP</label>
                                    <input value="{{  old('operative_seat_zip') }}" type="text" class="form-control @error('operative_seat_zip') is-invalid @enderror" id="operative_seat_zip" name="operative_seat_zip" placeholder="Sede operativa - CAP">
                                    @error('operative_seat_zip')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label for="operative_seat_city">Sede operativa - Città</label>
                                    <input value="{{  old('operative_seat_city') }}" type="text" name="operative_seat_city" class="form-control @error('operative_seat_city') is-invalid @enderror" id="operative_seat_city" placeholder="Sede operativa - Città">
                                    @error('operative_seat_city')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="operative_seat_region">Sede operativa - Regione</label>
                                    <select class="form-control @error('operative_seat_region') is-invalid @enderror" id="operative_seat_region" name="operative_seat_region">
                                        <option>---</option>
                                        @foreach($regions as $region)
                                            <option value="{{ $region }}" @if($region == old('operative_seat_region')) selected @endif>{{ $region }}</option>
                                        @endforeach
                                    </select>
                                    @error('operative_seat_region')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="operative_seat_country">Sede operativa - Nazione</label>
                                    <input value="{{  old('operative_seat_country') }}" type="text" class="form-control @error('operative_seat_country') is-invalid @enderror" id="operative_seat_country" name="operative_seat_country" placeholder="Sede operativa - Nazione">
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
                                    <input value="{{  old('vat') }}" class="form-control @error('vat') is-invalid @enderror" id="vat" name="vat" placeholder="Partita IVA">
                                    @error('vat')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="tax_unique_code">Codice unico destinatario</label>
                                    <input value="{{  old('tax_unique_code') }}" class="form-control @error('tax_unique_code') is-invalid @enderror" id="tax_unique_code" name="tax_unique_code" placeholder="Codice unico destinatario">
                                    @error('tax_unique_code')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="pec">PEC</label>
                                    <input value="{{  old('pec') }}" class="form-control @error('pec') is-invalid @enderror" id="pec" name="pec" placeholder="PEC">
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
                                    <input value="{{  old('email') }}" type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email">
                                    @error('email')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="phone">Phone</label>
                                    <input value="{{  old('phone') }}" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Phone">
                                    @error('phone')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="website">Insegna negozio</label>
                                    <input value="{{  old('website') }}" class="form-control @error('website') is-invalid @enderror" id="website" name="website" placeholder="Insegna negozio">
                                    @error('website')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="support_email">Support Email</label>
                                    <input value="{{  old('support_email') }}" type="email" class="form-control @error('support_email') is-invalid @enderror" id="support_email" name="support_email" placeholder="Support Email">
                                    @error('support_email')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer" style="display: flex;justify-content: flex-end;align-items: center">
                        <button class="btn btn-success">Salva</button>
                    </div>
                </form>
        </div>
    </div>
@endsection

@section('javascript')
        <script>

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
                document.querySelector('#btnCopy').onclick = () => {
                    copy();
                }

            }

        </script>
@endsection
