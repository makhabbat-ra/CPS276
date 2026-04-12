<?php
class Validation {
    private $errors = [];

    public function checkFormat($value, $type, $customErrorMsg = null) {
        $patterns = [
            'name'    => '/^[A-Za-z]+$/',
            'email'   => '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/',
            'password'   => '/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/',
            'none'    => '/.*/'
        ];

        $pattern = $patterns[$type] ?? '/.*/';

        if (!preg_match($pattern, $value)) {
            $errorMessage = $customErrorMsg ?? "Invalid $type format.";
            $this->errors[$type] = $errorMessage;
            return false;
        }

        return true;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function hasErrors() {
        return !empty($this->errors);
    }
}
?>