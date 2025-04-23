@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Welcome, Admin')

@section('content')
<div class="admin-profile-dashboard" style="font-family: Arial, sans-serif; color: #000;">
    <div style="background-color: #FFD700; padding: 20px; border-radius: 8px; margin-bottom: 20px; font-family: Arial, sans-serif; color: #000;">
        <h2 style="margin: 0; font-size: 24px; font-weight: bold; text-align: center;">Admin Profile</h2>
        <div style="margin-top: 15px; line-height: 1.6;">
            <p style="margin: 5px 0; font-size: 16px;"><strong>Username:</strong> {{ $admin[0]->fldUserName }}</p>
            <p style="margin: 5px 0; font-size: 16px;"><strong>Email:</strong> {{ $admin[0]->fldEmail }}</p>
            <p style="margin: 5px 0; font-size: 16px;"><strong>First Name:</strong> {{ $admin[0]->fldFirstName }}</p>
            <p style="margin: 5px 0; font-size: 16px;"><strong>Last Name:</strong> {{ $admin[0]->fldLastName }}</p>
        </div>
    </div>

    <div style="background-color: #000; color: #FFD700; padding: 20px; border-radius: 8px;">
        <h3>Change Password</h3>
        <form action="{{ route('admin.profile.change-password') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label for="current_password" style="display: block; margin-bottom: 5px;">Current Password</label>
                <input type="password" id="current_password" name="current_password" required 
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

@endsection

@section('scripts')
<script>
    var admin = @json($admin);
    console.log(admin,"sdsd");
    
</script>