<?php

use PHPUnit\Framework\TestCase;
include "LoginService.php";

class loginUTest extends TestCase {
    private $loginService;
    
    protected function setUp(): void {
        $servername ="localhost";
        $username = "cs4500";
        $password = "24Indianatech-";
        $dbname = "CourseRegistration";
        $conn = mysqli_connect($servername,$username,$password,$dbname);
        $this->loginService = new LoginService($conn);
    }

    public function testValidLogin() {
        $this->assertTrue(
            $this->loginService->validateLogin("bob.white@indianatech.edu", "studentpass2"),
            "Valid login credentials should return true."
        );
    }

    public function testInvalidUsername() {
        $this->assertFalse(
            $this->loginService->validateLogin("wrong_user", "password123"),
            "Invalid username should return false."
        );
    }

    public function testInvalidPassword() {
        $this->assertFalse(
            $this->loginService->validateLogin("admin", "wrong_password"),
            "Invalid password should return false."
        );
    }

    public function testEmptyFields() {
        $this->assertFalse(
            $this->loginService->validateLogin("", ""),
            "Empty fields should return false."
        );
    }

    public function testNullFields() {
        $this->assertFalse(
            $this->loginService->validateLogin(null, null),
            "Null fields should return false."
        );
    }
}
?>
