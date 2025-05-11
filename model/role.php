<?php

    class Role {

        private $conn, $create_sql, $drop_queries;
        private $created_by, $name, $description;

        public function __construct($conn = null, $created_by = null, $name = null, $description = null) {
            $this->conn = $conn;
            $this->created_by = $created_by;
            $this->name = $name;
            $this->description = $description;

            $this->create_sql = "
                CREATE TABLE roles (
                    id BIGINT PRIMARY KEY AUTO_INCREMENT,
                    created_by INT,
                    name VARCHAR(255) NOT NULL,
                    description VARCHAR(255),
                    
                    CONSTRAINT fk_created_by_to_roles
                    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
                );
            ";

            $this->drop_queries = [
                "ALTER TABLE roles DROP FOREIGN KEY fk_created_by_to_roles;",
                "DROP TABLE IF EXISTS roles;"
            ];
        }

        public function get_created_by() {
            return $this->created_by;
        }

        public function get_name() {
            return $this->name;
        }

        public function get_description() {
            return $this->description;
        }

        public function toArray(): array {
            return [
                'created_by' => $this->created_by,
                'name' => $this->name,
                'description' => $this->description
            ];
        }
        
        public function create() {
            if (mysqli_query($this->conn, $this->create_sql)) {
                echo "Table 'roles' created successfully";
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
        
            echo "Table 'roles' and foreign keys deleted successfully";
        }


    }

?>