<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Admin extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $primaryKey = 'fldID';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $table = 'users';
    protected $connection = 'admin_db';
    public $timestamps = false; // Set to true if you want to use created_at and updated_at timestamps

    protected $fillable = [
        'fldID',
        'fldUserName',
        'fldPassword',
        'fldEmail',
        'fldFirstName',
        'fldLastName',
        'fldDateCreated',
        'fldDateModified',
        'fldCreatedBy',
        'fldModifiedBy',
        'fldIsActive',
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
    protected $hidden = [
        'fldPassword', 'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->fldPassword;
    }

    
    public function getAuthIdentifierName()
    {
        return 'fldUserName';
    }
}