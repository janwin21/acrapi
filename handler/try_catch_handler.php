<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/error/http_error.php');

    function handle($callback) {
        try {
            $result = $callback();
            return json_encode($result, JSON_PRETTY_PRINT);
        } catch(HttpError $e) {
            return json_encode($e->get_error_data(), JSON_PRETTY_PRINT);
        } catch(mysqli_sql_exception $e) {
            return json_encode(HttpError::get_error_custom_data($e->getMessage()), JSON_PRETTY_PRINT);
        }
    }

?>