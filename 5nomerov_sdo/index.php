<?php
//1 задание
echo "1 задание", '<BR>';
$a = 27;
$b = 12;
$hypotenysa = sqrt($a**2+$b**2);
echo "гипотенуза - ", $hypotenysa , '<BR>';
$rounded_hypotenysa = round($hypotenysa, 2);
echo 'округление гипотенузы - ', $rounded_hypotenysa;
//2 задание
echo "<BR>Задание 8", '<BR>';
$a = false;
$b = true;

echo "Значение переменной a: " . ($a ? 'true' : 'false') . "<BR>";
echo "Значение переменной b: " . ($b ? 'true' : 'false') . "<BR>";
//3 задание
echo "9 задание", '<BR>';
$a = 3;
$b = 2.0;
$c = '2';
$d = 'two';
$g = 'true';
$f = 'false';
$vars = [$a, $b, $c, $d, $g, $f];
$vars_symbols = ['+','/', '-', '*', '%', '**'];
$count_symbols = count($vars_symbols);
$count = count($vars);
for ($i = 0; $i < $count; $i++) {
    for ($k = 0; $k < $count; $k++ ) {
        for ($s = 0; $s < $count_symbols; $s++) {
            $var1 = $vars[$i];
            $var2 = $vars[$k];
            try {
                switch ($vars_symbols[$s]) {
                    case '+':
                        $result = $var1 + $var2;
                        if (is_int($result)) {
                            echo ($result), " '$var1 и $var2' при $vars_symbols[$s] ", "<BR>";
                        }
                        else {
                            echo ("число не целое при операции $vars_symbols[$s] и переменными $var1 и $var2 <BR>");
                        }
                        break;
                    case '/':
                        $result = $var1 / $var2;
                        if (is_int($result)) {
                            echo ($result), " '$var1 и $var2' при $vars_symbols[$s] ", "<BR>";
                        }
                        else {
                            echo ("число не целое при операции $vars_symbols[$s] и переменными $var1 и $var2 <BR>");
                        }
                        break;
                    case '-':
                        $result = $var1 - $var2;
                        if (is_int($result)) {
                            echo ($result), " '$var1 и $var2' при $vars_symbols[$s] ", "<BR>";
                        }
                        else {
                            echo ("число не целое при операции $vars_symbols[$s] и переменными $var1 и $var2 <BR>");
                        }
                        break;
                    case '*':
                        $result = $var1 * $var2;
                        if (is_int($result)) {
                            echo ($result), " '$var1 и $var2' при $vars_symbols[$s] ", "<BR>";
                        }
                        else {
                            echo ("число не целое при операции $vars_symbols[$s] и переменными $var1 и $var2 <BR>");
                        }
                        break;
                    case '%':
                        $result = $var1 % $var2;
                        if (is_int($result)) {
                            echo ($result), " '$var1 и $var2' при $vars_symbols[$s] ", "<BR>";
                        }
                        else {
                            echo ("число не целое при операции $vars_symbols[$s] и переменными $var1 и $var2 <BR>");
                        }
                        break;
                    case '**':
                        $result = $var1 ** $var2;
                        if (is_int($result)) {
                            echo ($result), " '$var1 и $var2' при $vars_symbols[$s] ", "<BR>";
                        }
                        else {
                            echo ("число не целое при операции $vars_symbols[$s] и переменными $var1 и $var2 <BR>");
                        }
                        break;
                    default:
                        $result = 'Неизвестная операция';
                }
            } catch (Throwable $e) {
            }
        }
    }
}
//4 задание 
echo "18 задание", '<BR>';
$a = 4.3; 
$b = 7.7; 
$c = '5.5'; 
$d = '3.4кг';
$d_number = floatval($d);
echo floor($a), "<BR>";
echo ceil($a), "<BR>";
echo floor($b), "<BR>";
echo ceil($b), "<BR>";
echo floor($c), "<BR>";
echo ceil($c), "<BR>";
echo floor($d_number), "кг<BR>";
echo ceil($d_number), "кг<BR>";
//5 задание 
echo "24 задание", "<BR>";
$a = 14;
$b = 21;
$c = 'ласточек';
$sum = $a + $b;
echo ("$sum . $c");