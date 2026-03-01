<?php

class Calculator {

    public function calc($operator = null, $num1 = null, $num2 = null) {

        $args = func_num_args();
        if ($args !== 3) {
            return "<p>Cannot perform operation. You must have three arguments. "
                . "A string for the operator (+,-,*,/) and two integers or floats for the numbers.</p>";
        }

        if (!is_string($operator) || !in_array($operator, ["+", "-", "*", "/"])) {
            return "<p>Invalid operator. Must be one of +, -, *, /.</p>";
        }

        if (!is_numeric($num1) || !is_numeric($num2)) {
            return "<p>Cannot perform operation. You must have three arguments. "
                . "A string for the operator (+,-,*,/) and two integers or floats for the numbers.</p>";
        }

        if ($operator === "/" && $num2 == 0) {
            return "<p>The calculation is $num1 / $num2. The answer is cannot divide a number by zero.</p>";
        }

        switch ($operator) {
            case "+":
                $answer = $num1 + $num2;
                break;
            case "-":
                $answer = $num1 - $num2;
                break;
            case "*":
                $answer = $num1 * $num2;
                break;
            case "/":
                $answer = $num1 / $num2;
                break;
        }

        return "<p>The calculation is $num1 $operator $num2. The answer is $answer.</p>";
    }
}
?>

<!--
1. Explain the purpose of require_once "Calculator.php"; in th index.php page.
 What would be the difference if include or require were used instead of require_once?
2. How does the divide method specifically prevent and report an error for division by zero?
 Why is this a critical consideration in calculator applications?
3. Explain the difference between the Calculator class and the $Calculator object. 
Why do we create an instance of the class?
4. Why is it important to check that the last two parameters are numbers in our Calculator class?
5. Index.php handles the display of the results using HTML, while Calculator.php contains the core
 calculation logic. Discuss the importance of separating user interface (presentation) concerns
  from business logic.