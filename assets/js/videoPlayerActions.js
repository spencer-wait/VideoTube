
/* USED TO CHANGE LIKE AND DISLIKE BUTTON ICONS WHEN PRESSED */

// changes like/dislike icons when video is liked
function likeVideo(button, videoId) {
    $.post("ajax/likeVideo.php", {videoId: videoId})
    .done(function(data) {
        
        var likeButton = $(button);
        var dislikeButton = $(button).siblings(".dislikeButton");

        likeButton.addClass("active");
        dislikeButton.removeClass("active");

        var result = JSON.parse(data);
        updateLikesValue(likeButton.find(".text"), result.likes);
        updateLikesValue(dislikeButton.find(".text"), result.dislikes);

        if(result.likes < 0) {
            likeButton.removeClass("active");
            likeButton.find("img:first").attr("src", "assets/images/icons/thumb-up.png");   // sets default thumbs up icon for like button when video is liked again after already having been liked
        }
        else {
            likeButton.find("img:first").attr("src", "assets/images/icons/thumb-up-active.png") // sets active thumbs up icon for like button when video is liked
        }

        dislikeButton.find("img:first").attr("src", "assets/images/icons/thumb-down.png");  // sets default thumbs down icon for dislike button when video is liked
    });
}

// changes like/dislike icons when video is disliked
function dislikeVideo(button, videoId) {
    $.post("ajax/dislikeVideo.php", {videoId: videoId})
    .done(function(data) {
        
        var dislikeButton = $(button);
        var likeButton = $(button).siblings(".likeButton");

        dislikeButton.addClass("active");
        likeButton.removeClass("active");

        var result = JSON.parse(data);
        updateLikesValue(likeButton.find(".text"), result.likes);
        updateLikesValue(dislikeButton.find(".text"), result.dislikes);

        if(result.dislikes < 0) {
            dislikeButton.removeClass("active");
            dislikeButton.find("img:first").attr("src", "assets/images/icons/thumb-down.png");  // sets default thumbs down icon for dislike button when video is disliked again after already having been disliked
        }
        else {
            dislikeButton.find("img:first").attr("src", "assets/images/icons/thumb-down-active.png")    // sets active thumbs down icon for dislike button when video is disliked
        }

        likeButton.find("img:first").attr("src", "assets/images/icons/thumb-up.png");   // sets default thumbs up icon for like button when video is disliked
    });
}

// updates like/dislike values
function updateLikesValue(element, num) {
    var likesCountVal = element.text() || 0;
    element.text(parseInt(likesCountVal) + parseInt(num));
}