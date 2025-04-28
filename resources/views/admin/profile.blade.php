@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Welcome, Admin')

@section('content')
<div class="admin-profile-dashboard" style="font-family: Arial, sans-serif; color: #000;">
    <div style="background-color: #FFD700; padding: 20px; border-radius: 8px; margin-bottom: 20px; font-family: Arial, sans-serif; color: #000;">
        <h2 style="margin: 0; font-size: 24px; font-weight: bold; text-align: center;">Admin Profile</h2>
        <div style="margin-top: 15px; line-height: 1.6;">
            <p style="margin: 5px 0; font-size: 16px;"><strong>Username:</strong> {{ $admin->fldUserName }}</p>
            <p style="margin: 5px 0; font-size: 16px;"><strong>Email:</strong> {{ $admin->fldEmail }}</p>
            <p style="margin: 5px 0; font-size: 16px;"><strong>First Name:</strong> {{ $admin->fldFirstName }}</p>
            <p style="margin: 5px 0; font-size: 16px;"><strong>Last Name:</strong> {{ $admin->fldLastName }}</p>
        </div>
    </div>

    <div style="background-color: #000; color: #FFD700; padding: 20px; border-radius: 8px;">
        <h3>Change Password</h3>
        <form action="{{ route('admin.profile.change-password') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label for="old_password" style="display: block; margin-bottom: 5px;">Current Password</label>
                <input type="password" id="old_password" name="old_password" required 
                       style="width: 100%; padding: 10px; border: 1px solid #FFD700; border-radius: 4px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label for="new_password" style="display: block; margin-bottom: 5px;">New Password</label>
                <input type="password" id="new_password" name="new_password" required 
                       style="width: 100%; padding: 10px; border: 1px solid #FFD700; border-radius: 4px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label for="confirm_password" style="display: block; margin-bottom: 5px;">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required 
                       style="width: 100%; padding: 10px; border: 1px solid #FFD700; border-radius: 4px;">
            </div>
            <button type="submit" style="background-color: #FFD700; color: #000; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
                Update Password
            </button>
        </form>
    </div>
</div>

<!-- Flash Message Modal -->
@if(session('success') || session('error') || session('info'))
<div class="modal fade" id="flashMessageModal" tabindex="-1" aria-labelledby="flashMessageLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-{{ session('success') ? 'success' : (session('error') ? 'danger' : 'info') }}">
            <div class="modal-header bg-{{ session('success') ? 'success' : (session('error') ? 'danger' : 'info') }} text-white">
                <h5 class="modal-title" id="flashMessageLabel">
                    {{ session('success') ? 'Success' : (session('error') ? 'Error' : 'Notice') }}
                </h5>
            </div>
            <div class="modal-body">
                {{ session('success') ?? session('error') ?? session('info') }}
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
    var admin = @json($admin);
    console.log(admin, "sdsd");

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('form').addEventListener('submit', function (event) {
        const oldPassword = document.getElementById('old_password').value.trim();
        const newPassword = document.getElementById('new_password').value.trim();
        const confirmPassword = document.getElementById('confirm_password').value.trim();

        if (!oldPassword || !newPassword || !confirmPassword) {
            alert('All fields are required.');
            event.preventDefault();
            return;
        }

        if (newPassword !== confirmPassword) {
            alert('New Password and Confirm New Password do not match.');
            event.preventDefault();
        }
    });

    var session = @json(session()->all());
    console.log(session, "session");
    @if(session('success') || session('error') || session('info'))
            const flashModal = new bootstrap.Modal(document.getElementById('flashMessageModal'));
            flashModal.show();
            setTimeout(() => {
                flashModal.hide();
            }, 3000);
    @endif
    });

</script>