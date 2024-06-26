<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link href="/css/feed.css" rel="stylesheet">
</head>
<body>
    @include('layout.navbar')
    <div id="toastContainer"></div>
    
    <div class="main-content">
        <div class="filters">
            <h3>Filters</h3>
            <form action="{{ route('view.feed') }}" method="GET">
                <div class="form-group">
                    <label for="date">Filter bedasarkan Tanggal:</label>
                    <input type="date" id="date" name="date" value="{{ request('date') }}">
                </div>
                <div class="form-group">
                    <label for="category">Filter bedasarkan Kategori:</label>
                    <select id="category" name="category">
                        <option value="">Pilih Kategori</option>
                        <option value="kecelakaan" {{ request('category') == 'kecelakaan' ? 'selected' : '' }}>Kecelakaan</option>
                        <option value="kesehatan" {{ request('category') == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                        <option value="cuaca" {{ request('category') == 'cuaca' ? 'selected' : '' }}>Cuaca</option>
                        <option value="bisnis" {{ request('category') == 'bisnis' ? 'selected' : '' }}>Bisnis</option>
                        <option value="acara" {{ request('category') == 'acara' ? 'selected' : '' }}>Acara</option>
                        <option value="lain-lain" {{ request('category') == 'lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="feed_type">Filter bedasarkan Tipe Feed:</label>
                    <select id="feed_type" name="feed_type">
                        <option value="">Pilih Tipe Feed</option>
                        <option value="news" {{ request('feed_type') == 'news' ? 'selected' : '' }}>News</option>
                        <option value="polls" {{ request('feed_type') == 'polls' ? 'selected' : '' }}>Polls</option>
                    </select>
                </div>
                <div class="button-group">
                    <button type="submit">Terapkan Filter</button>
                    <a href="{{ route('view.feed') }}" class="refresh-button">Hapus Filter</a>
                </div>
            </form>
        </div>
        
        <div class="news-feed">
            @forelse ($paginatedFeeds as $feed)
                <div class="post">
                    <div class="user">{{ $feed->user->username }}</div>
                    <div class="date">{{ $feed->date_made }}</div>
                    <div class="title">{{ $feed->title }}</div>
                    @if ($feed instanceof App\Models\News)
                        <div class="description">{{ $feed->description }}</div>
                        @if ($feed->picture)
                            <div class="picture"><img src="{{ asset($feed->picture) }}" alt="Gambar"></div>
                        @endif
                    @elseif ($feed instanceof App\Models\Poll)
                        <div class="description">{{ $feed->question }}</div>
                        <form action="{{ route('poll.vote', $feed->id) }}" method="POST">
                            @csrf
                            @foreach ($feed->options as $option)
                                <div class="option">
                                    <input type="radio" name="option_id" value="{{ $option->id }}" id="option{{ $option->id }}"
                                        @if ($feed->hasUserVoted() && $feed->userVote()->option_id == $option->id) checked @endif>
                                    <label for="option{{ $option->id }}">{{ $option->text }}</label>
                                </div>
                            @endforeach
                            <button type="submit" class="vote-submit">Pilih</button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="post">
                    <p>Tidak ada berita atau poll.</p>
                </div>
            @endforelse
        </div>

        {{ $paginatedFeeds->links() }}
    </div>

    <div class="floating-button">
        <button class="plus-button">+</i></button>
        <div class="dropdown-content-add">
            <a href="{{ route('news.create') }}">Buat Berita</a>
            <a href="{{ route('poll.create') }}">Buat Poll</a>
        </div>
    </div>

    <script src="/js/feed.js"></script>
    @if(session('success'))
        <script>
            showToast("{{ session('success') }}");
        </script>
    @endif
    
</body>
</html>
