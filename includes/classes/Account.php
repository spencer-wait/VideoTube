<?php

/* USED FOR ACCOUNT CREATION */

class Account {

    private $con;   // variable used to connect to database
    private $errorArray = array();  // array used to display multiple errors to user when creating account

    public function __construct($con) { // establish connection variable
        $this->con = $con;
    }

    // function to check account table for user to log in
    public function login($un, $pw) {
        $pw = hash("sha512", $pw);  // hash the password for secrecy puposes using sha512

        // check users table for log in information
        $query = $this->con->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");
        $query->bindParam(":un", $un);
        $query->bindParam(":pw", $pw);

        $query->execute();

        if($query->rowCount() == 1) {   // user information is in the table
            return true;
        }
        else {  // user information is not in the table
            array_push($this->errorArray, Constants::$loginFailed);
            return false;
        }
    }
    
    // account creation function to validate register information and insert into database table
    public function register($fn, $ln, $un, $em, $em2, $pw, $pw2) {
        // validate each input field
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateUsername($un);
        $this->validateEmails($em, $em2);
        $this->validatePasswords($pw, $pw2);

        // make sure there are no errors before inserting data to table
        if(empty($this->errorArray)) {
            return $this->insertUserDetails($fn, $ln, $un, $em, $pw);
        }
        else {
            return false;
        }
    }

    // querys to insert account creation user details into database table
    public function insertUserDetails($fn, $ln, $un, $em, $pw) {
        
        $pw = hash("sha512", $pw);  // hash the password for secrecy puposes using sha512
        $profilePic = "assets/images/profilePictures/default.png";  // set the user profile picture to default picture

        $query = $this->con->prepare("INSERT INTO users (firstName, lastName, username, email, password, profilePic)
                                        VALUES(:fn, :ln, :un, :em, :pw, :pic)");

        $query->bindParam(":fn", $fn);
        $query->bindParam(":ln", $ln);
        $query->bindParam(":un", $un);
        $query->bindParam(":em", $em);
        $query->bindParam(":pw", $pw);
        $query->bindParam(":pic", $profilePic);
        
        return $query->execute();
    }
    

    /* ACCOUNT CREATION DATA FIELD VALIDATION FUNCTIONS */

    private function validateFirstName($fn) {
        if(strlen($fn) > 25 || strlen($fn) < 2) {   // name must be between 2 and 25 characters
            array_push($this->errorArray, Constants::$firstNameCharacters); // set an error otherwise
        }
    } 

    private function validateLastName($ln) {
        if(strlen($ln) > 25 || strlen($ln) < 2) {   // last name must be between 2 and 25 characters
            array_push($this->errorArray, Constants::$lastNameCharacters);  // set an error otherwise
        }
    }

    private function validateUsername($un) {
        if(strlen($un) > 25 || strlen($un) < 5) {   // username must be between 5 and 25 characters
            array_push($this->errorArray, Constants::$usernameCharacters);  // set an error otherwise
            return;
        }

        // check database table for matching username since username must be unique
        $query = $this->con->prepare("SELECT username FROM users WHERE username=:un");
        $query->bindParam(":un", $un);
        $query->execute();

        if($query->rowCount() != 0) {   // if there is a matching username in table then set an error
            array_push($this->errorArray, Constants::$usernameTaken);
        }
    }

    private function validateEmails($em, $em2) {
        if($em != $em2) {   // both emails entered must match
            array_push($this->errorArray, Constants::$emailsDoNotMatch);    // set an error otherwise
            return;
        }

        if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {   // must be in the format of an email xxx@xxx.com
            array_push($this->errorArray, Constants::$emailInvalid);    // set an error otherwise
            return;
        }

        // search database table for passwords that match the entered password
        $query = $this->con->prepare("SELECT email FROM users WHERE email=:em");
        $query->bindParam(":em", $em);
        $query->execute();

        if($query->rowCount() != 0) {   // if password already exists in table then output to error array
            array_push($this->errorArray, Constants::$emailTaken);  // set an error otherwise
        }
    }

    private function validatePasswords($pw, $pw2) {
        if($pw != $pw2) {   // both passwords entered must match
            array_push($this->errorArray, Constants::$passwordsDoNotMatch); // set an error otherwise
            return;
        }

        if(preg_match("/[^A-Za-z0-9]/", $pw)) { // password must be letter or digit
            array_push($this->errorArray, Constants::$passwordNotAlphanumeric); // set an error otherwise
            return;
        }

        if(strlen($pw) > 30 || strlen($pw) < 5) { // password must be between 5 and 30 characters in length
            array_push($this->errorArray, Constants::$passwordLength);  // set an error otherwise
        }
    }
    

    // function to print all errors stored in the error array from previous validation checks
    public function getError($error) {
        if(in_array($error, $this->errorArray)) {
            return "<span class='errorMessage'>$error</span>";
        }
    }
}
?>