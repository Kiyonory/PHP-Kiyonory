<?php
function show_edit_form() {
    $html = '';
    $message = '';
    $is_success = false;
    $edit_id = $_GET['id'] ?? null;

    $db = new SQLite3('contacts.db');
    if (!$db) {
        return "<div class='error'>Ошибка подключения к базе данных.</div>";
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
        $contact_id = $db->escapeString($_POST['id'] ?? '');
        $last_name = $db->escapeString($_POST['last_name'] ?? '');
        $first_name = $db->escapeString($_POST['first_name'] ?? '');
        $middle_name = $db->escapeString($_POST['middle_name'] ?? '');
        $gender = $db->escapeString($_POST['gender'] ?? '');
        $dob = $db->escapeString($_POST['dob'] ?? '');
        $phone = $db->escapeString($_POST['phone'] ?? '');
        $address = $db->escapeString($_POST['address'] ?? '');
        $email = $db->escapeString($_POST['email'] ?? '');
        $comment = $db->escapeString($_POST['comment'] ?? '');

        if (empty($last_name) || empty($first_name) || empty($contact_id)) {
            $message = "Недостаточно данных (Фамилия, Имя или ID отсутствуют) для обновления.";
            $is_success = false;
            $edit_id = $_POST['id'];
        } else {
            $query = "UPDATE contacts SET 
                        last_name='$last_name', 
                        first_name='$first_name', 
                        middle_name='$middle_name', 
                        gender='$gender', 
                        dob='$dob', 
                        phone='$phone', 
                        address='$address', 
                        email='$email', 
                        comment='$comment' 
                      WHERE id=$contact_id";

            $result = $db->exec($query);

            if ($result) {
                $message = "Запись успешно обновлена.";
                $is_success = true;
                $edit_id = null;
            } else {
                $message = "Ошибка при обновлении записи: " . $db->lastErrorMsg();
                $is_success = false;
                $edit_id = $_POST['id'];
            }
        }
    }

    if ($message) {
        $html .= '<div class="' . ($is_success ? 'success' : 'error') . '">' . htmlspecialchars($message) . '</div>';
    }

    if ($edit_id) {
        $query = "SELECT * FROM contacts WHERE id = " . $db->escapeString($edit_id);
        $result = $db->querySingle($query, true);

        if ($result) {
            $contact = $result;

            $html .= '<div class="form-container">';
            $html .= '<h2>Редактировать контакт</h2>';
            $html .= '<form method="POST">'; 
            $html .= '<input type="hidden" name="id" value="' . htmlspecialchars($contact['id']) . '">';

            $html .= '<div class="form-group">';
            $html .= '<label for="last_name">Фамилия:</label>';
            $html .= '<input type="text" id="last_name" name="last_name" value="' . htmlspecialchars($contact['last_name']) . '" required>';
            $html .= '</div>';

            $html .= '<div class="form-group">';
            $html .= '<label for="first_name">Имя:</label>';
            $html .= '<input type="text" id="first_name" name="first_name" value="' . htmlspecialchars($contact['first_name']) . '" required>';
            $html .= '</div>';

            $html .= '<div class="form-group">';
            $html .= '<label for="middle_name">Отчество:</label>';
            $html .= '<input type="text" id="middle_name" name="middle_name" value="' . htmlspecialchars($contact['middle_name']) . '">';
            $html .= '</div>';

            $html .= '<div class="form-group">';
            $html .= '<label for="gender">Пол:</label>';
            $html .= '<select id="gender" name="gender">';
            $html .= '<option value="Мужской" ' . ($contact['gender'] === 'Мужской' ? 'selected' : '') . '>Мужской</option>';
            $html .= '<option value="Женский" ' . ($contact['gender'] === 'Женский' ? 'selected' : '') . '>Женский</option>';
            $html .= '</select>';
            $html .= '</div>';
            
            $html .= '<div class="form-group">';
            $html .= '<label for="dob">Дата рождения:</label>';
            $html .= '<input type="date" id="dob" name="dob" value="' . htmlspecialchars($contact['dob']) . '">';
            $html .= '</div>';

            $html .= '<div class="form-group">';
            $html .= '<label for="phone">Телефон:</label>';
            $html .= '<input type="text" id="phone" name="phone" value="' . htmlspecialchars($contact['phone']) . '">';
            $html .= '</div>';

            $html .= '<div class="form-group">';
            $html .= '<label for="address">Адрес:</label>';
            $html .= '<input type="text" id="address" name="address" value="' . htmlspecialchars($contact['address']) . '">';
            $html .= '</div>';

            $html .= '<div class="form-group">';
            $html .= '<label for="email">Email:</label>';
            $html .= '<input type="email" id="email" name="email" value="' . htmlspecialchars($contact['email']) . '">';
            $html .= '</div>';

            $html .= '<div class="form-group">';
            $html .= '<label for="comment">Комментарий:</label>';
            $html .= '<textarea id="comment" name="comment" rows="3" cols="40">' . htmlspecialchars($contact['comment']) . '</textarea>';
            $html .= '</div>';

            $html .= '<div class="form-group">';
            $html .= '<button type="submit" class="btn btn-primary">Сохранить изменения</button>';
            $html .= '</div>';

            $html .= '</form>';
            $html .= '</div>';

        } else {
            $html .= "<div class='error'>Контакт с ID " . htmlspecialchars($edit_id) . " не найден.</div>";
            $edit_id = null;
        }
    }

    if (!$edit_id) {
        $html .= '<h2>Выберите контакт для редактирования</h2>';
        $query = "SELECT id, last_name, first_name FROM contacts ORDER BY last_name ASC, first_name ASC";
        $results = $db->query($query);

        $html .= '<nav class="menu"><ul class="user-list-menu">';

        if ($results) {
            while ($row = $results->fetchArray()) {
                 $name = htmlspecialchars($row['last_name'] . ' ' . $row['first_name']);
                 $html .= '<li><a href="index.php?action=edit&id=' . $row['id'] . '">' . $name . '</a></li>';
            }
        } else {
            $html .= '<li>Нет записей в базе данных.</li>';
        }

        $html .= '</ul></nav>';
    }

    $db->close();

    return $html;
}
?>
