<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link href="/css/register.css" rel="stylesheet">
</head>
<body>
    @include('layout.navbar')
    <div class="container">
        <div class="register-image">
            <img src="/images/login-bg.jpg" alt="register">
        </div>
        <div class="register-container">
            <h2>Daftar</h2>
            <form action="/register" method="post">
                @csrf
                <input type="text" name="username" placeholder="Nama Pengguna" required>
                @error('username')
                    <div class="error">{{ $message }}</div>
                @enderror
                <input type="text" name="email" placeholder="Email" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
                <input type="password" name="password" placeholder="Kata sandi" required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
                <select name="address" required>
                    <option value="">Pilih Alamat</option>
                    <option value="BSD">BSD</option>
                    <option value="Gading Serpong">Gading Serpong</option>
                    <option value="Alam Sutera">Alam Sutera</option>
                </select>
                @error('address')
                    <div class="error">{{ $message }}</div>
                @enderror
                <input type="submit" value="Daftar">
            </form>
            <div class="signup-link">
                Sudah punya akun? <a href="/login">Masuk</a>
            </div>
        </div>
    </div>
</body>
</html>