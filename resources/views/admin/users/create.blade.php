@extends('adminlte::page')

@section('title', 'Create User')

@section('content_header')
    <h1>Create User</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add New User</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="location">Location</label>
                    <select name="location" class="form-control" required>
                        <option value="">Select location</option>
                        <option value="Agder">Agder</option>
                        <option value="Innlandet">Innlandet</option>
                        <option value="Møre og Romsdal">Møre og Romsdal</option>
                        <option value="Nordland">Nordland</option>
                        <option value="Oslo">Oslo</option>
                        <option value="Rogaland">Rogaland</option>
                        <option value="Troms og Finnmark">Troms og Finnmark</option>
                        <option value="Trøndelag">Trøndelag</option>
                        <option value="Vestfold og Telemark">Vestfold og Telemark</option>
                        <option value="Vestland">Vestland</option>
                        <option value="Viken">Viken</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" class="form-control" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Create User</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@stop
