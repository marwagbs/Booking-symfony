fetch(route)
.then(response=>response.json())
.then(function(events){

});

let calendarEl = document.getElementById('calendar');

let calendar = new FullCalendar.Calendar(calendarEl, {
  headerToolbar: {
    left: 'prevYear,prev,next,nextYear today',
    center: 'title',
    right: 'dayGridMonth'
  },
  validRange: { start: new Date },
  initialDate: new Date,
  navLinks: true, // can click day/week names to navigate views
  editable: true,
  dayMaxEvents: true, // allow "more" link when too many events
  events: [
    
    {
      title: 'Long Event',
      start: '2022-12-01',
      end: '2022-12-10'
    },
    {
      title: 'Long Event',
      start: '2022-11-15',
      end: '2022-11-28'
    }
  ]
});

calendar.render();