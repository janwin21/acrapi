<?php

    class HttpError extends Exception {

        public function __construct($message) {
            parent::__construct($message);
        }

        public function get_error_data() {
            return [
                "status" => "error",
                "data" => [
                    "code" => 401,
                    "message" => $this->message
                ]
            ];
        }

        public static function get_error_custom_data($message) {
            return [
                "status" => "error",
                "data" => [
                    "code" => 401,
                    "message" => $message
                ]
            ];
        }

    }

?>