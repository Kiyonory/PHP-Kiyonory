<?php
function cot($x) {
    return 1 / tan($x);
}

function calculate($val) {
    if (strlen($val) == 0) return 0;

    $val = "0+" . $val;
    $val = str_replace([' ', '--', '+-', '-+', '++'], ['', '+', '-', '-', '+'], $val);

    while (preg_match('/([a-z]+)\((-?\d+\.?\d*)\)/i', $val, $matches)) {
        $function = strtolower($matches[1]);
        $degrees = (double) $matches[2];
        $result = 0;

        switch ($function) {
            case 'sin':
                $result = sin(deg2rad($degrees));
                break;
            case 'cos':
                $result = cos(deg2rad($degrees));
                break;
            case 'tan':
                $result = tan(deg2rad($degrees));
                break;
            case 'cot':
                $result = cot(deg2rad($degrees));
                break;
            default:
                return "Unknown function: $function";
        }

        $val = preg_replace('/' . preg_quote($matches[0], '/') . '/', $result, $val, 1);
    }

    while (preg_match('/(-?\d+\.?\d*)([\/\*])(-?\d+\.?\d*)/', $val, $matches)) {
        $left = (double) $matches[1];
        $operator = $matches[2];
        $right = (double) $matches[3];
        $newVal = $operator === '*' ? $left * $right : ($right === 0 ? "division by zero" : $left / $right);
        if (is_string($newVal)) return $newVal;
        $val = preg_replace('/' . preg_quote($matches[0], '/') . '/', $newVal, $val, 1);
    }

    while (preg_match('/(-?\d+\.?\d*)([\+\-])(-?\d+\.?\d*)/', $val, $matches)) {
        $left = (double) $matches[1];
        $operator = $matches[2];
        $right = (double) $matches[3];
        $newVal = $operator === '+' ? $left + $right : $left - $right;
        $val = preg_replace('/' . preg_quote($matches[0], '/') . '/', $newVal, $val, 1);
    }

    return $val;
}

echo calculate('4/3*cos(30)');
?>
