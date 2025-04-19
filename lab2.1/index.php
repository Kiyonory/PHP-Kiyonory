<?php 
echo "Задание 1<br>";

$arr = ['a', 'b', 'c', 'b', 'a'];
$result = array_count_values($arr);

foreach ($result as $key => $count) {
    echo "$key встречается $count раз(а)<br>";
}

echo "<br>Задание 2<br>";
$arr2 =  ['a'=>1, 'b'=>2, 'c'=>3];
$result2 = array_flip($arr2);
$result2_1 = array_reverse($arr2);
echo "Массив: ";
print_r($arr2);
echo "<br>";
echo "array_flip: ";
print_r($result2);
echo "<br>";
echo "array_reverse: ";
print_r($result2_1);
echo "<br>";

echo "<br>Задание 3<br>";
$arr3 = [1, 2, 3, 4, 5];
$result3 = array_reverse($arr3);
foreach ($result3 as $key => $number) {
    echo "$number";
}
echo "<br>";

echo "<br>Задание 4<br>";
$arr4 = ['a', 'b', 'c', 'd', 'e'];
$result4 = array_map('strtoupper', $arr4);
$result4 = implode(",", $result4);
print_r($result4);
echo "<br>";

echo "<br>Задание 5<br>";
$arr5 = [1, 2, 3, 4, 5];
array_splice($arr5, 3, 0, ['a', 'b', 'c']);
$arr5_nice = implode(",", $arr5);
echo $arr5_nice;
?>
