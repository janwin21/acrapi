<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/error/http_error.php');

    class Validator {

        public static function validate_email($email) {
            if(empty($email)) {
                throw new HttpError("Invalid email.");
            } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new HttpError("Invalid email format.");
            }
        }

        public static function validate_password($password, $confirm_password) {
            if(empty($password) || empty($confirm_password)) {
                throw new HttpError("Fill-up empty fields.");
            } elseif(strlen($password) < 8) {
                throw new HttpError("Password should have 8 or more characters.");
            } elseif($password !== $confirm_password) {
                throw new HttpError("Invalid password.");
            }
        }

        public static function validate_login_password($password, $hashed_password) {
            if($hashed_password == null) {
                throw new HttpError("Email does not exist.");
            } elseif(!password_verify($password, $hashed_password['password'])) {
                throw new HttpError("Invalid password.");
            }
        }

    }

?>