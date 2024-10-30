jQuery(document).ready(function($) {
  $('.cf7-datepicker').datepicker({
     autoclose: true,
     showAnim: setting.effect,
     changeMonth: setting.monyearmenu,
     changeYear: setting.monyearmenu,
     showWeek: setting.showWeek,
  });


  //verion 1.0 fail-safe
  $('#cf7-datepicker').datepicker({
     autoclose: true,
     showAnim: setting.effect,
     changeMonth: setting.monyearmenu,
     changeYear: setting.monyearmenu,
     showWeek: setting.showWeek,
  });

});