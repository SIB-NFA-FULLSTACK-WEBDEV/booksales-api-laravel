<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genre List</title>
</head>
<body>
    <h1>List of Genres</h1>
        <ul>
            @foreach($genres as $genre)
                <li>
                    <strong>{{ $genre['name'] }}</strong><br>
                    {{ $genre['description'] }}
                </li>
            @endforeach
        </ul>
</body>
</html>