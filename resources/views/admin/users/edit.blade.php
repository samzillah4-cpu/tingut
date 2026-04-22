@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <h1>Edit User</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit User: {{ $user->name }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                </div>
                <div class="form-group">
                    <label for="location">Location</label>
                    <select name="location" class="form-control" required>
                        <option value="">Select location</option>
                        <option value="Agder" {{ $user->location == 'Agder' ? 'selected' : '' }}>Agder</option>
                        <option value="Innlandet" {{ $user->location == 'Innlandet' ? 'selected' : '' }}>Innlandet</option>
                        <option value="Møre og Romsdal" {{ $user->location == 'Møre og Romsdal' ? 'selected' : '' }}>Møre og Romsdal</option>
                        <option value="Nordland" {{ $user->location == 'Nordland' ? 'selected' : '' }}>Nordland</option>
                        <option value="Oslo" {{ $user->location == 'Oslo' ? 'selected' : '' }}>Oslo</option>
                        <option value="Rogaland" {{ $user->location == 'Rogaland' ? 'selected' : '' }}>Rogaland</option>
                        <option value="Troms og Finnmark" {{ $user->location == 'Troms og Finnmark' ? 'selected' : '' }}>Troms og Finnmark</option>
                        <option value="Trøndelag" {{ $user->location == 'Trøndelag' ? 'selected' : '' }}>Trøndelag</option>
                        <option value="Vestfold og Telemark" {{ $user->location == 'Vestfold og Telemark' ? 'selected' : '' }}>Vestfold og Telemark</option>
                        <option value="Vestland" {{ $user->location == 'Vestland' ? 'selected' : '' }}>Vestland</option>
                        <option value="Viken" {{ $user->location == 'Viken' ? 'selected' : '' }}>Viken</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Password (leave blank to keep current)</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" class="form-control" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ $user->roles->contains('name', $role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update User</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@stop
