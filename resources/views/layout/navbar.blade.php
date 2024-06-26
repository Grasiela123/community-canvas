<nav class="navbar">
    <a href="/" class="nav-brand">Community Canvas</a>
    <div class="nav-items">
        <a href="http://127.0.0.1:8000/#about" class="nav-link">Tentang</a>
        <a href="http://127.0.0.1:8000/#contact" class="nav-link">Kontak</a>
        @if (Auth::check())
        <a href="/feed" class="nav-link">Beranda</a>
        <a href="/calendar" class="nav-link">Kalendar</a>
        @if (Auth::user()->role == 'admin')
        <a href="/admin" class="nav-link">Admin</a>
        @endif
            <div class="nav-link profile-container-nav">
                <div class="dropdown">
                    <button class="dropbtn">
                        <img src="{{ Auth::user()->picture ?: asset('/images/profile_pic.jpg') }}" alt="Profile Picture" class="profile-picture-nav">
                    </button>
                    <div class="dropdown-content">
                        <a href="/profile">Profil</a>
                        <a href="/logout">Keluar</a>
                    </div>
                </div>
            </div>
        @else
            <a href="/login" class="nav-link">Masuk</a>
        @endif
    </div>
</nav>

