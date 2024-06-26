<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Poll</title>
    <link href="/css/update-poll.css" rel="stylesheet">
</head>
<body>
    @include('layout.navbar')

    <div class="pollContainer">
        <div class="pollContainer-content">
            <h2>Ubah Poll</h2>
            <form id="pollForm" action="{{ route('poll.update', $poll->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <label for="pollName">Judul Poll:</label><br>
                <input type="text" id="pollName" name="title" value="{{ old('title', $poll->title) }}"><br><br>
                @error('title')
                    <div class="error">{{ $message }}</div>
                @enderror
                <label for="pollDescription">Deskripsi:</label><br>
                <textarea id="pollDescription" name="description">{{ old('description', $poll->description) }}</textarea><br><br>
                @error('description')
                    <div class="error">{{ $message }}</div>
                @enderror
                <label for="category">Kategori:</label>
                <select class="form-control" id="category" name="category">
                    <option value="kecelakaan" {{ old('category', $poll->category) === 'kecelakaan' ? 'selected' : '' }}>Kecelakaan</option>
                    <option value="kesehatan" {{ old('category', $poll->category) === 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                    <option value="cuaca" {{ old('category', $poll->category) === 'cuaca' ? 'selected' : '' }}>Cuaca</option>
                    <option value="bisnis" {{ old('category', $poll->category) === 'bisnis' ? 'selected' : '' }}>Bisnis</option>
                    <option value="lain-lain" {{ old('category', $poll->category) === 'lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                </select><br><br>
                @error('category')
                    <div class="error">{{ $message }}</div>
                @enderror
                <div id="options-container">
                    @foreach (old('options', $poll->options) as $index => $option)
                        <div class="form-group">
                            <label for="option{{ $index + 1 }}">Opsi {{ $index + 1 }}:</label>
                            <input type="text" id="option{{ $index + 1 }}" name="options[]" class="form-control" value="{{ $option->text }}" required>
                        </div><br>
                    @endforeach
                </div><br>
                <button type="button" class="btn btn-secondary mb-3" id="add-option">Tambah Opsi</button><br><br>
                <label for="pollImage">Gambar (jpeg,png,jpg,gif):</label><br><br>
                @if ($poll->picture)
                    <label for="oldImage">Gambar Saat Ini:</label><br>
                    <img src="{{ asset($poll->picture) }}" alt="Current Image" class="poll-image"><br><br>
                @endif
                <input type="file" id="pollImage" name="picture"><br><br>
                @error('picture')
                    <div class="error">{{ $message }}</div>
                @enderror
                <a href="/profile" id="cancelButton">Batal</a>
                <button type="submit" id="submitButton">Simpan</button>
            </form>
        </div>
    </div>

    <script src="/js/create-poll.js"></script>
</body>
</html>
