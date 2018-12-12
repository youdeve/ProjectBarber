function displayCalendar() {
  var spinner = createSpinner();
  $('#calendar').empty().append(spinner);

  $.get(Routing.generate("api_apifullcalendar_getappointement"))
  .done(function(appointments) {
    showCalendars(appointments);
  });
}

function showCalendars(appointments) {
  var initialLocaleCode = 'fr';

  $('#calendar').fullCalendar({
    defaultView: 'agendaWeek',
    header: {
      left: 'prev,next',
      center: 'title',
      right: 'agendaDay,month,agendaWeek'
    },
    events: {
    },
    businessHours: {
      // days of week. an array of zero-based day of week integers (0=Sunday)
      dow: [ 1, 2, 3, 4, 5, 6 ], // Monday - sunday
      start: '9:00', // a start time (10am in this example)
      end: '20:00', // an end time (6pm in this example)
    },
    slotLabelFormat: [
      'MMMM YYYY', // top level of text
      'ddd'        // lower level of text
    ],
    slotDuration:"00:30:00",
    // displayEventTime: true,
    locale: initialLocaleCode,
    nowIndicator:true,
    maxTime:"19:00",
    minTime:"9:00",
    selectOverlap: false,
    unselectAuto: true,
    allDaySlot: false,
    timeFormat:'H:mm',
    slotLabelFormat:"HH:mm",
    axisFormat: 'H:mm',
    selectable: true,
    eventSources: [
      // your event source
      {
        url: '/api/appointments',
        type: 'GET',
        color: "#65a9d7",
        textColor: "#3c3d3d",
        success: function(data) {
          for (var key in data) {
            $('#calendar').fullCalendar('renderEvent', {
              // title:data[key].title,
              start:data[key].start_appointement,
              end:data[key].end_appointement
            }, "stick");
          };
          console.log(data[key]);
        },
        error: function() {
          displayToast( 'Un probléme est survenue au moment de la récupération des événements', 'error');
        }
      }
    ],
    // events: function() {
    //   $('#calendar').fullCalendar('renderEvents', events, 'stick');
    //
    // },
    dayClick: function(date, jsEvent) {
      // $('#calendar').fullCalendar('unselect');
      // $('#calendar').fullCalendar('removeEvents');
      // $('#calendar').fullCalendar('refetchEvents');
      var startAppointment = moment().format(date.format());
    },
    select: function(startEvent, endEvent, jsEvent, view) {
      var startAppointment = moment().format(startEvent.format('hh:mm'));
      var endAppointment = moment().format(endEvent.format('hh:mm'));
      // start = startEvent.format('hh:mm');
      // end = endEvent.format('hh:mm');
      $('#dateSelected').html(startAppointment);
      $('#dateSelectedEnd').html(endAppointment);

      $('#addEvents').modal({
        complete: function() {
        }
      });
      $('#addEvents').modal('open');

      $('#btnAddEvent').on('click', function(e) {
        e.preventDefault();
        var selectedPrestationId = $("#selectedPrestation").find(':selected').data('price');
        var SelectedCredit = $("#selectedPrestation").find(':selected').data('credit');
        var selectedPrestation = $("#selectedPrestation option:selected").text();
        var selectedBarber = $("#selectedBarber option:selected").val();
        console.log(selectedPrestationId);
        var start = startEvent.format('hh:mm:ss');
        var end = endEvent.format('hh:mm:ss');

        if (selectedPrestation) {
          $.ajax(Routing.generate('api_apifullcalendar_postappointement'),
          {
            data:{
              start: startAppointment,
              end: endAppointment,
              selectedBarber: selectedBarber,
              prestation: selectedPrestation,
              idPrestation:selectedPrestationId,
              SelectedCredit: SelectedCredit
            },
            type:"POST",
          }).done(function(response) {
            displayToast(response, 'success');
            // $('#calendar').fullCalendar('renderEvent', data, true);
            // $('#calendar').fullCalendar('unselect');
          }).fail(function () {
            displayToast( 'Probléme avec le serveur veuillez rééssayer', 'error');
          });

          $("#calendar").fullCalendar('addEventSource', [{
            startAppointment,
            endAppointment
          }, ]);

          $('#calendar').fullCalendar('unselect');
        }else {
          $('#calendar').fullCalendar('unselect');
          displayToast("Le champ intitulé de la prestation est vide", 'notice');
        }

      });
      $('#calendar').fullCalendar('unselect');
      $('#titleEvent').val('');
      $('#startEndDate').val('');
      $("#selectedBarber option:selected").val("")
      // $('#dateSelected').html('');
      jQuery(document).on('keyup',function(evt) {
        if (evt.keyCode == 27) {
          $('#calendar').fullCalendar('unselect');
          $('#titleEvent').val('');
          $('#startEndDate').val('');
          $("#selectedBarber option:selected").val("")
          $('#dateSelected').html('');
          $('#calendar').fullCalendar('refetchEvents');
        }
      });

    },

  })



  // $('#calendar').fullCalendar({
  //   // themeSystem: 'bootstrap3',
  //   defaultView: 'agendaWeek',
  //   header: {
  //     left: 'prev,next',
  //     center: 'title',
  //     right: 'agendaDay,month,agendaWeek'
  //   },
  //   businessHours: {
  //     // days of week. an array of zero-based day of week integers (0=Sunday)
  //     dow: [ 1, 2, 3, 4, 5, 6 ], // Monday - Thursday
  //     start: '9:00', // a start time (10am in this example)
  //     end: '20:00', // an end time (6pm in this example)
  //   },
  //   slotLabelFormat: [
  //     'MMMM YYYY', // top level of text
  //     'ddd'        // lower level of text
  //   ],
  //   slotDuration:"00:30:00",
  //   // displayEventTime: true,
  //   locale: initialLocaleCode,
  //   nowIndicator:true,
  //   maxTime:"19:00",
  //   minTime:"9:00",
  //   selectOverlap: false,
  //   unselectAuto: true,
  //   allDaySlot: false,
  //   timeFormat:'H:mm',
  //   slotLabelFormat:"HH:mm",
  //   axisFormat: 'H:mm',
  //   selectable: true,
  //   eventLimit: true, // allow "more" link when too many events
  //   // editable: true,
  //   // selectHelper: true,
  //   // events: '/api/appointments',
  //   eventSources: [
  //     // your event source
  //     {
  //       url: '/api/appointments',
  //       type: 'GET',
  //       color: "#65a9d7",
  //       textColor: "#3c3d3d",
  //       success: function(data) {
  //         // for (var i = 0; i < data.length; i++) {
  //         //   $('#calendar').fullCalendar('renderEvents', {
  //         //     title:data[i].title,
  //         //     start:data[i].start_appointement,
  //         //     end:data[i].end_appointement
  //         //   }, true);
  //         // }
  //         for (var key in data) {
  //           console.log(data[key]);
  //           $('#calendar').fullCalendar('renderEvent', {
  //             title:data[key].title,
  //             start:data[key].start_appointement,
  //             end:data[key].end_appointement
  //           }, true);
  //         }
  //         // $('#calendar').fullCalendar( 'refetchEvents');
  //       },
  //       error: function() {
  //         displayToast( 'Un probléme est survenue au moment de la récupération des événements', 'error');
  //       }
  //     }
  //   ],
  //   eventClick: function(calevent, jsEvent, view) {
  //     calevent.start.locale('fr');
  //     start = calevent.start.format('dddd Do MMMM YYYY à h:mm');
  //     end = calevent.end.format('h:mm');
  //
  //     var styles = {
  //       color : "#E93C0F",
  //       fontWeight: "500"
  //     };
  //     var title =$('#titleEvent').val(calevent.title);
  //     var dateRange = $('#startEndDate').val(start +' - '+ end);
  //     dateRange.css(styles);
  //     title.css(styles);
  //     $('#showEvents').modal('open');
  //   },
  //   unselect: function(jsEvent) {
  //     // $('#calendar').fullCalendar('unselect');
  //   },
  //   select: function(startEvent, endEvent, jsEvent, view) {
  //
  //     start = startEvent.format('hh:mm');
  //     end = endEvent.format('hh:mm');
  //
  //     $('#dateSelected').html(start);
  //     $('#dateSelectedEnd').html(end);
  //     console.log(end);
  //
  //     $('#addEvents').modal({
  //       complete: function() {
  //         $('#calendar').fullCalendar('unselect');
  //       }
  //     });
  //     $('#addEvents').modal('open');
  //
  //     $('#btnAddEvent').on('click', function(e) {
  //       e.preventDefault();
  //
  //       var selectedBarber = $("#selectedBarber option:selected").val();
  //       console.log(selectedBarber);
  //       var title = $('#titleEvent').val();
  //
  //       var start = startEvent.format('hh:mm:ss');
  //       var end = endEvent.format('hh:mm:ss');
  //
  //       if (title) {
  //         $.ajax(Routing.generate('api_apifullcalendar_postappointement'),
  //         {
  //           data:{
  //             title: title,
  //             start: start,
  //             end: end,
  //             selectedBarber: selectedBarber
  //           },
  //           type:"POST",
  //         }).done(function(response) {
  //           displayToast(response, 'success');
  //           // $('#calendar').fullCalendar('renderEvent', data, true);
  //           // $('#calendar').fullCalendar('unselect');
  //         }).fail(function () {
  //           displayToast( 'Probléme avec le serveur veuillez rééssayer', 'error');
  //         });
  //       }else {
  //         displayToast("Le champ intitulé de la prestation est vide", 'notice');
  //       }
  //
  //     });
  //
  //     $('#calendar').fullCalendar('unselect');
  //     $('#titleEvent').val('');
  //     $('#startEndDate').val('');
  //     $("#selectedBarber option:selected").val("")
  //     // $('#dateSelected').html('');
  //     jQuery(document).on('keyup',function(evt) {
  //       if (evt.keyCode == 27) {
  //         $('#calendar').fullCalendar('unselect');
  //         $('#titleEvent').val('');
  //         $('#startEndDate').val('');
  //         $("#selectedBarber option:selected").val("")
  //         $('#dateSelected').html('');
  //         $('#calendar').fullCalendar('refetchEvents');
  //       }
  //     });
  //   },
  // });
};

$('#btnClose').on('click', function(e) {
  console.log('clique sur annuler');
  e.preventDefault();
  $('#titleEvent').val('');
  $("#selectedBarber option:selected").val("")
  $('#startEndDate').html('');
  $('#calendar').fullCalendar('unselect');
});



$(document).ready(function() {

  // setInterval(function(){ displayCalendar() }, 30000);
  $('#addEvents').modal();
  $('#showEvents').modal();
  displayCalendar();

});
