(function ($) {
    // Fallback to meta tag on outdated browsers 
    if (!'localStorage' in window) {
        var meta = $('#autologout').html();
        $('head').append(meta);
        return;
    }
    
    // Sets/Resets a timer for redirection to logout
    var timeout = null;
    function resetTimer (time_to_logout, notify) {
        if (timeout !== null) {
            window.clearTimeout(timeout);
        }
        
        var delay = time_to_logout - +(new Date);
        timeout = window.setTimeout(function () {
            window.location = STUDIP.URLHelper.getURL('index.php');
        }, delay);

        if (notify) {
            window.localStorage.setItem('autologout', time_to_logout);
        }
    }

    // On change in another tab
    $(window).on('storage.autologout', function (event) {
        event = event.originalEvent;
        if (event.key === 'autologout') {
            resetTimer(event.newValue);
        }
    });
    
    // Try to prevent redirect if user becomes active "just in time"
    $(window).on('unload', function () {
        clearTimeout(timeout);
        $(window).off('storage.autologout');
    });
    
    // Read delay value from noscript-block
    $(document).ready(function () {
        var delay   = $('#autologout').data().delay * 1000;
        resetTimer(+(new Date) + delay, true);
    });
}(jQuery));