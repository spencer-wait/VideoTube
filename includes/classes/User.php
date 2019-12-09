<?php

/* USED TO GET USER INFORMATION FROM DATABASE */

class User {

    private $con, $sqlData; // database connection variables

    public function __construct($con, $username) {
        $this->con = $con;

        // search for username to get user data from database
        $query = $this->con->prepare("SELECT * FROM users WHERE username = :un");
        $query->bindParam(":un", $username);
        $query->execute();

        $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);   // database variable becomes user data from database table
    }

    public static function isLoggedIn() {   // check if user is logged in
        return isset($_SESSION["userLoggedIn"]);
    }
    
    public function getUsername() { // get username from database variable
        return $this->sqlData["username"];
    }

    public function getName() { // get user name from database variable
        return $this->sqlData["firstName"] . " " . $this->sqlData["lastName"];
    }

    public function getFirstName() {    // get user first name from database variable
        return $this->sqlData["firstName"];
    }

    public function getLastName() {    // get user last name from database variable
        return $this->sqlData["lastName"];
    }

    public function getEmail() {    // get user email from database variable
        return $this->sqlData["email"];
    }

    public function getProfilePic() {   // get user profile picture from database variable
        return $this->sqlData["profilePic"];
    }

    public function getSignUpDate() {   // get user sign up date from database variable
        return $this->sqlData["signUpDate"];
    }

    public function isSubscribedTo($userTo) {   // search database for who the user is subscribed to
        $query = $this->con->prepare("SELECT * FROM subscribers WHERE userTo=:userTo AND userFrom=:userFrom");
        $query->bindParam(":userTo", $userTo);
        $query->bindParam(":userFrom", $username);
        $username = $this->getUsername();
        $query->execute();
        return $query->rowCount() > 0;
    }

    public function getSubscriberCount() {  // search database table to find how many subscribers the user has
        $query = $this->con->prepare("SELECT * FROM subscribers WHERE userTo=:userTo");
        $query->bindParam(":userTo", $username);
        $username = $this->getUsername();
        $query->execute();
        return $query->rowCount();
    }

}
?>