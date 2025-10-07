<?php

class Calculator {
    
    // Constructor
    public function calc($operator = null, $num1 = null, $num2 = null) {
        // Check if all three arguments are provided
        if ($operator === null || $num1 === null || $num2 === null) {
            return "<p>Cannot perform operation. You must have three arguments. A string for the operator (+,-,*,/) and two integers or floats for the numbers.</p>\n";
        }
        
        // You would need to add && $operator !== '^' to the operator validation check, and add a new case in the switch statement: case '^': $answer = pow($num1, $num2); break;.
        
        // Validate operator
        if ($operator !== '+' && $operator !== '-' && $operator !== '*' && $operator !== '/') {
            return "<p>Cannot perform operation. You must have three arguments. A string for the operator (+,-,*,/) and two integers or floats for the numbers.</p>\n";
        }
        
        // Validate numbers (AI Prompt: Is there a type check that checks if a variable is an integer or float?)
        if (!is_numeric($num1) || !is_numeric($num2)) {
            return "<p>Cannot perform operation. You must have three arguments. A string for the operator (+,-,*,/) and two integers or floats for the numbers.</p>\n";
        }
        
        // Pass the validated inputs to the private method for calculation
        return $this->doCalculation($operator, $num1, $num2);
    }
    
    // Private method to perform the actual calculation
    private function doCalculation($operator, $num1, $num2) {
        switch ($operator) {
            case '+':
                $answer = $num1 + $num2;
                break;
                
            case '-':
                $answer = $num1 - $num2;
                break;
                
            case '*':
                $answer = $num1 * $num2;
                break;
                
            case '/':
                // Check for division by zero
                if ($num2 == 0) {
                    return "<p>The calculation is {$num1} {$operator} {$num2}. The answer is cannot divide a number by zero.</p>\n";
                }
                $answer = $num1 / $num2;
                break;
        }
        
        return "<p>The calculation is {$num1} {$operator} {$num2}. The answer is {$answer}.</p>\n";
    }
}

?>