<!DOCTYPE html>
<html>
<head>
    <title>Strongly Connected Components</title>
</head>
<body>
    <h1>Strongly Connected Components</h1>

    <form action="{{ route('scc.find') }}" method="POST">
        @csrf
        <label for="graph_data">Graph Data:</label>
        <textarea name="graph_data" rows="5" cols="40" required>{{ old('graph_data', isset($graphData) ? $graphData : '') }}</textarea>
        <br>
        <button type="submit">Find SCC</button>
    </form>

    @if(isset($scc))
        <h2>Strongly Connected Components:</h2>
        @if(count($scc) > 0)
            @foreach ($scc as $component)
                <ul>
                    @foreach ($component as $node)
                        <li>{{ $node }}</li>
                    @endforeach
                </ul>
            @endforeach
        @else
            <p>No strongly connected components found.</p>
        @endif
    @endif
</body>
</html>
