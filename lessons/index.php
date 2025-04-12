<?php
$str = 'a.x axa+? ax aax aaax';
$pattern = '/axa\+\?/';
echo $str. '<BR>';
echo $pattern. '<BR>';
echo preg_replace($pattern, '!',$str);
?>