<?php
session_start();

if (isset($_POST['country'])) {
    $_SESSION['country'] = $_POST['country'];
}
?>

<form method="POST">
    <label for="country">Введите вашу страну:</label>
    <input type="text" name="country" id="country" required>
    <button type="submit">Сохранить</button>
</form>

<p><a href="4-test.php">Перейти на test.php</a></p>
