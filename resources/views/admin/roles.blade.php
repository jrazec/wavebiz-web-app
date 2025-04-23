@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Welcome, Admin')

@section('content')
<h2 class="text-2xl font-bold mb-4">Roles</h2>
<div class="mb-6">
    
    <!-- Filter Section -->
    <div class="d-flex justify-content-around align-items-center gap-3 mb-4">
        <div>
            <button class="btn btn-info" id="assignRole">Assign Role</button>
            <button class="btn btn-info" id="managePermission" data-bs-toggle="modal" data-bs-target="#managePermissionsModal">Manage Permissions</button>
            <button class="btn btn-info" id="manageModules" data-bs-toggle="modal" data-bs-target="#manageModulesModal">Manage Modules</button>
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
                                    <form  method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
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
                                                    <option value="">Select Role</option>
                                                    <option value="Admin" {{ $user->fldRoleName == 'Admin' ? 'selected' : '' }}>Admin</option>
                                                    <option value="User" {{ $user->fldRoleName == 'User' ? 'selected' : '' }}>User</option>
                                                    <option value="Manager" {{ $user->fldRoleName == 'Manager' ? 'selected' : '' }}>Manager</option>
                                                </select>
                                            </div>
                                        </div>  
            @endforeach
        </tbody>
    </table>

    <!-- Manage Permissions Modal -->
    <div class="modal fade" id="managePermissionsModal" tabindex="-1" aria-labelledby="managePermissionsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="managePermissionsModalLabel">Manage Permissions</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="fldRoleName" class="form-label">Role Name</label>
                            <input type="text" class="form-control" name="fldRoleName" id="fldRoleName" placeholder="e.g. Admin" required>
                        </div>
                        <div class="mb-3">
                            <label for="fldModuleID" class="form-label">Module</label>
                            <select class="form-control" name="fldModuleID" id="fldModuleID" required>
                                @foreach ($modules as $module)
                                    <option value="{{ $module->fldID }}">{{ $module->fldTableName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" name="fldCanAdd" id="fldCanAdd">
                            <label class="form-check-label" for="fldCanAdd">Can Add</label>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" name="fldCanEdit" id="fldCanEdit">
                            <label class="form-check-label" for="fldCanEdit">Can Edit</label>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" name="fldCanDelete" id="fldCanDelete">
                            <label class="form-check-label" for="fldCanDelete">Can Delete</label>
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

    <!-- Manage Modules Modal -->
    <div class="modal fade" id="manageModulesModal" tabindex="-1" aria-labelledby="manageModulesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="manageModulesModalLabel">Manage Modules</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="fldTableName" class="form-label">Module Table Name</label>
                            <input type="text" class="form-control" name="fldTableName" id="fldTableName" placeholder="e.g. Products" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Module</button>
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
    const assignRoleButton = document.getElementById('assignRole');
    let assignRoleButtonToggle = false;
    const managePermissionButton = document.getElementById('managePermission');
    const manageModulesButton = document.getElementById('manageModules');
    assignRoleButton.addEventListener('click', () => {
    assignRoleButtonToggle = !assignRoleButtonToggle;

    // Toggle button appearance
    if (assignRoleButtonToggle) {
        assignRoleButton.classList.add('btn-success');
        assignRoleButton.classList.remove('btn-info');
        assignRoleButton.innerText = 'Cancel Assign Role';
    } else {
        assignRoleButton.classList.remove('btn-success');
        assignRoleButton.classList.add('btn-info');
        assignRoleButton.innerText = 'Assign Role';
    }

    // Handle each role-name row
    const roleNameRows = document.querySelectorAll('.role-name');
    roleNameRows.forEach(row => {
        // Clear existing buttons
        const existingButton = row.querySelector('button');
        if (existingButton) {
            existingButton.remove();
        }

        const userId = row.id.split('-')[2];
        const roleText = row.className.split(' ')[1];

        if (!assignRoleButtonToggle) {
            // If toggle is OFF, restore original class name if needed
            const className = row.className.split(' ')[1];
            row.innerText = className;
            return;
        }

        // If toggle is ON, create appropriate button
        const button = document.createElement('button');
        button.classList.add('btn');
        button.setAttribute('data-user-id', userId);

        if (!roleText || roleText === "") {
            // If no role assigned
            button.innerText = 'Assign Role';
            button.classList.add('btn-primary');
            button.setAttribute('data-bs-toggle', 'modal');
            button.setAttribute('data-bs-target', '#assignRoleModal');
            button.setAttribute('data-role-name', '');
        } else {
            // If role exists
            button.innerText = 'Edit Role';
            button.classList.add('btn-warning');
            button.setAttribute('data-bs-toggle', 'modal');
            button.setAttribute('data-bs-target', '#editRoleModal');
            button.setAttribute('data-role-name', roleText);
        }

        // Clear text content and append button
        row.innerText = '';
        row.appendChild(button);
    });
});

</script>
@endsection
