@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="fldUserName" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="fldUserName" type="text" class="form-control @error('fldUserName') is-invalid @enderror" name="fldUserName" value="{{ old('fldUserName') }}" required autocomplete="name" autofocus>

                                @error('fldUserName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fldEmailAdd" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="fldEmailAdd" type="email" class="form-control @error('fldEmailAdd') is-invalid @enderror" name="fldEmailAdd" value="{{ old('fldEmailAdd') }}" required autocomplete="email">

                                @error('fldEmailAdd')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fldPassword" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="fldPassword" type="password" class="form-control @error('fldPassword') is-invalid @enderror" name="fldPassword" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fldFirstName" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>

                            <div class="col-md-6">
                                <input id="fldFirstName" type="text" class="form-control @error('fldFirstName') is-invalid @enderror" name="fldFirstName" value="{{ old('fldFirstName') }}" required autocomplete="name" autofocus>

                                @error('fldFirstName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fldLastName" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>

                            <div class="col-md-6">
                                <input id="fldLastName" type="text" class="form-control @error('fldLastName') is-invalid @enderror" name="fldLastName" value="{{ old('fldLastName') }}" required autocomplete="name" autofocus>

                                @error('fldLastName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fldMiddleName" class="col-md-4 col-form-label text-md-end">{{ __('Middle Name') }}</label>

                            <div class="col-md-6">
                                <input id="fldMiddleName" type="text" class="form-control @error('fldMiddleName') is-invalid @enderror" name="fldMiddleName" value="{{ old('fldMiddleName') }}" required autocomplete="name" autofocus>

                                @error('fldMiddleName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fldNickName" class="col-md-4 col-form-label text-md-end">{{ __('Nick Name') }}</label>

                            <div class="col-md-6">
                                <input id="fldNickName" type="text" class="form-control @error('fldNickName') is-invalid @enderror" name="fldNickName" value="{{ old('fldNickName') }}" required autocomplete="name" autofocus>

                                @error('fldNickName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fldBirthDate" class="col-md-4 col-form-label text-md-end">{{ __('Birth Date') }}</label>

                            <div class="col-md-6">
                                <input id="fldBirthDate" type="date" class="form-control @error('fldBirthDate') is-invalid @enderror" name="fldBirthDate" value="{{ old('fldBirthDate') }}" required autocomplete="name" autofocus>

                                @error('fldBirthDate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fldCivilStatus" class="col-md-4 col-form-label text-md-end">{{ __('Civil Status') }}</label>

                            <div class="col-md-6">
                                <input id="fldCivilStatus" type="text" class="form-control @error('fldCivilStatus') is-invalid @enderror" name="fldCivilStatus" value="{{ old('fldCivilStatus') }}" required autocomplete="name" autofocus>

                                @error('fldCivilStatus')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fldGender" class="col-md-4 col-form-label text-md-end">{{ __('Gender') }}</label>

                            <div class="col-md-6">
                                <input id="fldGender" type="text" class="form-control @error('fldGender') is-invalid @enderror" name="fldGender" value="{{ old('fldGender') }}" required autocomplete="sex" autofocus>

                                @error('fldGender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fldNationality" class="col-md-4 col-form-label text-md-end">{{ __('Nationality') }}</label>

                            <div class="col-md-6">
                                <input id="fldNationality" type="text" class="form-control @error('fldNationality') is-invalid @enderror" name="fldNationality" value="{{ old('fldNationality') }}" required autocomplete="name" autofocus>

                                @error('fldNationality')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fldCellphone" class="col-md-4 col-form-label text-md-end">{{ __('Cellphone') }}</label>

                            <div class="col-md-6">
                                <input id="fldCellphone" type="text" class="form-control @error('fldCellphone') is-invalid @enderror" name="fldCellphone" value="{{ old('fldCellphone') }}" required autocomplete="name" autofocus>

                                @error('fldCellphone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fldLandline" class="col-md-4 col-form-label text-md-end">{{ __('Landline') }}</label>

                            <div class="col-md-6">
                                <input id="fldLandline" type="text" class="form-control @error('fldLandline') is-invalid @enderror" name="fldLandline" value="{{ old('fldLandline') }}" required autocomplete="name" autofocus>

                                @error('fldLandline')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fldBeneficiary" class="col-md-4 col-form-label text-md-end">{{ __('Beneficiary') }}</label>

                            <div class="col-md-6">
                                <input id="fldBeneficiary" type="text" class="form-control @error('fldBeneficiary') is-invalid @enderror" name="fldBeneficiary" value="{{ old('fldBeneficiary') }}" required autocomplete="name" autofocus>

                                @error('fldBeneficiary')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fldRelationship" class="col-md-4 col-form-label text-md-end">{{ __('Relationship') }}</label>

                            <div class="col-md-6">
                                <input id="fldRelationship" type="text" class="form-control @error('fldRelationship') is-invalid @enderror" name="fldRelationship" value="{{ old('fldRelationship') }}" required autocomplete="name" autofocus>

                                @error('fldRelationship')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fldSponsorID" class="col-md-4 col-form-label text-md-end">{{ __('Sponsor ID') }}</label>

                            <div class="col-md-6">
                                <input id="fldSponsorID" type="text" class="form-control @error('fldSponsorID') is-invalid @enderror" name="fldSponsorID" value="{{ old('fldSponsorID') }}" required autocomplete="name" autofocus>

                                @error('fldSponsorID')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fldDirectSponsorID" class="col-md-4 col-form-label text-md-end">{{ __('Direct Sponsor ID') }}</label>

                            <div class="col-md-6">
                                <input id="fldDirectSponsorID" type="text" class="form-control @error('fldDirectSponsorID') is-invalid @enderror" name="fldDirectSponsorID" value="{{ old('fldDirectSponsorID') }}" required autocomplete="name" autofocus>

                                @error('fldDirectSponsorID')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fldUpdateNeeded" class="col-md-4 col-form-label text-md-end">{{ __('Update Needed') }}</label>

                            <div class="col-md-6">
                                <input id="fldUpdateNeeded" type="text" class="form-control @error('fldUpdateNeeded') is-invalid @enderror" name="fldUpdateNeeded" value="{{ old('fldUpdateNeeded') }}" required autocomplete="name" autofocus>

                                @error('fldUpdateNeeded')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fldDateCreated" class="col-md-4 col-form-label text-md-end">{{ __('Date Created') }}</label>

                            <div class="col-md-6">
                                <input id="fldDateCreated" type="text" class="form-control @error('fldDateCreated') is-invalid @enderror" name="fldDateCreated" value="{{ old('fldDateCreated') }}" required autocomplete="name" autofocus>

                                @error('fldDateCreated')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fldTIN" class="col-md-4 col-form-label text-md-end">{{ __('TIN') }}</label>

                            <div class="col-md-6">
                                <input id="fldTIN" type="text" class="form-control @error('fldTIN') is-invalid @enderror" name="fldTIN" value="{{ old('fldTIN') }}" required autocomplete="name" autofocus>

                                @error('fldTIN')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fldPackageID" class="col-md-4 col-form-label text-md-end">{{ __('Package ID') }}</label>

                            <div class="col-md-6">
                                <input id="fldPackageID" type="text" class="form-control @error('fldPackageID') is-invalid @enderror" name="fldPackageID" value="{{ old('fldPackageID') }}" required autocomplete="name" autofocus>

                                @error('fldPackageID')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fldCountry" class="col-md-4 col-form-label text-md-end">{{ __('Country') }}</label>

                            <div class="col-md-6">
                                <select id="fldCountry" class="form-control @error('fldCountry') is-invalid @enderror" name="fldCountry" required>
                                    <option value="">{{ __('Select Country') }}</option>
                                </select>

                                @error('fldCountry')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fldRegion" class="col-md-4 col-form-label text-md-end">{{ __('Region') }}</label>

                            <div class="col-md-6">
                                <select id="fldRegion" class="form-control @error('fldRegion') is-invalid @enderror" name="fldRegion" required>
                                    <option value="">{{ __('Select Region') }}</option>
                                </select>

                                @error('fldRegion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fldProvince" class="col-md-4 col-form-label text-md-end">{{ __('Province') }}</label>

                            <div class="col-md-6">
                                <select id="fldProvince" class="form-control @error('fldProvince') is-invalid @enderror" name="fldProvince" required>
                                    <option value="">{{ __('Select Province') }}</option>
                                </select>

                                @error('fldProvince')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fldMunicipality" class="col-md-4 col-form-label text-md-end">{{ __('Municipality') }}</label>

                            <div class="col-md-6">
                                <select id="fldMunicipality" class="form-control @error('fldMunicipality') is-invalid @enderror" name="fldMunicipality" required>
                                    <option value="">{{ __('Select Municipality') }}</option>
                                </select>

                                @error('fldMunicipality')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fldBarangay" class="col-md-4 col-form-label text-md-end">{{ __('Barangay') }}</label>

                            <div class="col-md-6">
                                <select id="fldBarangay" class="form-control @error('fldBarangay') is-invalid @enderror" name="fldBarangay" required>
                                    <option value="">{{ __('Select Barangay') }}</option>
                                </select>

                                @error('fldBarangay')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fldAddress" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>

                            <div class="col-md-6">
                                <input id="fldAddress" type="text" class="form-control @error('fldAddress') is-invalid @enderror" name="fldAddress" value="{{ old('fldAddress') }}" required autocomplete="name" autofocus>

                                @error('fldAddress')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Terms And Condition Section -->
                        <br> <hr> <br>
                        <div class="row mb-3">
                            <label for="fldTermsAndCondition" class="col-md-4 col-form-label text-md-end">{{ __('Terms and Condition') }}</label>

                            <div class="col-md-6">
                                <input id="fldTermsAndCondition" type="text" class="form-control @error('fldTermsAndCondition') is-invalid @enderror" name="fldTermsAndCondition" value="{{ old('fldTermsAndCondition') }}" required autocomplete="name" autofocus>

                                @error('fldTermsAndCondition')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Checkbox input for fldAgreeTerms -->
                        <div class="row mb-3">
                            <label for="fldAgreeTerms" class="col-md-4 col-form-label text-md-end">{{ __('I agree to the terms and conditions') }}</label>

                            <div class="col-md-6">
                                <input id="fldAgreeTerms" type="checkbox" class="@error('fldAgreeTerms') is-invalid @enderror" name="fldAgreeTerms" value="{{ old('fldAgreeTerms') }}" required>

                                @error('fldAgreeTerms')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const countrySelect = document.getElementById('fldCountry');
        const regionSelect = document.getElementById('fldRegion');
        const provinceSelect = document.getElementById('fldProvince');
        const municipalitySelect = document.getElementById('fldMunicipality');
        const barangaySelect = document.getElementById('fldBarangay');

        // Fetch countries
        fetch('https://restcountries.com/v3.1/all')
            .then(response => response.json())
            .then(data => {
                data.sort((a, b) => a.name.common.localeCompare(b.name.common));
                data.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country.name.common;
                    option.textContent = country.name.common;
                    countrySelect.appendChild(option);
                });
            });

        // Fetch regions based on selected country
        countrySelect.addEventListener('change', function () {
            regionSelect.innerHTML = '<option value="">{{ __('Select Region') }}</option>';
            provinceSelect.innerHTML = '<option value="">{{ __('Select Province') }}</option>';
            municipalitySelect.innerHTML = '<option value="">{{ __('Select Municipality') }}</option>';
            barangaySelect.innerHTML = '<option value="">{{ __('Select Barangay') }}</option>';

            if (this.value) {
                fetch(`https://psgc.gitlab.io/api/regions/`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(region => {
                            const option = document.createElement('option');
                            option.value = region.code;
                            option.textContent = region.regionName;
                            regionSelect.appendChild(option);
                        });
                    });
            }
        });

        // Fetch provinces based on selected region
        regionSelect.addEventListener('change', function () {
            provinceSelect.innerHTML = '<option value="">{{ __('Select Province') }}</option>';
            municipalitySelect.innerHTML = '<option value="">{{ __('Select Municipality') }}</option>';
            barangaySelect.innerHTML = '<option value="">{{ __('Select Barangay') }}</option>';

            // Check the selected Region Code
            const selectedRegionCode = this.value;
            if (this.value) {
                fetch(`https://psgc.gitlab.io/api/provinces/`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(province => {
                            if (province.regionCode !== selectedRegionCode) {
                                return;
                            }
                            const option = document.createElement('option');
                            option.value = province.code;
                            option.textContent = province.name;
                            provinceSelect.appendChild(option);
                        });
                    });
            }
        });

        // Fetch municipalities based on selected province
        provinceSelect.addEventListener('change', function () {
            municipalitySelect.innerHTML = '<option value="">{{ __('Select Municipality') }}</option>';
            barangaySelect.innerHTML = '<option value="">{{ __('Select Barangay') }}</option>';

            //Check the selected Province Code
            const selectedProvinceCode = this.value;

            if (this.value) {
                fetch(`https://psgc.gitlab.io/api/municipalities/`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(municipality => {
                            if (municipality.provinceCode !== selectedProvinceCode) {
                                return;
                            }
                            const option = document.createElement('option');
                            option.value = municipality.code;
                            option.textContent = municipality.name;
                            municipalitySelect.appendChild(option);
                        });
                    });
            }
        });

        // Fetch barangays based on selected municipality
        municipalitySelect.addEventListener('change', function () {
            barangaySelect.innerHTML = '<option value="">{{ __('Select Barangay') }}</option>';

            // Check the selected Municipality Code
            const selectedMunicipalityCode = this.value;

            if (this.value) {
                fetch(`https://psgc.gitlab.io/api/barangays/`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(barangay => {
                            if (barangay.municipalityCode !== selectedMunicipalityCode) {
                                return;
                            }
                            const option = document.createElement('option');
                            option.value = barangay.code;
                            option.textContent = barangay.name;
                            barangaySelect.appendChild(option);
                        });
                    });
            }
        });
    });
</script>

@endsection
