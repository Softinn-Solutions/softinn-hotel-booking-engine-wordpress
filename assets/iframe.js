jQuery(document).ready(function($){
    $('.softinn-booking-engine').css("min-height", "920px");

    // Listen to message from child window
    var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
    var eventer = window[eventMethod];
    var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";

    eventer(messageEvent, function (e) {
        if (e.origin !== "https://be.mysoftinn.com") { return; }
        var iframes = document.querySelectorAll('.softinn-booking-engine');
        var fromOurIframe = false;
        for (var i = 0; i < iframes.length; i++) {
            if (e.source === iframes[i].contentWindow) { fromOurIframe = true; break; }
        }
        if (!fromOurIframe) { return; }
        if (e.data == "back-to-top") {
            if ($(".softinn-booking-engine").parent() != undefined) {
                $("html,body").animate({
                    scrollTop: $(".softinn-booking-engine").parent().offset().top
                }, 500);
            }
        }
    }, false);
});
