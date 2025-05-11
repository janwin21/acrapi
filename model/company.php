<?php

    class Company {

        private $conn, $create_sql, $drop_queries;
        private $user_id, $name, $industry, $location, $tell_no, $founded_year;

        public function __construct($conn = null, $user_id = null, $name = null, $industry = null, $location = null, $tell_no = null, $founded_year = null) {
            $this->conn = $conn;
            $this->user_id = $user_id;
            $this->name = $name;
            $this->industry = $industry;
            $this->location = $location;
            $this->tell_no = $tell_no;
            $this->founded_year = $founded_year;

            $this->create_sql = "
                CREATE TABLE companies (
                    id BIGINT PRIMARY KEY AUTO_INCREMENT,
                    user_id INT,
                    name VARCHAR(255) NOT NULL,
                    industry VARCHAR(255),
                    location VARCHAR(255),
                    tell_no VARCHAR(255),
                    founded_year SMALLINT,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    
                    CONSTRAINT fk_user_id_to_companies
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                );
            ";

            $this->drop_queries = [
                "ALTER TABLE companies DROP FOREIGN KEY fk_user_id_to_companies;",
                "DROP TABLE IF EXISTS companies;"
            ];
        }

        public function get_user_id() {
            return $this->user_id;
        }

        public function get_name() {
            return $this->name;
        }

        public function get_industry() {
            return $this->industry;
        }

        public function get_location() {
            return $this->location;
        }

        public function get_tell_no() {
            return $this->tell_no;
        }

        public function get_founded_year() {
            return $this->founded_year;
        }

        public function toArray(): array {
            return [
                'user_id' => $this->user_id,
                'name' => $this->name,
                'industry' => $this->industry,
                'location' => $this->location,
                'tell_no' => $this->tell_no,
                'founded_year' => $this->founded_year
            ];
        }
        
        public function create() {
            if (mysqli_query($this->conn, $this->create_sql)) {
                echo "Table 'companies' created successfully";
            } else {
                echo "Error: " . mysqli_error($this->conn);
            }
        }
        
        public function drop() {
            foreach ($this->drop_queries as $query) {
                if (!mysqli_query($this->conn, $query)) {
                    echo "Error: " . mysqli_error($this->conn) . "<br>";
                    return;
                }
            }
        
            echo "Table 'companies' and foreign keys deleted successfully";
        }


    }

?>