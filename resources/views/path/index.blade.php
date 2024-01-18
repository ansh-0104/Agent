<!DOCTYPE html>
<html>
<head>
    <title>Least Expensive Path</title>
</head>
<body>
    <h1>Least Expensive Path</h1>

    <form action="{{ route('path.find') }}" method="POST">
        @csrf
        <label for="grid">Grid:</label>
        <textarea name="grid" rows="5" cols="40" required>{{ old('grid', '') }}</textarea>
        <br>
        <button type="submit">Find Least Expensive Path</button>
    </form>

    @if(isset($result))
        <h2>Least Expensive Path Cost:</h2>
        <p>{{ $result }}</p>
    @endif
</body>
</html>
