<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Acara</title>
    <link href="/css/create-event.css" rel="stylesheet">
</head>
<body>
    @include('layout.navbar')

    <div class="eventContainer">
        <div class="eventContainer-content">
            <h2>Tambah Acara</h2>
            <form id="eventForm" action="/create-event" method="POST" enctype="multipart/form-data">
                @csrf
                <p>Tanggal: <input type="date" id="eventDate" name="date_made" required><br><br>
                <label for="eventName">Judul Acara:</label><br>
                <input type="text" id="eventName" name="title" required><br><br>
                <label for="eventDescription">Deskripsi:</label><br>
                <textarea id="eventDescription" name="description" required></textarea><br><br>
                <label for="eventImage">Gambar (jpeg,png,jpg,gif):</label><br><br>
                <input type="file" id="eventImage" name="picture"><br><br>
                @error('picture')
                    <div class="error">{{ $message }}</div>
                @enderror
                <a href="/calendar" id="cancelButton">Batal</a>
                <button type="submit" id="submitButton">Simpan</button>
            </form>
        </div>
    </div>
</body>
</html>