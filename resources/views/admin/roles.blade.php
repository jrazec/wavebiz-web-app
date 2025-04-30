@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Welcome, Admin')

@section('content')
<h2 class="text-2xl font-bold mb-4">Roles</h2>
<div class="mb-6">
    
    <!-- Filter Section -->
    <div class="d-flex justify-content-around align-items-center gap-3 mb-4">
        <div>
            
            <button class="btn btn-info" id="managePermission" data-bs-toggle="modal" data-bs-target="#addRoleModal">Add Role</button>
            <button class="btn btn-info" id="manageModules" data-bs-toggle="modal" data-bs-target="#manageRolePermissionsModal">Manage Role Permissions</button>
        </div>

        <div>
            <!-- Search User -->
            <label for="searchUser" class="block text-sm font-medium text-gray-700 mb-1">Search User</label>
            <input type="text" id="searchUser" name="search_user" class="form-control" placeholder="Search by username or email">
        </div>
        <div>
            <!-- Filter by Role -->
            <label for="filterRole" class="block text-sm font-medium text-gray-700 mb-1">Filter by Role</label>
            <select id="filterRole" name="filter_role" class="form-control">
                <option value="">All Roles</option>
                <option value="Admin">Admin</option>
                <option value="User">User</option>
                <option value="Manager">Manager</option>
            </select>
        </div>


        


    </div>

    <!-- Members Table -->
    <table class="table table-striped table-sm" id="auditLogsTable">
        <thead class="table-dark">
            <tr>
            
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->fldID }}</td>
                    <td>{{ $user->fldUserName }}</td>
                    <td>{{ $user->fldEmail }}</td>
                    <td>{{ $user->fldFirstName }}</td>
                    <td>{{ $user->fldLastName }}</td>
                    <td class="role-name {{$user->fldRoleName}}" id="role - {{$user->fldID}}">{{ $user->fldRoleName }}</td>
                    <td>
                    
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewMoreModal{{ $user->fldID }}">View More</button>
                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $user->fldID }}">Edit</button>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->fldID }}">Delete</button>
                        <!-- View More Modal -->
                        <div class="modal fade" id="viewMoreModal{{ $user->fldID }}" tabindex="-1" aria-labelledby="viewMoreModalLabel{{ $user->fldID }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewMoreModalLabel{{ $user->fldID }}">User Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered">
                                            <tbody>
                                                @foreach ([
                                                    'User ID' => $user->fldID,
                                                    'Username' => $user->fldUserName,
                                                    'Email' => $user->fldEmail,
                                                    'First Name' => $user->fldFirstName,
                                                    'Last Name' => $user->fldLastName,
                                                    'Role' => $user->fldRoleName,
                                                    'Date Created' => $user->fldDateCreated,
                                                    'Date Modified' => $user->fldDateModified,
                                                    'Created By' => $user->fldCreatedBy,
                                                    'Modified By' => $user->fldModifiedBy,
                                                ] as $label => $value)
                                                    <tr>
                                                        <th>{{ $label }}</th>
                                                        <td>{{ $value }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $user->fldID }}" tabindex="-1" aria-labelledby="editModalLabel{{ $user->fldID }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{ $user->fldID }}">Edit User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="{{ route('admin.roles.update') }}" name="editUserForm{{ $user->fldID }}">
                                        @csrf
                                        @method('POST')
                                        <div class="modal-body">
                                            <input type="hidden" name="fldUserID" value="{{ $user->fldID }}">
                                            <div class="mb-3">
                                                <label for="fldUserName" class="form-label">Username</label>
                                                <input type="text" class="form-control" id="fldUserName" name="fldUserName" value="{{ $user->fldUserName }}" required>
                                            </div>  
                                            <div class="mb-3">
                                                <label for="fldEmail" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="fldEmail" name="fldEmail" value="{{ $user->fldEmail }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="fldFirstName" class="form-label">First Name</label>
                                                <input type="text" class="form-control" id="fldFirstName" name="fldFirstName" value="{{ $user->fldFirstName }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="fldLastName" class="form-label">Last Name</label>
                                                <input type="text" class="form-control" id="fldLastName" name="fldLastName" value="{{ $user->fldLastName }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="fldRoleName" class="form-label">Role</label>
                                                <select class="form-control" id="fldRoleName" name="fldRoleName" required>
                                                   
                                                    @php 
                                                    $roles = DB::connection('admin_db')
                                                        ->table('Permissions')
                                                        ->select('fldRoleName')
                                                        ->distinct()
                                                        ->get();
                                                    @endphp
                                                    @foreach ($roles as $role)
                                                        // if $user->fldRoleName == $role->fldRoleName then selected
                                                        @if ($user->fldRoleName == $role->fldRoleName)
                                                            <option value="{{ $role->fldRoleName }}" selected>{{ $role->fldRoleName }}</option>
                                                        @else
                                                            <option value="{{ $role->fldRoleName }}">{{ $role->fldRoleName }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- Create isReset Checkbox with a value of false in default and becomes true when clciked -->
                                             <div class="mb-3">
                                              
                                                <input type="checkbox" class="btn-check" id="isReset{{ $user->fldID }}" name="isReset" value="false" autocomplete="off">
                                                <label class="btn btn-outline-danger" for="isReset{{ $user->fldID }}">Toggle to Reset Password</label>
                                                <script>
                                                    document.getElementById('isReset{{ $user->fldID }}').addEventListener('change', function() {
                                                        this.value = this.checked ? 'true' : 'false';
                                                    });
                                                </script>
                                               
                                            </div>

                                        </div>  
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" name="btnSavePermission{{$user->fldID}}">Save Changes</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

            @endforeach
        </tbody>
    </table>

    <!-- Add Role Modal -->
    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ route('admin.roles.save') }}">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRoleModalLabel">Add Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="fldRoleName" class="form-label">Role Name</label>
                            <input type="text" class="form-control" name="fldRoleName" id="fldRoleName" placeholder="e.g. Admin" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Permissions by Module</label>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Module</th>
                                            <th class="text-center">Can View</th>
                                            <th class="text-center">Can Add</th>
                                            <th class="text-center">Can Edit</th>
                                            <th class="text-center">Can Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($modules as $module)
                                            <tr>
                                                <td>{{ $module->fldTableName }}</td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-check-input" name="add_permissions[{{ $module->fldID }}][view]" id="view-{{ $module->fldID }}">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-check-input" name="add_permissions[{{ $module->fldID }}][add]" id="add-{{ $module->fldID }}">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-check-input" name="add_permissions[{{ $module->fldID }}][edit]" id="edit-{{ $module->fldID }}">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-check-input" name="add_permissions[{{ $module->fldID }}][delete]" id="delete-{{ $module->fldID }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Permissions</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Manage Role Permissions Modal -->
    <div class="modal fade" id="manageRolePermissionsModal" tabindex="-1" aria-labelledby="manageRolePermissionsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.roles.manage') }}">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="manageRolePermissionsModalLabel">Manage Role Permissions</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="fldRoleName" class="form-label">Select Role</label>
                            <select class="form-control" name="fldRoleName" id="fldRoleNameSelector" required>
                                <option value="">Select Role</option>
                                @php
                                    $roles = DB::connection('admin_db')
                                    ->table('Permissions')
                                    ->select('fldRoleName')
                                    ->distinct()
                                    ->get();
                                    // Getting these: ,fldModuleID,fldCanView,fldCanAdd,fldCanEdit,fldCanDelete
                                    $permissions = DB::connection('admin_db')
                                    ->table('Permissions')
                                    ->select('fldID','fldRoleName','fldModuleID','fldCanView','fldCanAdd','fldCanEdit','fldCanDelete')
                                    ->get();
                                @endphp
                                @foreach ($roles as $role)
                                    <option value="{{ $role->fldRoleName }}">{{ $role->fldRoleName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Permissions by Module</label>
                            <button type="button" class="btn btn-secondary" id="editRoleBtn">Edit</button>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Module</th>
                                            <th class="text-center">Can View</th>
                                            <th class="text-center">Can Add</th>
                                            <th class="text-center">Can Edit</th>
                                            <th class="text-center">Can Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($modules as $module)
                                            <tr>
                                                <td>{{ $module->fldTableName }}</td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-check-input-Manage" name="permissions[{{ $module->fldID }}][view]" id="view-{{ $module->fldID }}">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-check-input-Manage" name="permissions[{{ $module->fldID }}][add]" id="add-{{ $module->fldID }}">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-check-input-Manage" name="permissions[{{ $module->fldID }}][edit]" id="edit-{{ $module->fldID }}">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-check-input-Manage" name="permissions[{{ $module->fldID }}][delete]" id="delete-{{ $module->fldID }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <p class="text-muted">Note: Check the permissions you want to assign to the selected role.</p>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Permissions</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
            </div>
        </div>
    </div>
                                        

    <!-- Assign Role Modal -->
    <div class="modal fade" id="assignRoleModal" tabindex="-1" aria-labelledby="assignRoleModalLabel{{ $user->fldID }}" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignRoleModalLabel">Assign Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="assignRoleUserId">
                        <div class="mb-3">
                            <label for="assignRoleName" class="form-label">Select Role</label>
                            <select class="form-control" name="role_name" id="assignRoleName" required>
                                <option value="">Select Role</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Assign Role</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Role Modal -->
    <div class="modal fade" id="editRoleModal{{ $user->fldID }}" tabindex="-1" aria-labelledby="editRoleModalLabel{{ $user->fldID }}" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.role.delete') }}">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="editRoleUserId">
                        <div class="mb-3">
                            <label for="editRoleName" class="form-label">Select Role</label>
                            <select class="form-control" name="role_name" id="editRoleName" required>
                                <option value="">Select Role</option>
                                @php
                                $roles = DB::connection('admin_db')
                                    ->table('Permissions')
                                    ->select('fldRoleName')
                                    ->distinct()
                                    ->get();
                                @endphp
                                @foreach ($roles as $role)
                                    <option value="{{ $role->fldRoleName }}">{{ $role->fldRoleName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Current Permissions</label>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Module</th>
                                            <th class="text-center">Can View</th>
                                            <th class="text-center">Can Add</th>
                                            <th class="text-center">Can Edit</th>
                                            <th class="text-center">Can Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($modules as $module)
                                            <tr>
                                                <td>{{ $module->fldTableName }}</td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-check-input" name="permissions[{{ $module->fldID }}][view]" id="edit-view-{{ $module->fldID }}">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-check-input" name="permissions[{{ $module->fldID }}][add]" id="edit-add-{{ $module->fldID }}">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-check-input" name="permissions[{{ $module->fldID }}][edit]" id="edit-edit-{{ $module->fldID }}">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-check-input" name="permissions[{{ $module->fldID }}][delete]" id="edit-delete-{{ $module->fldID }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var users = @json($users);
    console.log(users)
    var roles = @json($roles);
    console.log(roles)
    console.log(@json($users))
   
    const managePermissionButton = document.getElementById('managePermission');
    const manageModulesButton = document.getElementById('manageModules');
  
   const selectFldRoleName = document.getElementById('fldRoleNameSelector');
   selectFldRoleName.addEventListener('change', function() {
        const selectedRole = this.value;
        const cb = document.querySelectorAll('input[type="checkbox"]');
        const checkboxes = [];
        cb.forEach(checkbox => {
            if (checkbox.classList.contains('form-check-input-Manage')) {
                checkboxes.push(checkbox);
            }
        });
        checkboxes.forEach(checkbox => {
            checkbox.checked = false; // Uncheck all checkboxes
        });
        const permissions = @json($permissions);
        console.log(permissions);
        const selectedPermissions = permissions.filter(permission => permission.fldRoleName === selectedRole);
        selectedPermissions.forEach(permission => {
            checkboxes.forEach(checkbox => {
                if (checkbox.name === `permissions[${permission.fldModuleID}][view]`) {
                    checkbox.checked = permission.fldCanView === 1;
                }
                if (checkbox.name === `permissions[${permission.fldModuleID}][add]`) {
                    checkbox.checked = permission.fldCanAdd === 1;
                    
                }
                if (checkbox.name === `permissions[${permission.fldModuleID}][edit]`) {
                    checkbox.checked = permission.fldCanEdit === 1;
                    
                }
                if (checkbox.name === `permissions[${permission.fldModuleID}][delete]`) {
                    checkbox.checked = permission.fldCanDelete === 1;
                    
                }
                checkbox.disabled = true;
            });
        });

    });

    const editRoleBtn = document.getElementById('editRoleBtn');
    let editRoleToggle = false;

    editRoleBtn.addEventListener('click', () => {
        editRoleToggle = !editRoleToggle;
        console.log("Edit Role Button Clicked, Toggle State:", editRoleToggle);

        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            if (checkbox.classList.contains('form-check-input-Manage')) {
                checkbox.disabled = !editRoleToggle; // Toggle the disabled state
            }
        });

        // Update button appearance based on toggle state
        if (editRoleToggle) {
            editRoleBtn.classList.add('btn-success');
            editRoleBtn.classList.remove('btn-secondary');
            editRoleBtn.innerText = 'Finish Editing';
        } else {
            editRoleBtn.classList.remove('btn-success');
            editRoleBtn.classList.add('btn-secondary');
            editRoleBtn.innerText = 'Edit';
        }
    });




</script>
@endsection
