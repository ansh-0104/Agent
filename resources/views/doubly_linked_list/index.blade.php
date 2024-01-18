<!DOCTYPE html>
<html>

<head>
    <title>Doubly Linked List Example</title>
</head>

<body>
    <h1>Doubly Linked List Example</h1>

    <form action="{{ route('doubly_linked_list.addNodeToEnd') }}" method="POST">
        @csrf
        <label for="list">Current List (comma-separated values):</label>
        <input type="text" name="list" required>
        <label for="value">Value to Add:</label>
        <input type="text" name="value" required>
        <button type="submit">Add to End</button>
    </form>

    <form action="{{ route('doubly_linked_list.deleteNode') }}" method="POST">
        @csrf
        <label for="list">Current List (comma-separated values):</label>
        <input type="text" name="list" required>
        <label for="deleteIndex">Index to Delete:</label>
        <input type="number" name="deleteIndex" required>
        <button type="submit">Delete Node</button>
    </form>

    <form action="{{ route('doubly_linked_list.rotate') }}" method="POST">
        @csrf
        <label for="list">Current List (comma-separated values):</label>
        <input type="text" name="list" required>
        <label for="steps">Steps:</label>
        <input type="number" name="steps" required>
        <label for="direction">Direction:</label>
        <select name="direction" required>
            <option value="clockwise">Clockwise</option>
            <option value="anticlockwise">Anti-clockwise</option>
        </select>
        <button type="submit">Rotate</button>
    </form>

    <h2>Linked List:</h2>
    <ul>
        @foreach ($listArray as $node)
            <li>
                <strong>Previous:</strong> {{ $node['prev'] }}
                &nbsp;&nbsp;&nbsp;
                <strong>Current:</strong> {{ $node['data'] }}
            </li>
        @endforeach
    </ul>
</body>

</html>