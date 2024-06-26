<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Berita</title>
    <link href="/css/update-news.css" rel="stylesheet">
</head>
<body>
    @include('layout.navbar')

    <div class="newsContainer">
        <div class="newsContainer-content">
            <h2>Ubah Berita</h2>
            <form id="newsForm" action="{{ route('news.update.admin', $news->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <label for="newsName">Judul Berita:</label><br>
                <input type="text" id="newsName" name="title" value="{{ old('title', $news->title) }}"><br><br>
                @error('title')
                    <div class="error">{{ $message }}</div>
                @enderror
                <label for="newsDescription">Deskripsi:</label><br>
                <textarea id="newsDescription" name="description">{{ old('description', $news->description) }}</textarea><br><br>
                @error('description')
                    <div class="error">{{ $message }}</div>
                @enderror
                <label for="category">Kategori:</label>
                <select class="form-control" id="category" name="category">
                    <option value="kecelakaan" {{ old('category', $news->category) === 'kecelakaan' ? 'selected' : '' }}>Kecelakaan</option>
                    <option value="kesehatan" {{ old('category', $news->category) === 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                    <option value="cuaca" {{ old('category', $news->category) === 'cuaca' ? 'selected' : '' }}>Cuaca</option>
                    <option value="bisnis" {{ old('category', $news->category) === 'bisnis' ? 'selected' : '' }}>Bisnis</option>
                    <option value="lain-lain" {{ old('category', $news->category) === 'lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                </select><br><br>
                @error('category')
                    <div class="error">{{ $message }}</div>
                @enderror
                @if ($news->picture)
                    <label for="oldImage">Gambar Saat Ini:</label><br>
                    <img src="{{ asset($news->picture) }}" alt="Current Image" class="news-image"><br><br>
                @endif
                <label for="newsImage">Gambar (jpeg, png, jpg, gif):</label><br><br>
                <input type="file" id="newsImage" name="picture"><br><br>
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
