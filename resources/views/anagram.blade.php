<!DOCTYPE html>
<html>
<head>
    <title>Anagram Search</title>
</head>
<body>
    <h1>Anagram Search</h1>

    <form action="{{ route('findAnagrams') }}" method="POST">
        @csrf
        <label for="s">String S:</label>
        <input type="text" name="s" required>
        <br>
        <label for="p">Pattern P:</label>
        <input type="text" name="p" required>
        <br>
        <button type="submit">Find Anagrams</button>
    </form>

    @if(isset($indices))
        <h2>Start Indices of Anagrams:</h2>
        @if(count($indices) > 0)
            <ul>
                @foreach ($indices as $index)
                    <li>{{ $index }}</li>
                @endforeach
            </ul>
        @else
            <p>No anagrams found.</p>
        @endif
    @endif
</body>
</html>
