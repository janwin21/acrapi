<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/error/http_error.php');

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    function authenticateRequest($headers) {
        $authHeader = getAuthorizationHeader($headers);

        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            throw new HttpError('Unauthorized');
        }

        $jwt = $matches[1];

        try {
            $decoded = JWT::decode($jwt, new Key($_ENV['JWT_SECRET_TOKEN_KEY'], 'HS256'));
            return $decoded;
        } catch (Exception $e) {
            throw new HttpError('Token invalid: ' . $e->getMessage());
        }
    }

    // apache + xampp does not support Authorization header
    function getAuthorizationHeader($headers) {
        $headers = null;

        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } elseif (isset($headers)) { // Most common in Apache
            $headers = trim($headers);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Fix for case-insensitive headers
            foreach ($requestHeaders as $key => $value) {
                if (strtolower($key) === 'authorization') {
                    $headers = trim($value);
                    break;
                }
            }
        }

        return $headers;
    }
?>