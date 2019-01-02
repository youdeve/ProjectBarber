function displayCalendar() {
  // var spinner = createSpinner();
  // $('#calendar').empty().append(spinner);
  $.get(Routing.generate("api_apifullcalendar_getappointement"))
  .done(function(appointments) {
    showCalendars(appointments);
  });
}

function showCalendars(appointments) {
  var initialLocaleCode = 'fr';
  var hasAlreadyRun = false;
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
      end: '21:00', // an end time (6pm in this example)
    },
    slotLabelFormat: [
      'MMMM YYYY', // top level of text
      'ddd'        // lower level of text
    ],
    slotDuration:"00:30:00",
    // displayEventTime: true,
    locale: initialLocaleCode,
    nowIndicator:true,
    maxTime:"21:00",
    minTime:"9:00",
    selectOverlap: false,
    unselectAuto: true,
    allDaySlot: false,
    timeFormat:'H:mm',
    slotLabelFormat:"HH:mm",
    axisFormat: 'H:mm',
    selectable: true,
    // eventRender: function (event, element) {
    //        element.attr('href', 'javascript:void(0);');
    //        element.click(function() {
    //            bootbox.alert({
    //                  message: 'Description : '+event.description,
    //                  title: event.title,
    //            });
    //        });
    //    },
    events: function(start, end, timezone, callback) {
      $.ajax({
        url: Routing.generate('api_apifullcalendar_getappointement'),
        type: 'GET',
        dataType: 'json',
        // data: {
        //   // our hypothetical feed requires UNIX timestamps
        //   start: start.unix(),
        //   end: end.unix()
        // },
        success: function(data) {
          var dataEvent = [];
          for (var key in data) {
            dataEvent = [
              data[key].title,
              data[key].start_appointement,
              data[key].end_appointement
            ];
              // title: data[key].title,
              // start: data[key].start_appointement,
              // end: data[key].end_appointement
            };
            // dataEvent.push(event);
            console.log(dataEvent);
            $('#calendar').fullCalendar('renderEvents', dataEvent, true);
            $('#calendar').fullCalendar('refetchEvents');
        },
        error: function() {
          displayToast( 'Un probléme est survenue au moment de la récupération des événements', 'error');
        }
      });
    },
    // eventSources: [
    //   // your event source
    //   {
    //     url: Routing.generate('api_apifullcalendar_getappointement'),
    //     type: 'GET',
    //     color: "#65a9d7",
    //     textColor: "#3c3d3d",
    //     success: function(data) {
    //       // $('#calendar').fullCalendar('refetchEvents');
    //       var dataEvent = [];
    //       for (var key in data) {
    //         event = {
    //           title: data[key].title,
    //           start: data[key].start_appointement,
    //           end: data[key].end_appointement
    //         };
    //         dataEvent.push(event);
    //       };
    //       $('#calendar').fullCalendar('refetchEvents');
    //       console.log(dataEvent);
    //       $('#calendar').fullCalendar('renderEvents', dataEvent, true);
    //     },
    //     error: function() {
    //        displayToast( 'Un probléme est survenue au moment de la récupération des événements', 'error');
    //      }
    //   }
    // ],
    // eventAfterAllRender: function() {
    //   if (hasAlreadyRun ===  false ) {
    //       hasAlreadyRun = true;
    //       $('#calendar').fullCalendar ('rerenderEvents');
    //   }
    // },
    // events: function() {
    //   $('#calendar').fullCalendar('renderEvents', events, 'stick');
    //
    // },
    dayClick: function(date, jsEvent) {
      var startAppointment = moment().format(date.format());
    },
    select: function(startEvent, endEvent, jsEvent, view) {
      var startAppointment = moment().format(startEvent.format('hh:mm'));
      var endAppointment = moment().format(endEvent.format('hh:mm'));
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

          // $("#calendar").fullCalendar('addEventSource', [{
          //   startAppointment,
          //   endAppointment
          // }, ]);

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
