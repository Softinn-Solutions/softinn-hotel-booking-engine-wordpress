jQuery(document).ready(function($){
  (function()
  {
    var $fromDisplay = $("#from").removeAttr("name");
    var $toDisplay = $("#to").removeAttr("name");

    var $fromHidden = $('<input type="hidden" name="startDate">').insertAfter($fromDisplay);
    var $toHidden = $('<input type="hidden" name="endDate">').insertAfter($toDisplay);

    $toDisplay.datepicker({
        dateFormat: 'dd MM yy',
        allowInputToggle: true,
        onSelect: function(dateText) {
            var date = $.datepicker.parseDate("dd MM yy", dateText);
            $toHidden.val($.datepicker.formatDate("yy-mm-dd", date));
        }
    });

    $fromDisplay.datepicker({
        dateFormat: 'dd MM yy',
        minDate: 1,
        allowInputToggle: true,
        buttonImageOnly: true,
        onSelect: function(dateText) {
            var date = $.datepicker.parseDate("dd MM yy", dateText);
            $fromHidden.val($.datepicker.formatDate("yy-mm-dd", date));
            var minDate = new Date(date);
            minDate.setDate(minDate.getDate() + 1);
            $toDisplay.datepicker("option", "minDate", minDate);
        }
    });
  })(jQuery);
});
