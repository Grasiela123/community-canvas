var calendarBody = document.querySelector('#calendar tbody');
var currentMonthHeader = document.getElementById('currentMonth');
var todayDateHeader = document.getElementById('todayDate');
var todayEventsList = document.getElementById('todayEvents');

var events = {};

function generateCalendar(month, year) {
    calendarBody.innerHTML = '';
    currentMonthHeader.textContent = getMonthName(month) + ' ' + year;
    var daysInMonth = new Date(year, month + 1, 0).getDate();
    var firstDayOfMonth = new Date(year, month, 1).getDay();

    var date = 1;
    for (var i = 0; i < 6; i++) {
        var row = document.createElement('tr');
        for (var j = 0; j < 7; j++) {
            if (i === 0 && j < firstDayOfMonth) {
                var cell = document.createElement('td');
                row.appendChild(cell);
            } else if (date > daysInMonth) {
                break;
            } else {
                var cell = document.createElement('td');
                cell.textContent = date;
                cell.setAttribute('data-date', `${year}-${month + 1}-${date}`);
                cell.addEventListener('click', function() {
                    var date = this.getAttribute('data-date');
                    console.log(date)
                    updateTodayEvents(date);
                    updateTodayDate(date);
                });
                row.appendChild(cell);
                date++;
            }
        }
        calendarBody.appendChild(row);
    }
}

var currentDate = new Date();
var currentMonth = currentDate.getMonth();
var currentYear = currentDate.getFullYear();

function updateCalendar(newMonth, newYear) {
    currentMonth = newMonth;
    currentYear = newYear;
    generateCalendar(currentMonth, currentYear);
}

document.getElementById('prevMonth').addEventListener('click', function() {
    var newMonth = currentMonth - 1;
    var newYear = currentYear;
    if (newMonth < 0) {
        newMonth = 11;
        newYear--;
    }
    if (newYear >= currentYear - 1) {
        updateCalendar(newMonth, newYear);
    }
});

document.getElementById('nextMonth').addEventListener('click', function() {
    var newMonth = currentMonth + 1;
    var newYear = currentYear;
    if (newMonth > 11) {
        newMonth = 0;
        newYear++;
    }
    if (newYear <= currentYear + 1) {
        updateCalendar(newMonth, newYear);
    }
});

function getMonthName(monthIndex) {
    var months = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];
    return months[monthIndex];
}

function updateTodayDate(dateStr = null) {
    var date = dateStr ? new Date(dateStr) : new Date();
    var displayDate = `${getMonthName(date.getMonth())} ${date.getDate()}, ${date.getFullYear()}`;
    todayDateHeader.textContent = displayDate;

    var formattedDate = date.toISOString().slice(0, 10);

    document.getElementById('hiddenTodayDate').value = formattedDate;
}

function updateTodayEvents(dateStr) {
    var date = dateStr ? new Date(dateStr) : new Date();
    console.log(date)
    var year = date.getFullYear();
    var month = ('0' + (date.getMonth() + 1)).slice(-2);
    var day = ('0' + date.getDate()).slice(-2);
    var eventDateStr = `${year}-${month}-${day}`;
    console.log(eventDateStr)

    var todayEventsList = document.getElementById('todayEvents');
    todayEventsList.innerHTML = '';

    const eventsByDateRoute = 'https://community-canvas.vercel.app/calendar';
    const assetBaseUrl = 'https://community-canvas.vercel.app/';

    fetch(eventsByDateRoute, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ date: eventDateStr })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data)
        if (data.length > 0) {
            data.forEach((event, index) => {
                var li = document.createElement('li');
                li.innerHTML = `<span class="event-number">${index + 1}.</span> <span class="event-title">${event.title}</span><br><span class="event-description">${event.description}</span>`;
                if (event.picture) {
                    li.innerHTML += `<br><br><img class="event-img" src="${assetBaseUrl}${event.picture}" alt="Event Image">`;
                }
                todayEventsList.appendChild(li);
                console.log(todayEventsList)
            });
        } else {
            var li = document.createElement('li');
            li.textContent = 'Tidak ada acara pada hari ini.';
            li.className = 'no-events';
            todayEventsList.appendChild(li);
        }
    })
    .catch(error => {
        console.error('Error fetching events:', error);
    });
}



updateTodayDate();
updateTodayEvents();
generateCalendar(currentMonth, currentYear);

function showToast(message) {
    var toastContainer = document.getElementById('toastContainer');
    var toast = document.createElement('div');
    toast.classList.add('toast');
    toast.textContent = message;
    toastContainer.appendChild(toast);
    toast.style.display = 'block';

    setTimeout(function() {
        toast.style.display = 'none';
        toastContainer.removeChild(toast);
    }, 4000);
}