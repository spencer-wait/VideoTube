
/* USED FOR COMMON WEBSITE ACTIONS SUCH AS MENUS */

$(document).ready(function() {
    
    $(".navShowHide").on("click", function() {  // left menu shows and hides upon each click
        
        var main = $("#mainSectionContainer");
        var nav = $("#sideNavContainer");

        if(main.hasClass("leftPadding")) {
            nav.hide();
        }
        else {
            nav.show();
        }

        main.toggleClass("leftPadding");
    });
});

function notSignedIn() {
    alert("You must be signed in to perform this action");
}