<!-- Create the profile Section here of the user -->
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Profile') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="fldUserName" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <!-- Not Changeable -->
                                <input id="fldUserName" type="text" class="form-control @error('fldUserName') is-invalid @enderror" name="fldUserName" value="{{ old('fldUserName', $user->fldUserName) }}" readonly >

                                @error('fldUserName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fldEmailAdd" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="fldEmailAdd" type="email" class="form-control @error('fldEmailAdd') is-invalid @enderror" name="fldEmailAdd" value="{{ old('fldEmailAdd', $user->fldEmailAdd) }}" readonly>

                                @error('fldEmailAdd')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                    {{ __('Change Password') }}
                                </button>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="changePasswordModalLabel">{{ __('Change Password') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('password.change') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="current-password" class="form-label">{{ __('Current Password') }}</label>
                                                <input type="password" class="form-control @error('current-password') is-invalid @enderror" id="current-password" name="current_password" required>
                                                @error('current-password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="new-password" class="form-label">{{ __('New Password') }}</label>
                                                <input type="password" class="form-control @error('new-password') is-invalid @enderror" id="new-password" name="new_password" required>
                                                @error('new-password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="confirm-new-password" class="form-label">{{ __('Confirm New Password') }}</label>
                                                <input type="password" class="form-control" id="confirm-new-password" name="new_password_confirmation" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Profile') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
