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
            likeButton.find("img:first").attr("src", "assets/images/icons/thumb-up.png");
        }
        else {
            likeButton.find("img:first").attr("src", "assets/images/icons/thumb-up-active.png");
        }

        dislikeButton.find("img:first").attr("src", "assets/images/icons/thumb-down.png");
    });
}

function updateLikesValue(element, num) {
    var likesCountVal = element.text() || 0;
    element.text(parseInt(likesCountVal) + parseInt(num));
}