<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Записная книжка</title>
    <link rel="stylesheet" href="/Byudaev_241_321/PHP-Kiyonory/lab5/style.css?v=1.0">
</head>
<body>
<div class="content">
<?php
require_once 'menu.php';
require_once 'viewer.php';
require_once 'add.php';
require_once 'edit.php';
require_once 'delete.php';

$action = $_GET['action'] ?? 'view';
$sort = $_GET['sort'] ?? 'date';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Вывод меню
echo generate_menu($action, $sort);

// Основной контент
switch ($action) {
    case 'add':
        echo show_add_form();
        break;
    case 'edit':
        echo show_edit_form();
        break;
    case 'delete':
        echo show_delete_interface();
        break;
    case 'view':
    default:
        echo show_contacts_table($sort, $page);
}
?>
</div>
</body>
</html>