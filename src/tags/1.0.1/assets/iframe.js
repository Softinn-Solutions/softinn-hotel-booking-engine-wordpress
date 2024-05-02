// >>>>>>>>>>>>>>>>>>>>>>>>>>>Import Iframe Resizer
jQuery(document).ready(function($){
    (function()
    {
        $('.softinn-booking-engine').css("min-height", "920px");
        if (window.iFrameResize == undefined)
        {
            var scriptTag = document.createElement('script');
            scriptTag.setAttribute("type", "text/javascript");
            scriptTag.setAttribute("src", "https://booking.mysoftinn.com/scripts/hotel-website/iframeResizer.min.js");
    
            if (scriptTag.readyState)
            {
                scriptTag.onreadystatechange = function()
                { // For old versions of IE
                    if (this.readyState === 'complete' || this.readyState === 'loaded')
                    {
                        initializeIframeResizer();
                    }
                };
            }
            else
            {
                scriptTag.onload = initializeIframeResizer;
            }
            (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(scriptTag);
        }
    })();

    // >>>>>>>>>>>>>>>>>>>>>>>>>>>Event Listener
    // Create IE + others compatible event handler
    var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
    var eventer = window[eventMethod];
    var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";
    
    // Listen to message from child window
    eventer(messageEvent, function (e) {
        if (e.data == "back-to-top") {
            if ($(".softinn-booking-engine").parent() != undefined) {
                $("html,body").animate({
                    scrollTop: $(".softinn-booking-engine").parent().offset().top
                }, 500);
            }
        }
    }, false);
    
    // Booking Engine Iframe Resizer
    function initializeIframeResizer() {
        $(".softinn-booking-engine").iFrameResize({ log: false, checkOrigin: false });
    };
});