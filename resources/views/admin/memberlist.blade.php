@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Welcome, Admin')

@section('content')
<h2 class="text-2xl font-bold mb-4">Members</h2>
<table class="table table-striped table-sm" id="auditLogsTable">
    <thead class="table-dark">
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Nationality</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->fldFirstName }}</td>
                <td>{{ $user->fldLastName }}</td>
                <td>{{ $user->fldGender }}</td>
                <td>{{ $user->fldNationality }}</td>
                <td>
                    <a href="" class="btn btn-sm btn-primary">Edit</a>
                    <form action="" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                    </form>
                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewMoreModal{{ $user->id }}">View More</button>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="viewMoreModal{{ $user->id }}" tabindex="-1" aria-labelledby="viewMoreModalLabel{{ $user->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewMoreModalLabel{{ $user->id }}">User Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <tbody>
                                            @foreach ([
                                                'User ID' => $user->fldUserID,
                                                'Username' => $user->fldUserName,
                                                'First Name' => $user->fldFirstName,
                                                'Middle Name' => $user->fldMiddleName,
                                                'Last Name' => $user->fldLastName,
                                                'Nickname' => $user->fldNickName,
                                                'Password' => $user->fldPassword,
                                                'Birth Date' => $user->fldBirthDate,
                                                'Civil Status' => $user->fldCivilStatus,
                                                'Gender' => $user->fldGender,
                                                'Nationality' => $user->fldNationality,
                                                'Order Limit Per Month' => $user->fldOrderLimitPerMonth,
                                                'Agree Terms' => $user->fldAgreeTerms,
                                                'Terms and Condition' => $user->fldTermsAndCondition,
                                                'Update Needed' => $user->fldUpdateNeeded,
                                                'Date Created' => $user->fldDateCreated,
                                                'Created By' => $user->fldCreatedBy,
                                                'Date Modified' => $user->fldDateModified,
                                                'Modified By' => $user->fldModifiedBy,
                                                'Is Deleted' => $user->fldIsDeleted,
                                                'Date Deleted' => $user->fldDateDeleted,
                                                'Deleted By' => $user->fldDeletedBy,
                                                'Email Address' => $user->fldEmailAdd,
                                                'Cellphone' => $user->fldCellphone,
                                                'Landline' => $user->fldLandline,
                                                'Beneficiary' => $user->fldBeneficiary,
                                                'Relationship' => $user->fldRelationship,
                                                'TIN' => $user->fldTIN,
                                                'Package ID' => $user->fldPackageID,
                                                'Sponsor ID' => $user->fldSponsorID,
                                                'Direct Sponsor ID' => $user->fldDirectSponsorID,
                                            ] as $key => $value)
                                                <tr>
                                                    <th>{{ $key }}</th>
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
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
