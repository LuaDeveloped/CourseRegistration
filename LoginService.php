<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

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
        file_put_contents('debug.log', "Debug: Number of rows found: " . $result->num_rows . PHP_EOL, FILE_APPEND);
        return $result->num_rows > 0;
    }
}