@extends('layouts.app')  {{-- Or your admin layout --}}

@section('content')
    <h1>Change Password</h1>

    <form method="POST" action="{{ route('admin.change-password.update') }}">
        @csrf

        <div class="form-group">
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" id="new_password" class="form-control" required>
            @error('new_password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="new_password_confirmation">Confirm New Password:</label>
            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Change Password</button>
    </form>
@endsection