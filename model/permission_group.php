<?php

    class PermissionGroup {

        private $conn, $create_sql, $drop_queries;
        private $role_id, $permission_id;

        public function __construct($conn = null, $role_id = null, $permission_id = null) {
            $this->conn = $conn;
            $this->role_id = $role_id;
            $this->permission_id = $permission_id;

            $this->create_sql = "
                CREATE TABLE permission_groups (
                    role_id BIGINT,
                    permission_id BIGINT,
                    
                    CONSTRAINT unique_permission_groups UNIQUE (role_id, permission_id),
                    PRIMARY KEY (role_id, permission_id),
                    CONSTRAINT fk_role_id_to_permission_groups
                    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
                    CONSTRAINT fk_permission_id_to_permission_groups
                    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
                );
            ";

            $this->drop_queries = [
                "ALTER TABLE permission_groups DROP FOREIGN KEY fk_permission_id_to_permission_groups;",
                "ALTER TABLE permission_groups DROP FOREIGN KEY fk_role_id_to_permission_groups;",
                "DROP TABLE IF EXISTS permission_groups;"
            ];
        }

        public function get_role_id() {
            return $this->role_id;
        }

        public function get_permission_id() {
            return $this->permission_id;
        }

        public function toArray(): array {
            return [
                'role_id' => $this->role_id,
                'permission_id' => $this->permission_id
            ];
        }
        
        public function create() {
            if (mysqli_query($this->conn, $this->create_sql)) {
                echo "Table 'permission_groups' created successfully";
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
        
            echo "Table 'permission_groups' and foreign keys deleted successfully";
        }


    }

?>