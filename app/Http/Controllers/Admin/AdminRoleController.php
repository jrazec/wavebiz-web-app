<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminRoleController extends Controller
{
    public function index()
    {
        
        $users = DB::connection('admin_db')->table('users')
            ->select('users.fldID', 'fldUserName', 'fldEmail', 'fldFirstName', 'fldLastName', 'fldDateCreated', 'fldDateModified', 'fldCreatedBy', 'fldModifiedBy', 'fldIsActive','p.fldRoleName')
            ->leftjoin('user_permissions as ur', 'ur.fldUserID', '=', 'users.fldID')
            ->leftjoin('permissions as p', 'p.fldID', '=', 'ur.fldPermissionID')
            ->groupby('users.fldID', 'fldUserName', 'fldEmail', 'fldFirstName', 'fldLastName', 'fldDateCreated', 'fldDateModified', 'fldCreatedBy', 'fldModifiedBy', 'fldIsActive','p.fldRoleName')
            ->get();
        $modules = DB::connection('admin_db')->table('modules')
            ->select('*')
            ->get();
        $permissions = DB::connection('admin_db')->table('permissions')
            ->select('*')
            ->get();
        return view('admin.roles',compact('users', 'modules', 'permissions'));
    }

    public function assignRole(Request $request)
    {
        $userId = $request->input('user_id');
        $roleId = $request->input('role_id');

        // Assign the role to the user
        DB::connection('admin_db')->table('user_permissions')->insert([
            'fldUserID' => $userId,
            'fldPermissionID' => $roleId,
        ]);

        return redirect()->back()->with('success', 'Role assigned successfully.');
    }

    public function edit(Request $request)
    {

        $userId = $request->fldUserID;
        $userId = intval($userId);
        $isReset = $request->isReset;
        $user = Admin::find($userId);
        if($isReset){
   
            $user->update([
                'fldPassword' => Hash::make('password'),
            ]);
            $user->save();
            // Audit log creation
            $admin = Auth::guard('admin')->user();
            DB::connection('admin_db')->table('audit_logs')->insert([
                'fldUserID' => $admin->fldID,
                'fldAction' => 'Reset Password',
                'fldDescription' => 'Reset password for user: ' . $request->fldUserName,
                'created_at' => now(),
            ]);
        }
        if (!$user) {
            return redirect()->route('admin.roles')->with('error', 'User not found.');
        }

        $user->update([
            'fldUserName' => $request->fldUserName,
            'fldEmail' => $request->fldEmail,
            'fldFirstName' => $request->fldFirstName,
            'fldLastName' => $request->fldLastName,
            'fldIsActive' => $request->fldIsActive,
        ]);
        
        $user->save();
        // Check the fldRoleName from the user and from the permissions table
        $permissionIDs = DB::connection('admin_db')->table('permissions')
            ->select('fldID')
            ->where('fldRoleName', $request->fldRoleName)
            ->get()
            ->pluck('fldID')
            ->toArray();
  
        if (!$permissionIDs) {
            return redirect()->route('admin.roles')->with('error', 'Permission not found.');
        }
        // Delete the user permission from the user_permissions table
        DB::connection('admin_db')->table('user_permissions')
            ->where('fldUserID', $userId)
            ->delete();

        // Update the user permission iterating the list of all the permissionIDs with the fldUserID
        foreach ($permissionIDs as $permissionID) {
            // Insert the permissionID to the user_permissions table
            DB::connection('admin_db')->table('user_permissions')->insert([
                'fldUserID' => $userId,
                'fldPermissionID' => $permissionID,  
                'updated_at' => now(),
            ]);  
        }

        // Audit log creation
        $admin = Auth::guard('admin')->user();
        DB::connection('admin_db')->table('audit_logs')->insert([
            'fldUserID' => $admin->fldID,
            'fldAction' => 'Edit User',
            'fldDescription' => 'Edited user: ' . $request->fldUserName,
            'created_at' => now(),
        ]);
        // Redirect to the roles page with a success message
        return redirect()->route('admin.roles')->with('success', 'User updated successfully.');
    }
    public function manage(Request $request)
    {
        $permissions = $request->permissions;
        $roleName = $request->fldRoleName;
        $modules = DB::connection('admin_db')->table('modules')
            ->select('fldID')
            ->get();
        $results = [];


        foreach ($permissions as $moduleId => $permission) {
            $moduleId = intval($moduleId);
            
            $incoming = [
                'fldCanView' => isset($permission['view']) ? 1 : 0,
                'fldCanAdd' => isset($permission['add']) ? 1 : 0,
                'fldCanEdit' => isset($permission['edit']) ? 1 : 0,
                'fldCanDelete' => isset($permission['delete']) ? 1 : 0,
            ];
    
            // Update or Insert logic based on Role + Module
            DB::connection('admin_db')->table('permissions')->updateOrInsert(
                [
                    'fldRoleName' => $roleName,
                    'fldModuleID' => $moduleId,
                ],
                $incoming
            );

    
            $results[] = [
                'fldModuleID' => $moduleId,
                'incoming' => $incoming,
            ];
        }
        foreach ($modules as $module) {
            if(isset($permissions[$module->fldID])) {
                continue;
            }
            $moduleId = intval($module->fldID);
            $incoming = [
                'fldCanView' => 0,
                'fldCanAdd' => 0,
                'fldCanEdit' => 0,
                'fldCanDelete' => 0,
            ];
    
            // Update or Insert logic based on Role + Module
            DB::connection('admin_db')->table('permissions')->updateOrInsert(
                [
                    'fldRoleName' => $roleName,
                    'fldModuleID' => $moduleId,
                ],
                $incoming
            );
        }
    
        // Audit log
        $admin = Auth::guard('admin')->user();
        DB::connection('admin_db')->table('audit_logs')->insert([
            'fldUserID' => $admin->fldID,
            'fldAction' => 'Edit Permissions',
            'fldDescription' => 'Edited permissions for role: ' . $roleName,
            'created_at' => now(),
        ]);
    
        return redirect()->route('admin.roles')->with('success', 'Permissions updated successfully.');
    }
    public function save(Request $request)
    {
        $roleName = $request->fldRoleName;
        $permissions = $request->add_permissions;
        
        // Check if the role name already exists
        $existingRole = DB::connection('admin_db')->table('permissions')
            ->where('fldRoleName', $roleName)
            ->first();
        if ($existingRole) {
            return redirect()->route('admin.roles')->with('error', 'Role name already exists.');
        }
        // Insert the new role, along side all the $modules
        $modules = DB::connection('admin_db')->table('modules')
            ->select('fldID')
            ->get();
        foreach ($modules as $module) {
            try {
            DB::connection('admin_db')->table('permissions')->insert([
                'fldRoleName' => $roleName,
                'fldModuleID' => $module->fldID,
                'fldCanView' =>  0,
                'fldCanAdd' => 0,
                'fldCanEdit' => 0,
                'fldCanDelete' => 0,
                'created_at' => now(),
            ]);
            } catch (\Exception $e) {
            dd('Error inserting module permissions:', $e->getMessage());
            }
        }
        // Update the permissions for the new role
        foreach ($permissions as $moduleID => $permission) {
            $moduleID = intval($moduleID);
            $incoming = [
            'fldCanView' => isset($permission['view']) ? 1 : 0,
            'fldCanAdd' => isset($permission['add']) ? 1 : 0,
            'fldCanEdit' => isset($permission['edit']) ? 1 : 0,
            'fldCanDelete' => isset($permission['delete']) ? 1 : 0,
            ];
            try {
            DB::connection('admin_db')->table('permissions')
                ->where('fldRoleName', $roleName)
                ->where('fldModuleID', $moduleID)
                ->update($incoming);
            } catch (\Exception $e) {
            dd('Error updating module permissions:', $e->getMessage());
            }
        }
        // Update 
        // Audit log creation
        $admin = Auth::guard('admin')->user();
        DB::connection('admin_db')->table('audit_logs')->insert([
            'fldUserID' => $admin->fldID,
            'fldAction' => 'Create Role',
            'fldDescription' => 'Created role: ' . $roleName,
            'created_at' => now(),
        ]);
    
        return redirect()->route('admin.roles')->with('success', 'Role created successfully.');
    }
    
    
}
