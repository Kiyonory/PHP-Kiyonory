<?php require(dirname(__DIR__).'/header.php');?>

<div class="container mt-4">
    <h1>Создать новую статью</h1>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form action="<?=dirname($_SERVER['SCRIPT_NAME'])?>/article/store" method="post">
        <div class="mb-3">
            <label for="date" class="form-label">Дата публикации</label>
            <input type="date" class="form-control" id="date" name="date">
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Заголовок</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($title ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="text" class="form-label">Текст</label>
            <textarea class="form-control" id="text" rows="10" name="text"><?= htmlspecialchars($text ?? '') ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>

<?php require(dirname(__DIR__).'/footer.html');?>
