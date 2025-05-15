<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
</head>
<body>
    <h1>Daftar Buku</h1>
    <ul>
        @foreach ($books as $book)
            <li>
                <strong>{{ $book->title }}</strong> oleh {{ $book->author->name }} <br>
                Genre: {{ $book->genre->name }} <br>
                Harga: Rp {{ number_format($book->price, 0, ',', '.') }} <br>
                Stok: {{ $book->stock }} <br>
                Deskripsi: {{ $book->description }} <br>
                <img src="/images/{{ $book->cover_photo }}" alt="{{ $book->title }}" width="100">
            </li>
            <hr>
        @endforeach
    </ul>
</body>
</html>