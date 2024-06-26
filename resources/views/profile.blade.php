<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link href="/css/profile.css" rel="stylesheet">
</head>
<body>
    @include('layout.navbar')
    <div id="toastContainer" class="toastContainer"></div>
    
    <div class="main-content">
        <div class="profile-header">
            <div class="profile-info">
                <img src="{{ Auth::user()->picture ?: asset('/images/profile_pic.jpg') }}" alt="Profile Picture" class="profile-picture">
                <div class="profile-details">
                    <h2>{{ Auth::user()->username }}</h2>
                    <a href="/edit-profile" class="edit-profile-button">Ubah Profil</a>
                </div>
            </div>
        </div>

        <div class="profile-tabs">
            <ul class="tab-list">
                <li><a href="#news-tab">Berita</a></li>
                <li><a href="#polls-tab">Poll</a></li>
                <li><a href="#events-tab">Acara</a></li>
            </ul>
            <div id="news-tab" class="tab-content">
                <h3>Berita yang Diposting oleh Anda</h3>
                @forelse ($newsItems as $newsItem)
                    <div class="news-item">
                        <div class="item-header">
                            <h4>{{ $newsItem->title }}</h4>
                            <div class="dropdown-tab">
                                <button class="dropbtn-tab">&#8286;</button>
                                <div class="dropdown-content-tab">
                                    <a href="{{ route('view.news.update', $newsItem->id) }}">Ubah</a>
                                    <form action="{{ route('delete.item', ['type' => 'news', 'id' => $newsItem->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <p>{{ $newsItem->description }}</p>
                    </div>
                @empty
                    <p>Tidak ada berita.</p>
                @endforelse
            </div>

            <div id="polls-tab" class="tab-content">
                <h3>Poll yang Diposting oleh Anda</h3>
                @forelse ($polls as $poll)
                    <div class="poll-item">
                        <div class="item-header">
                            <h4>{{ $poll->title }}</h4>
                            <div class="dropdown-tab">
                                <button class="dropbtn-tab">&#8286;</button>
                                <div class="dropdown-content-tab">
                                    <a href="{{ route('view.poll.update', $poll->id) }}">Ubah</a>
                                    <form action="{{ route('delete.item', ['type' => 'poll', 'id' => $poll->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <p>{{ $poll->description }}</p>
                        <ul>
                            @foreach ($poll->options as $option)
                                <li>{{ $option->text }} - {{ $option->votes_count }} suara</li>
                            @endforeach
                        </ul>
                    </div>
                @empty
                    <p>Tidak ada poll.</p>
                @endforelse
            </div>

            <div id="events-tab" class="tab-content">
                <h3>Acara yang Diposting oleh Anda</h3>
                @forelse ($events as $event)
                    <div class="event-item">
                        <div class="item-header">
                            <h4>{{ $event->title }}</h4>
                            <div class="dropdown-tab">
                                <button class="dropbtn-tab">&#8286;</button>
                                <div class="dropdown-content-tab">
                                    <a href="{{ route('view.event.update', $event->id) }}">Ubah</a>
                                    <form action="{{ route('delete.item', ['type' => 'event', 'id' => $event->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <p>{{ $event->description }}</p>
                    </div>
                @empty
                    <p>Tidak ada acara.</p>
                @endforelse
            </div>
        </div>
    </div>

    <script src="/js/profile.js"></script>
    @if(session('success'))
        <script>
            showToast("{{ session('success') }}");
        </script>
    @endif
    @if(session('error'))
        <script>
            showToast("{{ session('error') }}", 'error');
        </script>
    @endif
</body>
</html>
