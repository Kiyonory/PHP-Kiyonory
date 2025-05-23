<?php
function show_add_form() {
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $pdo = new PDO("sqlite:contacts.db");
            $stmt = $pdo->prepare("
                INSERT INTO contacts (
                    last_name, first_name, middle_name, gender, dob,
                    phone, address, email, comment
                ) VALUES (
                    :last_name, :first_name, :middle_name, :gender, :dob,
                    :phone, :address, :email, :comment
                )
            ");

            $success = $stmt->execute([
                ':last_name'   => $_POST['last_name'],
                ':first_name'  => $_POST['first_name'],
                ':middle_name' => $_POST['middle_name'],
                ':gender'      => $_POST['gender'],
                ':dob'         => $_POST['dob'],
                ':phone'       => $_POST['phone'],
                ':address'     => $_POST['address'],
                ':email'       => $_POST['email'],
                ':comment'     => $_POST['comment'],
            ]);

            if ($success) {
                $message = "<p class='success'>Запись добавлена</p>";
            } else {
                $message = "<p class='error'>Ошибка: запись не добавлена</p>";
            }

        } catch (Exception $e) {
            $error = htmlspecialchars($e->getMessage());
            $message = "<p class='error'>Ошибка: $error</p>";
        }
    }
    ?>

    <?php if ($message): ?>
        <?= $message ?>
    <?php endif; ?>

    <div class="form-container">
    <form method="POST" style="margin-top:20px;">
        <div class="form-group">
            <label>Фамилия: <input name="last_name" required></label>
        </div>
        <div class="form-group">
            <label>Имя: <input name="first_name" required></label>
        </div>
        <div class="form-group">
            <label>Отчество: <input name="middle_name"></label>
        </div>
        <div class="form-group">
            <label>Пол:
                <select name="gender">
                    <option value="Мужской">Мужской</option>
                    <option value="Женский">Женский</option>
                </select>
            </label>
        </div>
        <div class="form-group">
            <label>Дата рождения: <input type="date" name="dob"></label>
        </div>
        <div class="form-group">
            <label>Телефон: <input name="phone"></label>
        </div>
        <div class="form-group">
            <label>Адрес: <input name="address"></label>
        </div>
        <div class="form-group">
            <label>Email: <input type="email" name="email"></label>
        </div>
        <div class="form-group">
            <label>Комментарий:<br>
                <textarea name="comment" rows="3" cols="40"></textarea>
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Добавить</button>
    </form>
    </div>

<?php
}
?>
