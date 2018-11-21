// Initialize Materialize components
$('.tooltipped').tooltip({delay: 50});
$('select').material_select();

$(".button-collapse").sideNav();


function createSpinner() {
  var spinner = $('<div style="color:#fff" class="center-align loader"></div>').css('display', 'none');
  var spinnerLayer = $('<div class="spinner-layer spinner-red-only"></div>').css('border-color', 'red');
  var circle = $('<div class="circle"></div>');
  spinner.append($('<div class="preloader-wrapper small active center-align"></div>').append(spinnerLayer));
  $('<div class="circle-clipper left"></div>').append(circle).appendTo(spinnerLayer);
  $('<div class="gap-patch"></div>').append(circle).appendTo(spinnerLayer);
  $('<div class="circle-clipper right"></div>').append(circle).appendTo(spinnerLayer);
  console.log('spinner',spinner);
  return spinner;
}

$(window).load(function() {
	$(".loader").fadeOut("1000");
})

// Transformation des div.flash_message en Tooltip Materialze
$(".flash-message").each(function () {
  var message = $(this).html();
  displayToast(message, $(this).attr('toastType'), 10000);
});


function displayToast(message, flag, time) {
  flag = flag || 'notice';
  time = time || 7000;
  var color = "black", iconId ="", icon;
  switch (flag) {
    case 'error':
      iconId = 'clear';
      color = 'red';
        break;
    case 'success':
      iconId = 'done';
      color = 'green';
        break;
    case 'notice':
      iconId = 'error_outline';
        break;
  }
  icon = '<i style="color:' + color + '; margin-right:5px;" class="material-icons">'+iconId+'</i> ';
  message = '<span style="color:'+color+';">'+message+'</span>'
  if (message !== undefined) Materialize.toast(icon + message, time);
}
