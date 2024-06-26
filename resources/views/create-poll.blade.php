<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Poll</title>
    <link href="/css/create-poll.css" rel="stylesheet">
</head>
<body>
    @include('layout.navbar')

    <div class="pollContainer">
        <div class="pollContainer-content">
            <h2>Tambah Poll</h2>
            <form id="pollForm" action="{{ route('poll.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="pollName">Judul Poll:</label><br>
                <input type="text" id="pollName" name="title"><br><br>
                @error('title')
                    <div class="error">{{ $message }}</div>
                @enderror
                <label for="pollDescription">Deskripsi:</label><br>
                <textarea id="pollDescription" name="description"></textarea><br><br>
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
                <div id="options-container">
                    <div class="form-group">
                        <label for="option1">Opsi 1:</label>
                        <input type="text" id="option1" name="options[]" class="form-control" required>
                    </div><br>
                    <div class="form-group">
                        <label for="option2">Opsi 2:</label>
                        <input type="text" id="option2" name="options[]" class="form-control" required>
                    </div>
                </div><br>
                <button type="button" class="btn btn-secondary mb-3" id="add-option">Tambah Opsi</button><br><br>
                <label for="pollImage">Gambar (jpeg,png,jpg,gif):</label><br><br>
                <input type="file" id="pollImage" name="picture"><br><br>
                @error('picture')
                    <div class="error">{{ $message }}</div>
                @enderror
                <a href="/feed" id="cancelButton">Batal</a>
                <button type="submit" id="submitButton">Simpan</button>
            </form>
        </div>
    </div>

    <script src="/js/create-poll.js"></script>
</body>
</html>
