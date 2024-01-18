<!DOCTYPE html>
<html>

<head>
    <title>Segment Tree Example</title>
</head>

<body>
    <h1>Segment Tree Example</h1>

    <form action="{{ route('segment_tree.initialize') }}" method="POST">
        @csrf

        <label for="size">Array Size:</label>
        <input type="number" name="size" required>

        <label for="array">Array (comma-separated values):</label>
        <input type="text" name="array" required>

        <button type="submit">Reinitialize</button>
    </form>


    <p>Array: {{ json_encode($array) }}</p>

    <form action="{{ route('segment_tree.query') }}" method="POST">
        @csrf
        <label for="i">Start index:</label>
        <input type="number" name="i" required>

        <label for="j">End index:</label>
        <input type="number" name="j" required>

        <button type="submit">Query</button>
    </form>

    <form action="{{ route('segment_tree.update') }}" method="POST">
        @csrf
        <label for="index">Index to update:</label>
        <input type="number" name="index" required>

        <label for="value">New value:</label>
        <input type="number" name="value" required>

        <button type="submit">Update</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        // $(document).ready(function() {
        //     $('form').submit(function(e) {
        //         e.preventDefault();

        //         var form = $(this);

        //         $.ajax({
        //             type: form.attr('method'),
        //             url: form.attr('action'),
        //             data: form.serialize(),
        //             dataType: 'json',
        //             success: function(response) {
        //                 alert(response.message || 'Sum: ' + response.sum);
        //                 location.reload();
        //             },
        //             error: function(error) {
        //                 console.log(error);
        //             }
        //         });
        //     });
        // });
    </script>
</body>

</html>