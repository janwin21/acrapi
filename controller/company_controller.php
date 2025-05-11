<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/error/http_error.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/handler/try_catch_handler.php');

    class CompanyController {
        
		private $conn;
		
		public function __construct($conn) {
			$this->conn = $conn;
		}

        // CREATE
        public function add($data, $query_data = null) {
            return handle(function() use ($data, $query_data) {
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
                        "companies" => $companies
                    ]
                ];
            });
        }

        // RETRIEVE
        public function get_user_companies($user_id) {
            return handle(function() use ($user_id) {
                $query = "SELECT * FROM companies WHERE user_id = $user_id";
                $result = mysqli_query($this->conn,$query);
                $companies = array();
                
                while($row = mysqli_fetch_assoc($result)) {
                    $companies[] = $row;
                }

                if($user_id) {
                    return [
                        "status" => "success",
                        "data" => [
                            "code" => 200,
                            "companies" => $companies
                        ]
                    ];
                } else {
                    throw new HttpError("400 Bad Request");
                }
            });
        }

        // RETRIEVE
        public function get_users($company_id) {
            return handle(function() use ($company_id) {
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

                if($company_id) {
                    return [
                        "status" => "success",
                        "data" => [
                            "code" => 200,
                            "users" => $users
                        ]
                    ];
                } else {
                    throw new HttpError("400 Bad Request");
                }
            });
        }

        // UPDATE
        public function update($company_id, $data) {
            return handle(function() use ($company_id, $data) {
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

                if($result) {
                    return [
                        "status" => "success",
                        "data" => [
                            "code" => 200,
                            "message" => "Company successfully updated."
                        ]
                    ];
                } else {
                    throw new HttpError("400 Bad Request");
                }
            });
        }

    }

?>