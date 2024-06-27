<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk</title>
    <link href="/css/login.css" rel="stylesheet">
</head>
<body>
    @include('layout.navbar')
    <div id="toastContainer"></div>

    <div class="container">
        <div class="login-image">
            <img src="/images/login-bg.jpg" alt="Login">
        </div>
        <div class="login-container">
            <h2>Masuk</h2>
            <form action="/login" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" name="username" placeholder="Nama Pengguna" required>
                @error('username')
                    <div class="error">{{ $message }}</div>
                @enderror
                <input type="password" name="password" placeholder="Kata Sandi" required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
                <input type="submit" value="Login">
            </form>
            <div class="signup-link">
                Belum punya akun? <a href="/register">Daftar</a>
            </div>
        </div>
    </div>

    <script src="/js/login.js"></script>
    @if(session('error'))
        <script>
            showToast("{{ session('error') }}");
        </script>
    @endif

</body>
</html>