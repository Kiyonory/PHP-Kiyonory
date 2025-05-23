<?php
function show_delete_interface() {
    $html = '';
    $message = '';
    
    $db = new SQLite3('contacts.db');
    if (!$db) {
        return "<div class='error'>Ошибка подключения к базе данных.</div>";
    }

    if (isset($_GET['delete_id'])) {
        $delete_id = $db->escapeString($_GET['delete_id']);

        $query_select = "SELECT last_name FROM contacts WHERE id = " . $delete_id;
        $result_select = $db->querySingle($query_select);
        $person_last_name = $result_select ? $result_select : null;

        if ($person_last_name !== null) {
            $query_delete = "DELETE FROM contacts WHERE id = " . $delete_id;
            $result_delete = $db->exec($query_delete);

            if ($result_delete) {
                $message = "<div class='success'>Запись с фамилией " . htmlspecialchars($person_last_name) . " успешно удалена.</div>";
            } else {
                $message = "<div class='error'>Ошибка при удалении записи: " . $db->lastErrorMsg() . ".</div>";
            }
        } else {
            $message = "<div class='error'>Запись для удаления не найдена.</div>";
        }
    }

    if ($message) {
        $html .= $message;
    }

    $html .= '<h2>Выберите запись для удаления:</h2>';

    $query_list = "SELECT id, last_name, first_name FROM contacts ORDER BY last_name ASC, first_name ASC";
    $results_list = $db->query($query_list);

    $html .= '<nav class="menu"><ul class="user-list-menu">';

    if ($results_list) {
        while ($row = $results_list->fetchArray(SQLite3_ASSOC)) {
             $name = htmlspecialchars($row['last_name'] . ' ' . $row['first_name']);
             $html .= '<li><a href="index.php?action=delete&delete_id=' . $row['id'] . '">' . $name . '</a></li>';
        }
    } else {
        $html .= '<li>Нет записей в базе данных.</li>';
    }

    $html .= '</ul></nav>';

    $db->close();

    return $html;
}
?>
