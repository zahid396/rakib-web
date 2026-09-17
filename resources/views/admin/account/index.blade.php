@extends('admin.layouts.app')

@section('title', 'Account & Password')

@section('content')
    <div class="page-header">
        <h1>Account &amp; Password</h1>
        <p>Update your admin profile and change your login password.</p>
    </div>

    <div class="dash-grid" style="margin-bottom:1.5rem;">
        <div class="card">
            <div class="card-header">
                <h3>Profile</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" value="{{ $authAdmin->name ?? '' }}" readonly>
                    <div class="form-text">Your display name used across the admin panel.</div>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label>Email Address</label>
                    <input type="email" class="form-control" value="{{ $authAdmin->email ?? '' }}" readonly>
                    <div class="form-text">Login email. Change it directly in the database if needed.</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Change Password</h3>
            </div>
            <form method="POST" action="{{ route('admin.account.password') }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="current_password">Current Password <span class="required">*</span></label>
                        <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required autocomplete="current-password">
                        @error('current_password')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">New Password <span class="required">*</span></label>
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required minlength="8" autocomplete="new-password">
                            @error('password')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm New Password <span class="required">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="form-text">Use at least 8 characters.</div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
        </div>
    </div>
@endsection