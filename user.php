<?php 

    class User {
        private $conn;

        public $id;
        public $name;
        public $surname;
        public $username;
        public $email;
        public $password;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function add_user() {
            $query = 'INSERT INTO users SET name = :name, surname = :surname, username = :username, email = :email, password = :password';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':surname', $this->surname);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', SHA1($this->password));

            if($stmt->execute()) {
                return true;
            }

            print_r("Err", $stmt->error);

            return false;
        }

        public function update_user() {
            $query = 'UPDATE users SET name = :name, surname = :surname, username = :username WHERE id = :id';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':surname', $this->surname);
            $stmt->bindParam(':username', $this->username);

            if($stmt->execute()) {
                return true;
            }

            print_r("Err", $stmt->error);

            return false;
        }

        public function delete_user() {
            $query = 'DELETE FROM users WHERE id = :id';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', $this->id);

            if($stmt->execute()) {
                return true;
            }

            print_r("Err", $stmt->error);

            return false;
        }

        public function get_users() {
            $query = 'SELECT * FROM users';
            
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function get_one_user() {
            $query = 'SELECT * FROM users WHERE id = ? LIMIT 0,1';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->name = $row['name'];
            $this->surname = $row['surname'];
            $this->username = $row['username'];
            $this->email = $row['email'];
        }
    }
    
?>