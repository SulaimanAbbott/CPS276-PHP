<?php
class Validation {
    private $errors = [];

    public function checkFormat($value, $type, $customErrorMsg = null) {
        $patterns = [
            'name'     => '/^[a-zA-Z\'\s-]{1,50}$/',
            'address'  => '/^[0-9]+\s+[a-zA-Z\s\'-]{1,100}$/',
            'city'     => '/^[a-zA-Z\s\'-]{1,50}$/',
            'zip'      => '/^\d{5}$/',
            'phone'    => '/^\d{3}\.\d{3}\.\d{4}$/',
            'email'    => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'dob'      => '/^(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])\/\d{4}$/',
            'password' => '/^[A-Za-z0-9!@#$%^&*()_+=\-{}\[\]:;"\'<>,.?\/]{1,50}$/',
            'none'     => '/.*/'
        ];

        $pattern = $patterns[$type] ?? '/.*/';

        if (!preg_match($pattern, $value)) {
            $defaultMsg = match($type) {
                'name'     => 'Invalid name format.',
                'address'  => 'Invalid address format.',
                'city'     => 'Invalid city format.',
                'zip'      => 'Zip code must be 5 digits.',
                'phone'    => 'Phone must be in 999.999.9999 format.',
                'email'    => 'You must enter a valid email address.',
                'dob'      => 'Date of birth must be mm/dd/yyyy.',
                'password' => 'Invalid password format.',
                default    => "Invalid $type format."
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