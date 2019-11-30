<?php
class ButtonProvider {

    public static $signInFunction = "notSignedIn()";

    public static function createLink($link) {
        return User::isLoggedIn() ? $link : ButtonProvider::$signInFunction;
    }

    public static function createButton($text, $imageSrc, $action, $class) {

        $image = ($imageSrc == null) ? "" : "<img src='$imageSrc'>";

        $action = ButtonProvider::createLink($action);

        return "<button class='$class' onclick='$action'>
                    $image
                    <span class='text'>$text</span>
                </button>";
    }

    public static function createHyperlinkButton($text, $imageSrc, $href, $class) {

        $image = ($imageSrc == null) ? "" : "<img src='$imageSrc'>";

        return  "<a href='$href'>
                    <button class='$class' onclick='$href'>
                        $image
                        <span class='text'>$text</span>
                    </button>
                </a>";
    }

    public static function createUserProfileButton($con, $username) {
        $userObj = new User($con, $username);
        $profilePic = $userObj->getProfilePic();
        $link = "profile.php?username=$username";

        return  "<a href='$link'>
                    <img src='$profilePic' class='profilePicture'>
                </a>";
    }

    public static function createEditVideoButton($videoId) {
        $href = "editVideo.php?videoId=$videoId";

        $button = ButtonProvider::createHyperlinkButton("EDIT VIDEO", null, $href, "edit button");

        return  "<div class='editVideoButtonContainer'>
                    $button
                </div>";
    }

}
?>