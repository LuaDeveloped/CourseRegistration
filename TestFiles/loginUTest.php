<?php

use PHPUnit\Framework\TestCase;

class loginUTest extends TestCase {
    private $loginService;

    protected function setUp(): void {
        $this->loginService = new LoginService();
    }

    public function testValidLogin() {
        $this->assertTrue(
            $this->loginService->validateLogin("alice.brown@indianaech.edu", "studentpass1"),
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
