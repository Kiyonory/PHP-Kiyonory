<?php
function show_contacts_table($sort = 'date', $page = 1) {
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $db = new SQLite3('contacts.db');
    if (!$db) {
        return "<div class='error'>Ошибка подключения к базе данных.</div>";
    }

    $order_by = '';
    switch ($sort) {
        case 'name':
            $order_by = 'ORDER BY last_name ASC, first_name ASC';
            break;
        case 'dob':
            $order_by = 'ORDER BY dob ASC';
            break;
        case 'date':
        default:
            $order_by = 'ORDER BY id ASC';
    }

    $count_query = "SELECT COUNT(*) AS total FROM contacts";
    $count_result = $db->querySingle($count_query);
    $total_records = $count_result ? $count_result : 0;

    $total_pages = ceil($total_records / $limit);

    $query = "SELECT * FROM contacts $order_by LIMIT $limit OFFSET $offset";
    $results = $db->query($query);

    $html = '<div class="contacts-container">';
    
    if (!$results || $total_records == 0) {
        $html .= '<p class="no-records">Записи не найдены.</p>';
    } else {
        $html .= '<table class="contacts-table">';
        $html .= '<thead><tr class="table-header">';
        $html .= '<th>ФИО</th>';
        $html .= '<th>Пол</th>';
        $html .= '<th>Дата рождения</th>';
        $html .= '<th>Телефон</th>';
        $html .= '<th>Email</th>';
        $html .= '<th>Адрес</th>';
        $html .= '<th>Комментарий</th>';
        $html .= '</tr></thead><tbody>';

        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $html .= '<tr class="contact-row">';
            $html .= '<td>' . htmlspecialchars($row['last_name']) . ' ' . htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['middle_name']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['gender']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['dob']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['phone']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['email']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['address']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['comment']) . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        if ($total_pages > 1) {
            $html .= '<div class="pagination">';
            for ($i = 1; $i <= $total_pages; $i++) {
                $active = ($i == $page) ? 'active' : '';
                $html .= '<a href="index.php?action=view&sort=' . urlencode($sort) . '&page=' . $i . '" class="page-link ' . $active . '">' . $i . '</a>';
            }
            $html .= '</div>';
        }
    }

    $html .= '</div>';

    $db->close();

    return $html;
}
?>