<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/error/http_error.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/handler/try_catch_handler.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/middleware/authentication.php');

    class CompanyController {
        
		private $conn;
		
		public function __construct($conn) {
			$this->conn = $conn;
		}

        // CREATE
        public function add($data, $query_data = null) {
            return handle(function() use ($data, $query_data) {
                $header = getallheaders();
                $my_user = authenticateRequest($header);

                $user_id = $data['user_id'];
                $name = $data['name'];
                $industry = $data['industry'];
                $location = $data['location'];
                $tell_no = $data['tell_no'];
                $founded_year = $data['founded_year'];

                $query = "INSERT INTO companies (user_id, name, industry, location, tell_no, founded_year) VALUES (
                    $user_id, '$name', '$industry', '$location', '$tell_no', $founded_year
                )";
                $result = mysqli_query($this->conn,$query);

                if($result) {
                    return [
                        "status" => "success",
                        "data" => [
                            "code" => 201,
                            "payload" => $my_user,
                            "message" => "New company successfully created."
                        ]
                    ];
                } else {
                    throw new HttpError("400 Bad Request");
                }
            });
        }

        // RETRIEVE
        public function get_all() {
            return handle(function() {
                $header = getallheaders();
                $my_user = authenticateRequest($header);

                $query = "SELECT * FROM companies";
                $result = mysqli_query($this->conn,$query);
                $companies = array();
                
                while($row = mysqli_fetch_assoc($result)) {
                    $companies[] = $row;
                }

                return [
                    "status" => "success",
                    "data" => [
                        "code" => 200,
                        "payload" => $my_user,
                        "companies" => $companies
                    ]
                ];
            });
        }

        // RETRIEVE
        public function get_user_companies($user_id) {
            return handle(function() use ($user_id) {
                $header = getallheaders();
                $my_user = authenticateRequest($header);
                
                $query = "SELECT * FROM companies WHERE user_id = $user_id";
                $result = mysqli_query($this->conn,$query);
                $companies = array();
                
                while($row = mysqli_fetch_assoc($result)) {
                    $companies[] = $row;
                }

                if(count($companies) > 0) {
                    return [
                        "status" => "success",
                        "data" => [
                            "code" => 200,
                            "payload" => $my_user,
                            "companies" => $companies
                        ]
                    ];
                } else {
                    throw new HttpError("User does not have company.");
                }
            });
        }

        // RETRIEVE
        public function get_users($company_id) {
            return handle(function() use ($company_id) {
                $header = getallheaders();
                $my_user = authenticateRequest($header);

                $query = "
                    SELECT DISTINCT u.id, u.first_name, u.last_name, u.email
                    FROM users u
                    JOIN role_groups rc ON rc.user_id = u.id
                    JOIN companies c ON rc.company_id = c.id
                    WHERE c.id = $company_id
                ";
                $result = mysqli_query($this->conn,$query);
                $users = array();
                
                while($row = mysqli_fetch_assoc($result)) {
                    $users[] = $row;
                }

                if(count($users) > 0) {
                    return [
                        "status" => "success",
                        "data" => [
                            "code" => 200,
                            "payload" => $my_user,
                            "users" => $users
                        ]
                    ];
                } else {
                    throw new HttpError("No users available.");
                }
            });
        }

        // UPDATE
        public function update($company_id, $data) {
            return handle(function() use ($company_id, $data) {
                $header = getallheaders();
                $my_user = authenticateRequest($header);

                $name = $data['name'];
                $industry = $data['industry'];
                $location = $data['location'];
                $tell_no = $data['tell_no'];
                $founded_year = $data['founded_year'];
                
                $query = "
                    UPDATE companies
                    SET
                        name = '$name',
                        industry = '$industry',
                        location = '$location',
                        tell_no = '$tell_no',
                        founded_year = '$founded_year'
                    WHERE
                        id = $company_id
                ";
                $result = mysqli_query($this->conn,$query);

                var_dump($result);

                if($result) {
                    $affected = mysqli_affected_rows($this->conn);

                    if ($affected > 0) {
                        return [
                            "status" => "success",
                            "data" => [
                                "code" => 200,
                                "payload" => $my_user,
                                "message" => "Company successfully updated."
                            ]
                        ];
                    } else {
                        throw new HttpError("No affected rows detected");
                    }
                } else {
                    throw new HttpError("400 Bad Request");
                }
            });
        }

    }

?>