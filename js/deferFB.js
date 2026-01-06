jQuery(window).on('load', function() {
    jQuery.ajaxSetup({cache: true });
    jQuery.getScript("https://connect.facebook.net/en_US/sdk.js", function() {
        FB.init({
            xfbml : true,
            version : 'v3.2'
        });
    });
});