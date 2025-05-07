<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test File Upload</title>
</head>
<body>
    <h2>Test File Upload</h2>
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <p style="color: red;">{{ $errors->first() }}</p>
    @endif

    <form action="{{ route('profile.upload.test') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="test_picture" required>
        <button type="submit">Upload Test File</button>
    </form>
</body>
</html>
