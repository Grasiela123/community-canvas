<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Acara</title>
    <link href="/css/update-event.css" rel="stylesheet">
</head>
<body>
    @include('layout.navbar')

    <div class="eventContainer">
        <div class="eventContainer-content">
            <h2>Ubah Acara</h2>
            <form id="eventForm" action="{{ route('event.update.admin', $event->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <p>Tanggal: <input type="date" id="eventDate" name="date_made" value="{{ old('date_made', $event->date_made) }}" required><br><br>
                <label for="eventName">Judul Acara:</label><br>
                <input type="text" id="eventName" name="title" value="{{ old('title', $event->title) }}" required><br><br>
                <label for="eventDescription">Deskripsi:</label><br>
                <textarea id="eventDescription" name="description" required>{{ old('description', $event->description) }}</textarea><br><br>
                @if ($event->picture)
                    <label for="oldImage">Gambar Saat Ini:</label><br>
                    <img src="{{ asset($event->picture) }}" alt="Current Image" class="event-image"><br><br>
                @endif
                <label for="eventImage">Gambar (jpeg, png, jpg, gif):</label><br><br>
                <input type="file" id="eventImage" name="picture"><br><br>
                @error('picture')
                    <div class="error">{{ $message }}</div>
                @enderror
                <a href="/admin" id="cancelButton">Batal</a>
                <button type="submit" id="submitButton">Simpan</button>
            </form>
        </div>
    </div>
</body>
</html>
