jQuery(document).ready(function($){
  (function()
  {
    var fullmonth_array = $.datepicker._defaults.monthNames;
    $("#to").datepicker({ dateFormat: 'dd MM yy',allowInputToggle: true });
    $("#from").datepicker({ dateFormat: 'dd MM yy',minDate: 1, allowInputToggle: true,
    buttonImageOnly: true }).bind("change",function(){
        var minValue = $(this).val();
        minValue = $.datepicker.parseDate("dd MM yy", minValue);
        minValue.setDate(minValue.getDate()+1);
        $("#to").datepicker( "option", "minDate", minValue );
    })
  })(jQuery);
});