// Avoid `console` errors in browsers that lack a console.
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

//----------------------------------------------------------------------------------------------------------------------

    function enter(selector, action)
    {
        // enable enter key
        $(selector).keypress(function (e) {
          if (e.which == 13) {

            // if selector focus on another element
            if (typeof action==='string')
            {
                // just go to a next one (table forms only)
                if (action=='next')
                    $(this).closest('tr').next().find('input').focus();
                else
                    $(action).focus();
            }

            // or call the callback if set...
            if (typeof action==='function')
            {
                action();
            }
          }
        });

    }

//----------------------------------------------------------------------------------------------------------------------

    function notification(type, msg)
    {
        $(".alert_box").hide();
        $(".alert_box."+type).find('.msg').html(msg);
        $(".alert_box."+type).show();
    }

//----------------------------------------------------------------------------------------------------------------------
