<?php

/* USED TO CLEAN (SANITIZE) AND UNIVERSALIZE INPUT STRINGS FROM USER */

class FormSanitizer {

    public static function sanitizeFormString($inputText) {
        $inputText = strip_tags($inputText);            // remove all symbols in string
        $inputText = str_replace(" ", "", $inputText);  // remove all spaces in string
        $inputText = strtolower($inputText);            // turns to lowercase
        $inputText = ucfirst($inputText);               // turns first letter uppercase
        return $inputText;
    }

    public static function sanitizeFormUsername($inputText) {
        $inputText = strip_tags($inputText);            // remove all symbols in string
        $inputText = str_replace(" ", "", $inputText);  // remove all spaces in string
        return $inputText;
    }

    public static function sanitizeFormPassword($inputText) {
        $inputText = strip_tags($inputText);            // remove all symbols in string
        return $inputText;
    }

    public static function sanitizeFormEmail($inputText) {
        $inputText = strip_tags($inputText);            // remove all symbols in string
        $inputText = str_replace(" ", "", $inputText);  // remove all spaces in string
        return $inputText;
    }

}
?>