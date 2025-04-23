<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    //
    protected $table = 'audit_logs'; // adjust if table name is different
    protected $primaryKey = 'fldID';
    public $timestamps = true;
    public $incrementing = true;
    protected $connection = 'admin_db';

    protected $fillable = [
        'fldUserID',
        'fldAction',
        'fldDescription',
        'fldTableName',
        'fldRecordID',
        'fldOldValue',
        'fldNewValue',
        'updated_at',
        'created_at',
    ];
}
