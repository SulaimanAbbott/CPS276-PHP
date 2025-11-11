<?php
class Validation {
    private $errors = [];

    public function checkFormat($value, $type, $customErrorMsg = null) {
        $patterns = [
            'name'    => '/^[a-z\'\s-]{1,50}$/i',
            'phone'   => '/^\d{3}\.\d{3}\.\d{4}$/',
            'address' => '/^[a-zA-Z0-9\s,.\'-]{1,100}$/',
            'zip'     => '/^\d{5}(-\d{4})?$/',
            'email'   => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'password'=> '/^(?=.*[A-Z])(?=.*\W)(?=.*\d).{8,}$/',
            'none'    => '/.*/'
        ];

        $pattern = $patterns[$type] ?? '/.*/';

        if (!preg_match($pattern, $value)) {
            $defaultMsg = match($type) {
                'name' => 'Invalid name format.',
                'email' => 'You must enter a valid email address.',
                'password' => 'Invalid password format.',
                default => "Invalid $type format."
            };
            $errorMessage = $customErrorMsg ?? $defaultMsg;
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