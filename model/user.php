<?php

    class User {

        private $conn, $create_sql, $drop_sql;
        private $first_name, $last_name, $email, $password;

        public function __construct($conn, $first_name = null, $last_name = null, $email = null, $password = null) {
            $this->conn = $conn;
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->email = $email;
            $this->password = $password;

            $this->create_sql = "
                CREATE TABLE users (
                    id INT PRIMARY KEY AUTO_INCREMENT,
                    first_name VARCHAR(20) NOT NULL,
                    last_name VARCHAR(20) NOT NULL,
                    email VARCHAR(255) UNIQUE,
                    password VARCHAR(255) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                );
            ";

            $this->drop_sql = "DROP TABLE IF EXISTS users;";
        }

        public function get_first_name() {
            return $this->first_name;
        }

        public function get_last_name() {
            return $this->last_name;
        }

        public function get_email() {
            return $this->email;
        }

        public function get_password() {
            return $this->password;
        }

        public function toArray(): array {
            return [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'password' => $this->password
            ];
        }
        
        public function create() {
            if (mysqli_query($this->conn, $this->create_sql)) {
                echo "Table 'users' created successfully";
            } else {
                echo "Error: " . mysqli_error($this->conn);
            }
        }
        
        public function drop() {
            if (mysqli_query($this->conn, $this->drop_sql)) {
                echo "Table 'users' deleted successfully";
            } else {
                echo "Error: " . mysqli_error($this->conn);
            }
        }


    }

?>