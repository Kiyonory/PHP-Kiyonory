<?php
session_start(); 

if (!isset($_SESSION['my_text'])) {
    $_SESSION['my_text'] = 'test';
} else {
    echo $_SESSION['my_text'];
}
?>