<?php

class LoginService {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function validateLogin($email, $password) {
        $sql = "SELECT * FROM Student WHERE EMAIL = ? AND Password = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }
}
?>
