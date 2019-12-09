
/* USED TO UPDATE SUBSCRIBE BUTTON ONCE CLICKED */

function subscribe(userTo, userFrom, button) {
    
    // make sure user can't subscribe to self
    if(userTo == userFrom) {
        alert("You can't subscribe to yourself.");
        return;
    }

    // call to ajax file to query subscribers
    $.post("ajax/subscribe.php", {userTo: userTo, userFrom: userFrom})
    .done(function(count) {
        
        // change subscribe button after sub/unsub
        if(count != null) {
            $(button).toggleClass("subscribe unsubscribe");

            var buttonText = $(button).hasClass("subscribe") ? "SUBSCRIBE" : "SUBSCRIBED";
            $(button).text(buttonText + " " + count);
        }
        else {
            alert("Something went wrong.");
        }

    });
}