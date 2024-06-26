<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link href="/css/edit-profile.css" rel="stylesheet">
</head>
<body>
    @include('layout.navbar')
    <div class="container">
        <div class="profile-container">
            <h2>Profil</h2>
            <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="profile-info">
                    <div class="profile-picture">
                        <img src="{{ Auth::user()->picture ?: asset('/images/profile_pic.jpg') }}" alt="Profile Picture" class="profile-picture">
                        <input type="file" name="picture" accept="image/*">
                        @error('picture')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="user-details">
                        <div class="info">
                            <strong>Nama Pengguna:</strong>
                            <input type="text" name="username" value="{{ $user->username }}">
                            @error('username')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="info">
                            <strong>Email:</strong>
                            <input type="text" name="email" value="{{ $user->email }}">
                            @error('email')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="info">
                            <strong>Kata Sandi:</strong>
                            <input type="checkbox" id="changePasswordCheckbox" name="change_password">
                            <label for="changePasswordCheckbox">Ubah kata sandi</label>
                            <input type="password" name="password" id="passwordField" value="" placeholder="*********" disabled>
                            @error('password')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="info">
                            <strong>Alamat:</strong>
                            <select name="address">
                                <option value="BSD" {{ $user->address === 'BSD' ? 'selected' : '' }}>BSD</option>
                                <option value="Gading Serpong" {{ $user->address === 'Gading Serpong' ? 'selected' : '' }}>Gading Serpong</option>
                                <option value="Alam Sutera" {{ $user->address === 'Alam Sutera' ? 'selected' : '' }}>Alam Sutera</option>
                            </select>
                            @error('address')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        endif
                    </div>
                </div>
                <div class="button-container">
                    <div class="cancel-button">
                        <a href="/profile">Batal</a>
                    </div>
                    <div class="edit-link">
                        <button type="submit">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="/js/edit-profile.js"></script>
</body>
</html>
