jQuery(document).ready(function($){
    var syncIsoValue = function ($display, $hidden) {
        var v = $display.val();
        if (!v) { $hidden.val(''); return; }
        try {
            var d = $.datepicker.parseDate('dd MM yy', v);
            $hidden.val($.datepicker.formatDate('yy-mm-dd', d));
        } catch (err) {
            $hidden.val('');
        }
    };

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
        syncIsoValue($fromDisplay, $fromHidden);
        syncIsoValue($toDisplay, $toHidden);

        // Restore checkout minDate based on restored check-in value
        if ($fromDisplay.val()) {
            try {
                var restoredFrom = $.datepicker.parseDate('dd MM yy', $fromDisplay.val());
                var minCheckout = new Date(restoredFrom);
                minCheckout.setDate(minCheckout.getDate() + 1);
                $toDisplay.datepicker('option', 'minDate', minCheckout);
            } catch (err) {}
        }

        $toDisplay.datepicker({
            dateFormat: 'dd MM yy',
            allowInputToggle: true,
            onSelect: function(dateText) {
                var date = $.datepicker.parseDate('dd MM yy', dateText);
                $toHidden.val($.datepicker.formatDate('yy-mm-dd', date));
            }
        });

        $fromDisplay.datepicker({
            dateFormat: 'dd MM yy',
            minDate: 1,
            allowInputToggle: true,
            buttonImageOnly: true,
            onSelect: function(dateText) {
                var date = $.datepicker.parseDate('dd MM yy', dateText);
                $fromHidden.val($.datepicker.formatDate('yy-mm-dd', date));
                var minDate = new Date(date);
                minDate.setDate(minDate.getDate() + 1);
                $toDisplay.datepicker('option', 'minDate', minDate);
            }
        });
    });
});
