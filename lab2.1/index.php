<?php
function solveEquation($equation) {
    $parts = explode(' ', $equation);
    $left = $parts[0];
    $operator = $parts[1];
    $right = $parts[2];
    $result = $parts[4];

    if ($right === 'x') {
        switch ($operator) {
            case '+': $x = $result - $left; break;
            case '-': $x = $left - $result; break;
            case '*': $x = $result / $left; break;
            case '/': $x = $left / $result; break;
        }
    } elseif ($left === 'x') {
        switch ($operator) {
            case '+': $x = $result - $right; break;
            case '-': $x = $result + $right; break;
            case '*': $x = $result / $right; break;
            case '/': $x = $result * $right; break;
        }
    }

    return $x;
}

$equation = "22 * x = 220";
echo "x = " . solveEquation($equation);
?>