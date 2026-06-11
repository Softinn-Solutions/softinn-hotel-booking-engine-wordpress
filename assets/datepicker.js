jQuery(document).ready(function($){
    $('.softinn-calendarwidget').each(function(index) {
        var $form = $(this).find('form');
        var uid = 'softinn-' + index;

        var $fromDisplay = $form.find('[placeholder="Check-in"]')
            .removeAttr('name')
            .attr('id', uid + '-from');
        var $toDisplay = $form.find('[placeholder="Check-out"]')
            .removeAttr('name')
            .attr('id', uid + '-to');

        var $fromHidden = $('<input type="hidden" name="startDate">').insertAfter($fromDisplay);
        var $toHidden = $('<input type="hidden" name="endDate">').insertAfter($toDisplay);

        // Initialise hidden fields from restored display values (e.g. bfcache back/forward)
        if ($fromDisplay.val()) {
            try {
                $fromHidden.val($.datepicker.formatDate("yy-mm-dd", $.datepicker.parseDate("dd MM yy", $fromDisplay.val())));
            } catch(e) {}
        }
        if ($toDisplay.val()) {
            try {
                $toHidden.val($.datepicker.formatDate("yy-mm-dd", $.datepicker.parseDate("dd MM yy", $toDisplay.val())));
            } catch(e) {}
        }

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
    });
});
