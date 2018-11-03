// Initialize Materialize components

$(".button-collapse").sideNav();
$('.tooltipped').tooltip({delay: 50});
$('select').material_select();
 // $('.collapsible').collapsible();
 $('.button-collapse').sideNav({
      menuWidth: 300, // Default is 300
      edge: 'left', // Choose the horizontal origin
      closeOnClick: true, // Closes side-nav on &lt;a> clicks, useful for Angular/Meteor
      draggable: true, // Choose whether you can drag to open on touch screens,
    }
  );

// Transformation des div.flash_message en Tooltip Materialze
$(".flash-message").each(function () {
  var message = $(this).html();
  displayToast(message, $(this).attr('toastType'), 10000);
});


function displayToast(message, flag, time) {
  flag = flag || 'notice';
  time = time || 7000;
  var color = "white", iconId ="", icon;
  switch (flag) {
    case 'error':
      iconId = 'fa-times-circle-o';
      color = 'red';
        break;
    case 'success':
      iconId = 'fa-check-circle-o';
      color = 'green';
        break;
    case 'notice':
      iconId = 'fa-info-circle';
        break;
  }
  icon = '<i style="color:' + color + '; margin-right:5px;" class="fa ' + iconId + '"></i> ';
  if (message !== undefined) Materialize.toast(icon + message, time);
}
