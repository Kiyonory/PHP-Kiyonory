<?php
echo "<br>Задание 1 <br>";
$str = 'a1b2c3';
$result = preg_replace_callback('/\d/', function($matches) {
    return $matches[0] . $matches[0];
}, $str);
echo $result;

echo "<br><br>Задание 2 <br>";
$input = 'http://site.ru';
$output = preg_match('/^https?:\/\/[a-z0-9-]+\.[a-z]{2,}$/i', $input);
echo $output;

echo "<br><br>Задание 7 <br>";
function isValidEmail($email) {
    return preg_match('/^[a-z0-9._-]+@[a-z0-9.-]+\.[a-z]{2,}$/i', $email);
}
$tests = [
    "mymail@mail.ru",
    "my.mail@mail.ru",
    "my-mail@mail.ru",
    "my_mail@mail.ru",
    "mail@mail.com",
    "mail@mail.by",
    "mail@yandex.ru",
    "wrong-email@.ru",
    "another@wrong@domain.com"
];
foreach ($tests as $email) {
    echo $email . ": " . (isValidEmail($email) ? "валидный" : "невалидный") . "<br>";
}

echo "<br><br>Задание 11 <br>";
$example = 'aaa@bbb eee7@kkk';
$answer = preg_replace('/([a-z0-9]+)@([a-z0-9]+)/i', '$2@$1', $example);
echo $answer;

echo "<br><br>Задание 16 <br>";
$text = 'xbx aca aea abba adca abea';
$result = preg_replace('/\b([a-z]+)\b/', '!$1!', $text);
echo $result;