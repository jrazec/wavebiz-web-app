<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable // THIS SERVES AS THE MEMBERs
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

     protected $table = 'members';
     public $timestamps = false; 
     protected $primaryKey = 'fldID';

     protected $fillable = [
        'fldUserID',
        'fldUserName',
        'fldFirstName',
        'fldMiddleName',
        'fldLastName',
        'fldNickName',
        'fldPassword',
        'fldBirthDate',
        'fldCivilStatus',
        'fldGender',
        'fldNationality',
        'fldOrderLimitPerMonth',
        'fldAgreeTerms',
        'fldTermsAndCondition',
        'fldUpdateNeeded',
        'fldDateCreated',
        'fldCreatedBy',
        'fldDateModified',
        'fldModifiedBy',
        'fldIsDeleted',
        'fldDateDeleted',
        'fldDeletedBy',
        'fldEmailAdd',
        'fldCellphone',
        'fldLandline',
        'fldBeneficiary',
        'fldRelationship',
        'fldTIN',
        'fldPackageID',
        'fldSponsorID',
        'fldDirectSponsorID',
     ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'fldPassword',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fldPassword' => 'hashed',
        ];
    }

    public function getAuthPassword()
    {
        return $this->fldPassword;
    }
    public function getEmailForPasswordReset()
    {
        return $this->fldEmailAdd;
    }
    

}
