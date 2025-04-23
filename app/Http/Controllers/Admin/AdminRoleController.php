<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminRoleController extends Controller
{
    public function index()
    {
        /*
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
        */
        
        $users = DB::connection('admin_db')->table('users')
            ->select('users.fldID', 'fldUserName', 'fldEmail', 'fldFirstName', 'fldLastName', 'fldDateCreated', 'fldDateModified', 'fldCreatedBy', 'fldModifiedBy', 'fldIsActive','p.fldRoleName')
            ->leftjoin('user_permissions as ur', 'ur.fldUserID', '=', 'users.fldID')
            ->leftjoin('permissions as p', 'p.fldID', '=', 'ur.fldPermissionID')
            ->get();
        $modules = DB::connection('admin_db')->table('modules')
            ->select('*')
            ->get();
        $permissions = DB::connection('admin_db')->table('permissions')
            ->select('*')
            ->get();
        return view('admin.roles',compact('users', 'modules', 'permissions'));
    }
}
