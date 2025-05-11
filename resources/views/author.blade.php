<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Authors</title>
</head>
<body>
    <h1>List of Authors</h1>
        <ul>
            @foreach($authors as $author)
                <li>
                    <strong>{{ $author['name'] }}</strong><br>
                    <img src="{{ $author['photo'] }}" alt="{{ $author['name'] }}" width="100"><br>
                     {{ $author['bio'] }}                
                </li>
            @endforeach
        </ul>
</body>
</html>