@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Import Users</h2>

    <form action="{{ route('import.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="csv_file">Choose a CSV File:</label>
            <input type="file" name="csv_file" class="form-control" accept=".csv" required>
        </div>
        <button type="submit" class="btn btn-primary">Import Users</button>
    </form>
</div>
@endsection
