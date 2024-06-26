<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita</title>
    <link href="/css/create-news.css" rel="stylesheet">
</head>
<body>
    @include('layout.navbar')

    <div class="newsContainer">
        <div class="newsContainer-content">
            <h2>Tambah Berita</h2>
            <form id="newsForm" action="{{ route('news.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="newsName">Judul Berita:</label><br>
                <input type="text" id="newsName" name="title"><br><br>
                @error('title')
                    <div class="error">{{ $message }}</div>
                @enderror
                <label for="newsDescription">Deskripsi:</label><br>
                <textarea id="newsDescription" name="description"></textarea><br><br>
                @error('description')
                    <div class="error">{{ $message }}</div>
                @enderror
                <label for="category">Kategori:</label>
                <select class="form-control" id="category" name="category">
                    <option value="kecelakaan">Kecelakaan</option>
                    <option value="kesehatan">Kesehatan</option>
                    <option value="cuaca">Cuaca</option>
                    <option value="bisnis">Bisnis</option>
                    <option value="acara">Acara</option>
                    <option value="lain-lain">Lain-lain</option>
                </select><br><br>
                @error('category')
                    <div class="error">{{ $message }}</div>
                @enderror
                <label for="newsImage">Gambar (jpeg,png,jpg,gif):</label><br><br>
                <input type="file" id="newsImage" name="picture"><br><br>
                @error('picture')
                    <div class="error">{{ $message }}</div>
                @enderror
                <a href="/feed" id="cancelButton">Batal</a>
                <button type="submit" id="submitButton">Simpan</button>
            </form>
        </div>
    </div>
</body>
</html>
