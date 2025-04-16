<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'fldUserName' => ['required', 'string', 'max:255'],
            'fldEmailAdd' => ['required', 'string', 'email', 'max:255', 'unique:members'],
            'fldPassword' => ['required', 'string', 'min:8'],
            'fldFirstName' => ['required', 'string', 'max:255'],
            'fldLastName' => ['required', 'string', 'max:255'],
            'fldMiddleName' => ['nullable', 'string', 'max:255'],
            'fldNickName' => ['nullable', 'string', 'max:255'],
            'fldBirthDate' => ['nullable', 'date', 'before:today'],
            'fldCivilStatus' => ['nullable'],
            'fldGender' => ['nullable'],
            'fldNationality' => ['nullable', 'string', 'max:255'],
            'fldAgreeTerms' => ['nullable'],
            'fldTermsAndCondition' => ['nullable', 'string'],
            'fldCellphone' => ['nullable', 'string', 'max:255'],
            'fldLandline' => ['nullable', 'string', 'max:255'],
            'fldBeneficiary' => ['nullable', 'string'],
            'fldRelationship' => ['nullable', 'string', 'max:255'],
            'fldSponsorID' => ['nullable', 'integer', 'min:0'],
            'fldDirectSponsorID' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'fldUserName' => $data['fldUserName'],
            'fldEmailAdd' => $data['fldEmailAdd'],
            'fldPassword' => Hash::make($data['fldPassword']),
            'fldFirstName' => $data['fldFirstName'],
            'fldLastName' => $data['fldLastName'],
            'fldMiddleName' => $data['fldMiddleName'],
            'fldNickName' => $data['fldNickName'],
            'fldBirthDate' => $data['fldBirthDate'],
            'fldCivilStatus' => $data['fldCivilStatus'],
            'fldGender' => $data['fldGender'],  
            'fldNationality' => $data['fldNationality'],
            'fldAgreeTerms' => 1,
            'fldTermsAndCondition' => $data['fldTermsAndCondition'],
            'fldCellphone' => $data['fldCellphone'],
            'fldLandline' => $data['fldLandline'],
            'fldBeneficiary' => $data['fldBeneficiary'],
            'fldRelationship' => $data['fldRelationship'],
            'fldSponsorID' => $data['fldSponsorID'],
            'fldDirectSponsorID' => $data['fldDirectSponsorID'],
            'fldUpdateNeeded' => 0,
            'fldDateCreated' => now(),   
            'fldTIN' => $data['fldTIN'] ?? null,
            'fldPackageID' => $data['fldPackageID'] ?? null,
            // Automatic set and increment fldUserID
            'fldUserID' => User::max('fldUserID') + 1,
        ]);
    }
}
