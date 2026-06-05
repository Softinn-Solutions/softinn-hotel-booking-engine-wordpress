jQuery(document).ready(function($){
    // iframeResizer is loaded as a WordPress script dependency
    $(".softinn-booking-engine").iFrameResize({ log: false, checkOrigin: false });

    window.addEventListener("message", function (e) {
        if (e.origin !== "https://booking.mysoftinn.com") return;
        if (e.data === "back-to-top") {
            var $iframe = $(".softinn-booking-engine");
            if ( $iframe.parent().length ) {
                $("html,body").animate({ scrollTop: $iframe.parent().offset().top }, 500);
            }
        }
    }, false);
});