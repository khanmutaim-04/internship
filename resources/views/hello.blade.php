<!DOCTYPE html>
<html>
<head>
    <title>Laravel Blade</title>
</head>
<body>

    <h1>Welcome, {{ $name }}!</h1>

    @if($semester >= 5)
        <p>You are an advanced semester student.</p>
    @else
        <p>You are an early semester student.</p>
    @endif

    <h2>Skills</h2>

    @foreach($skills as $skill)
        <p>{{ $skill }}</p>
    @endforeach

</body>
</html>