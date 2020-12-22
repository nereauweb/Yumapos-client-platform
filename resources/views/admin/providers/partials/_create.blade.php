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
                                    <label for="legal_seat">{{ trans('titles.legal_seat') }}</label>
                                    <input value="{{ old('legal_seat') }}" type="text" name="legal_seat" class="form-control @error('legal_seat') is-invalid @enderror" id="legal_seat" placeholder="{{ trans('titles.legal_seat') }}">
                                    @error('legal_seat')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="legal_seat_address">{{ trans('titles.legal-seat-address') }}</label>
                                    <input value="{{ old('legal_seat_address') }}" type="email" class="form-control @error('legal_seat_address') is-invalid @enderror" id="legal_seat_address" name="legal_seat_address" placeholder="{{ trans('titles.legal-seat-address') }}">
                                    @error('legal_seat_address')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="legal_seat_zip">{{ trans('titles.legal-seat-zip') }}</label>
                                    <input value="{{ old('legal_seat_zip') }}" type="text" class="form-control @error('legal_seat_zip') is-invalid @enderror" id="legal_seat_zip" name="legal_seat_zip" placeholder="{{ trans('titles.legal-seat-zip') }}">
                                    @error('legal_seat_zip')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label for="legal_seat_city">{{ trans('titles.legal-seat-city') }}</label>
                                    <input value="{{ old('legal_seat_city') }}" type="text" name="legal_seat_city" class="form-control @error('legal_seat_city') is-invalid @enderror" id="legal_seat_city" placeholder="{{ trans('titles.legal-seat-city') }}">
                                    @error('legal_seat_city')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="legal_seat_region">{{ trans('titles.legal-seat-region') }}</label>
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
                                    <label for="legal_seat_country">{{ trans('titles.legal-seat-country') }}</label>
                                    <input value="{{ old('legal_seat_country') }}" type="text" class="form-control @error('legal_seat_country') is-invalid @enderror" id="legal_seat_country" name="legal_seat_country" placeholder="{{ trans('titles.legal-seat-country') }}">
                                    @error('legal_seat_country')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                            </div>
                            <div class="my-4">
                                <button class="btn btn-success" type="button" id="btnCopy">{{ trans('titles.copy-content') }}</button>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label for="operative_seat">{{ trans('titles.operative-seat') }}</label>
                                    <input value="{{  old('operative_seat') }}" type="text" name="operative_seat" class="form-control @error('operative_seat') is-invalid @enderror" id="operative_seat" placeholder="{{ trans('titles.operative-seat') }}">
                                    @error('operative_seat')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="operative_seat_address">{{ trans('titles.operative-seat-address') }}</label>
                                    <input value="{{  old('operative_seat_address') }}" type="email" class="form-control @error('operative_seat_address') is-invalid @enderror" id="operative_seat_address" name="operative_seat_address" placeholder="Sede operativa - indirizzo">
                                    @error('operative_seat_address')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="operative_seat_zip">{{ trans('titles.operative-seat-zip') }}</label>
                                    <input value="{{  old('operative_seat_zip') }}" type="text" class="form-control @error('operative_seat_zip') is-invalid @enderror" id="operative_seat_zip" name="operative_seat_zip" placeholder="{{ trans('titles.operative-seat-zip') }}">
                                    @error('operative_seat_zip')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label for="operative_seat_city">{{ trans('titles.operative-seat-city') }}</label>
                                    <input value="{{  old('operative_seat_city') }}" type="text" name="operative_seat_city" class="form-control @error('operative_seat_city') is-invalid @enderror" id="operative_seat_city" placeholder="{{ trans('titles.operative-seat-city') }}">
                                    @error('operative_seat_city')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="operative_seat_region">{{ trans('titles.operative-seat-region') }}</label>
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
                                    <label for="operative_seat_country">{{ trans('titles.operative-seat-country') }}</label>
                                    <input value="{{  old('operative_seat_country') }}" type="text" class="form-control @error('operative_seat_country') is-invalid @enderror" id="operative_seat_country" name="operative_seat_country" placeholder="{{ trans('titles.operative-seat-country') }}">
                                    @error('operative_seat_country')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="form-group row">
                                <div class="col">
                                    <label for="vat">{{ trans('titles.vat') }}</label>
                                    <input value="{{  old('vat') }}" class="form-control @error('vat') is-invalid @enderror" id="vat" name="vat" placeholder="{{ trans('titles.vat') }}">
                                    @error('vat')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="tax_unique_code">{{ trans('titles.tax-unique-code') }}</label>
                                    <input value="{{  old('tax_unique_code') }}" class="form-control @error('tax_unique_code') is-invalid @enderror" id="tax_unique_code" name="tax_unique_code" placeholder="{{ trans('titles.tax-unique-code') }}">
                                    @error('tax_unique_code')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="pec">{{ trans('titles.pec') }}</label>
                                    <input value="{{  old('pec') }}" class="form-control @error('pec') is-invalid @enderror" id="pec" name="pec" placeholder="{{ trans('titles.pec') }}">
                                    @error('pec')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="form-group row">
                                <div class="col">
                                    <label for="email">{{ trans('titles.email') }}</label>
                                    <input value="{{  old('email') }}" type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="{{ trans('titles.email') }}">
                                    @error('email')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="phone">{{ trans('titles.phone') }}</label>
                                    <input value="{{  old('phone') }}" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="{{ trans('titles.phone') }}">
                                    @error('phone')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="website">{{ trans('titles.website') }}</label>
                                    <input value="{{  old('website') }}" class="form-control @error('website') is-invalid @enderror" id="website" name="website" placeholder="{{ trans('titles.website') }}">
                                    @error('website')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="support_email">{{ trans('titles.support-email') }}</label>
                                    <input value="{{  old('support_email') }}" type="email" class="form-control @error('support_email') is-invalid @enderror" id="support_email" name="support_email" placeholder="{{ trans('titles.support-email') }}">
                                    @error('support_email')
                                    <em class="invalid-feedback">{{ $message }}</em>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer" style="display: flex;justify-content: flex-end;align-items: center">
                        <button class="btn btn-success">{{ trans('titles.save') }}</button>
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
