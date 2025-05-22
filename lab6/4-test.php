<?php
session_start();

if (isset($_SESSION['country'])) {
    echo "Ваша страна: " . $_SESSION['country'];
} else {
    echo "Страна не указана.";
}
