<?php

class FormSanitizer {

    // sanitize normal string inputs
    public static function sanitizeFormString($inputText) {
        $inputText = strip_tags($inputText);    // takes away any tags from input string
        $inputText = str_replace(" ", "", $inputText);  // takes away all spaces from the input string
        $inputText = strtolower($inputText); // lowercase entire input string
        $inputText = ucfirst($inputText); // uppercase the first letter in the string
        return $inputText;
    }

    // sanitize username inputs
    public static function sanitizeFormUsername($inputText) {
        $inputText = strip_tags($inputText);    // takes away any tags from input string
        $inputText = str_replace(" ", "", $inputText);  // takes away all spaces from the input string
        return $inputText;
    }

    // sanitize password inputs
    public static function sanitizeFormPassword($inputText) {
        $inputText = strip_tags($inputText);    // takes away any tags from input string
        return $inputText;
    }

    // sanitize email inputs
    public static function sanitizeFormEmail($inputText) {
        $inputText = strip_tags($inputText);    // takes away any tags from input string
        $inputText = str_replace(" ", "", $inputText);  // takes away all spaces from the input string
        return $inputText;
    }

}
?>