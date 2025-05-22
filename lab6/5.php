<?php
session_start();

if (!isset($_SESSION['entry_time'])) {
    $_SESSION['entry_time'] = time();
    echo "Вы зашли на сайт только что.";
} else {
    $elapsed = time() - $_SESSION['entry_time'];
    echo "Вы зашли на сайт $elapsed секунд назад.";
}
?>
