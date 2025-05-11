<?php

    class RoleGroup {

        private $conn, $create_sql, $drop_queries;
        private $company_id, $user_id, $role_id;

        public function __construct($conn = null, $company_id = null, $user_id = null, $role_id = null) {
            $this->conn = $conn;
            $this->company_id = $company_id;
            $this->user_id = $user_id;
            $this->role_id = $role_id;

            $this->create_sql = "
                CREATE TABLE role_groups (
                    company_id BIGINT,
                    user_id INT,
                    role_id BIGINT,
                    
                    CONSTRAINT unique_role_groups UNIQUE (company_id, user_id, role_id),
                    PRIMARY KEY (company_id, user_id, role_id),
                    CONSTRAINT fk_company_id_to_role_groups
                    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE,
                    CONSTRAINT fk_user_id_to_role_groups
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                    CONSTRAINT fk_role_id_to_role_groups
                    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
                );
            ";

            $this->drop_queries = [
                "ALTER TABLE role_groups DROP FOREIGN KEY fk_role_id_to_role_groups;",
                "ALTER TABLE role_groups DROP FOREIGN KEY fk_user_id_to_role_groups;",
                "ALTER TABLE role_groups DROP FOREIGN KEY fk_company_id_to_role_groups;",
                "DROP TABLE IF EXISTS role_groups;"
            ];
        }

        public function get_company_id() {
            return $this->company_id;
        }

        public function get_user_id() {
            return $this->user_id;
        }

        public function get_role_id() {
            return $this->role_id;
        }

        public function toArray(): array {
            return [
                'company_id' => $this->company_id,
                'user_id' => $this->user_id,
                'role_id' => $this->role_id
            ];
        }
        
        public function create() {
            if (mysqli_query($this->conn, $this->create_sql)) {
                echo "Table 'role_groups' created successfully";
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
        
            echo "Table 'role_groups' and foreign keys deleted successfully";
        }

    }

?>