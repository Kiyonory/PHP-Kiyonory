<?php
echo('1 ЗАДАНИЕ<BR><BR>');
function CAPSEverySecondWord(&$words) {
    foreach ($words as $index => &$word) {
        if (($index + 1) % 2 == 0) {
            $word = mb_strtoupper($word);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $text = $_POST['text'] ?? '';

    $words = preg_split('/\s+/', trim($text));

    CAPSEverySecondWord($words);

    $result = implode(' ', $words);
}
?>
<form method="post">
    <label for="text">Введите текст:</label><br>
    <textarea name="text" id="text" rows="5" cols="40"><?= htmlspecialchars($_POST['text'] ?? '') ?></textarea><br><br>
    <button type="submit">Отправить</button>
</form>
<?php if (isset($result)): ?>
    <h2>Результат:</h2>
    <p><?= htmlspecialchars($result) ?></p>
<?php endif; ?>
<?php
echo('<BR>2 ЗАДАНИЕ<BR><BR>');
$file = 'test.txt';
$text = '12345';
file_put_contents($file, $text);
echo nl2br(file_get_contents('test.txt'));
echo('<BR><BR>3 ЗАДАНИЕ<BR><BR>');
$files = ['1.txt', '2.txt', '3.txt'];

$allContent = '';

foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $allContent .= $content;
    } else {
        echo "Файл $file не найден.\n";
    }
}

file_put_contents('new.txt', $allContent);
echo nl2br(file_get_contents('new.txt'));

echo('<BR><BR>4 ЗАДАНИЕ<BR><BR>');
$files = ['1.txt', '2.txt', '3.txt'];

foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $content .= '!';
        file_put_contents($file, $content);

        echo nl2br(file_get_contents($file));
        echo ('<BR>');
    } else {
        echo "Файл $file не найден.<br>";
    }
}
echo('<BR><BR>5 ЗАДАНИЕ<BR><BR>');
$file = 'count.txt';

if (file_exists($file)) {
    $count = (int)file_get_contents($file);
} else {
    $count = 0;
}

$count++;

file_put_contents($file, $count);

echo "Страница обновлялась: $count раз(а).";