<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false; 
    protected $table = 'categories';
    protected $primaryKey = 'fldID';

    protected $fillable = [
        'fldName',  
        'fldDescription',  
        'fldSeqNo',  
        'fldImage',  
        'fldDateCreated',  
        'fldCreatedBy',  
        'fldModified',  
        'fldDateModified',  
        'fldModifiedBy',  
        'fldIsDeleted',  
        'fldDateDeleted',  
        'fldDeletedBy',  
        'subCategoryId',  
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'fldCategoryID', 'fldID');
    }
}
