document.addEventListener('DOMContentLoaded', function () {
    var calendarDiv = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarDiv, {
        plugins: ['dayGrid'],
        events: '../../PHP/Calendar/retrieve.php'
    });

    calendar.render();
});
