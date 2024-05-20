(function ($) {
    "use strict";

    // :: Variables
    var flapt_window = $(window);
    var pageWrapper = $(".flapt-page-wrapper");
    var sideMenuArea = $(".flapt-sidemenu-wrapper");
    var fullScreen = $("body")[0];



    // :: Slimscroll Active Code
    if ($.fn.slimscroll) {
        $('#flaptSideNav').slimscroll({
            height: '100%',
            size: '2px',
            position: 'right',
            color: '#8c8c8c',
            alwaysVisible: false,
            distance: '0px',
            railVisible: false,
            touchScrollStep : 75,
            wheelStep: 10,
        });
    }


    // :: Slimscroll Active Code
    if ($.fn.slimscroll) {
        $('#messageBox, #notificationsBox').slimscroll({
            height: '345px',
            size: '4px',
            position: 'right',
            color: '#ebebeb',
            alwaysVisible: false,
            distance: '0px',
            railVisible: false,
            wheelStep: 15
        });
    }
   
    // :: Menu Active Code
    $("#menuCollasped").on("click", function () {
        pageWrapper.toggleClass("menu-collasped-active");
    });

    $("#mobileMenuOpen").on("click", function () {
        pageWrapper.toggleClass("mobile-menu-active");
    });

    $("#rightSideTrigger").on("click", function () {
        $(".right-side-content").toggleClass("active");
    });

    sideMenuArea.on("mouseenter", function () {
        pageWrapper.addClass("sidemenu-hover-active");
        pageWrapper.removeClass("sidemenu-hover-deactive");
    });

    sideMenuArea.on("mouseleave", function () {
        pageWrapper.removeClass("sidemenu-hover-active");
        pageWrapper.addClass("sidemenu-hover-deactive");
    });

    // :: Setting Panel Active Code
    $("#settingTrigger").on("click", function () {
        $(".choose-layout-area").toggleClass("active");
    });

    $("#settingCloseIcon").on("click", function () {
        $(".choose-layout-area").removeClass("active");
    })

    $("#quicksettingTrigger").on("click", function () {
        $(".quick-settings-panel").toggleClass("active");
    });

    $("#quicksettingCloseIcon").on("click", function () {
        $(".quick-settings-panel").removeClass("active");
    })


    // :: Nice Select Active Code
    if ($.fn.niceSelect) {
        $('select').niceSelect();
    }


    // :: Preloader Active Code
    flapt_window.on('load', function () {
        $('#preloader').fadeOut('slow', function () {
            $(this).remove();
        });
    });

})(jQuery);