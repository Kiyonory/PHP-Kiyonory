<?php
function generate_menu() {
    $menu_items = [
        'view' => 'Просмотр',
        'add' => 'Добавление записи',
        'edit' => 'Редактирование записи',
        'delete' => 'Удаление записи'
    ];
    $sort_items = [
        'date' => 'По добавлению',
        'name' => 'По фамилии',
        'dob' => 'По дате рождения'
    ];
    $active_action = $_GET['action'] ?? 'view';
    $active_sort = $_GET['sort'] ?? 'date';
    $html = '<nav class="menu">';
    $html .= '<ul>';
    foreach ($menu_items as $action => $label) {
        $activeClass = ($action === $active_action) ? 'main-active' : '';
        $html .= "<li><a href='index.php?action=$action' class='$activeClass'>$label</a></li>";
    }
    $html .= '</ul>';
    if ($active_action === 'view') {
        $html .= '<ul class="sort-menu">';
        foreach ($sort_items as $sort_key => $label) {
            $activeClass = ($sort_key === $active_sort) ? 'sort-active' : '';
            $html .= "<li><a href='index.php?action=view&sort=$sort_key' class='$activeClass'>$label</a></li>";
        }
        $html .= '</ul>';
    }
    $html .= '</nav>';
    return $html;
}
?>