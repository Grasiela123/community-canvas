<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalendar</title>
    <link href="/css/calendar.css" rel="stylesheet">
</head>
<body>
    @include('layout.navbar')
    <div id="toastContainer"></div>

    <div class="container">
        <div class="today">
            <h1 id="todayDate"></h1>
            <input type="hidden" id="hiddenTodayDate" name="hiddenTodayDate">
            <h2>Acara</h2>
            <ul id="todayEvents">
            </ul>
        </div>

        <div class="calendar">
            <div class="nav-arrow">
                <button id="prevMonth" class="arrow">&#9664;</button>
                <h1 id="currentMonth">Event Calendar</h1>
                <button id="nextMonth" class="arrow">&#9654;</button>
            </div>
            <table id="calendar">
                <thead>
                    <tr>
                        <th>Minggu</th>
                        <th>Senin</th>
                        <th>Selasa</th>
                        <th>Rabu</th>
                        <th>Kamis</th>
                        <th>Jumat</th>
                        <th>Sabtu</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div class="add-event-button">
                <a href="/create-event" id="addEventBtn">Tambah Acara</a>
            </div>
        </div>
    </div>

    <script>
        const eventsByDateRoute = '{{ route("events.by.date") }}';
        const csrfToken = '{{ csrf_token() }}';
        const assetBaseUrl = '{{ asset("") }}';
    </script>
    <script src="/js/calendar.js"></script>
    @if(session('success'))
        <script>
            showToast("{{ session('success') }}");
        </script>
    @endif
</body>
</html>

