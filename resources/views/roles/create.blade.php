@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Add Role</h2>
        <form method="POST" action="{{ route('roles.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">Role Name:</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Add Role</button>
        </form>
    </div>
@endsection
