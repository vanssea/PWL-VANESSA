<!DOCTYPE html>
<html>
<head>
    <title>Add Stock</title>
</head>
<body>
    <h1>Add Stock</h1>
    <form action="{{ route('stocks.store') }}" method="POST">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <br>
        <label for="description">Description:</label>
        <textarea name="description" required></textarea>
        <br>
        <button type="submit">Add Stock</button>
    </form>
    <a href="{{ route('stocks.index') }}">Back to List</a>
</body>
</html>
