jQuery(document).ready(function() {
    jQuery(window).resize(function() {
        console.log("Resizing");
        setTimeout(function() {
            let imgheight = parseInt(jQuery('#mediatext_videowrapper').css("padding-top"));
            let containerheight = jQuery('.mediatext_imagewrapper').height();

            console.log(imgheight + " " + containerheight);

            jQuery("#mediatext_videowrapper").css("margin-top", ((containerheight - imgheight) / 2) + "px");
        }, 300);
    });
});