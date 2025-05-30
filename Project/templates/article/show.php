<?php require(dirname(__DIR__).'/header.php');?>
<div class="card mt-3" style="width: 20rem;">
  <div class="card-body">
    <h5 class="card-title"><?=$article->getTitle();?></h5>
    <h6 class="card-subtitle mb-2 text-muted"><?=$article->getAuthorId()->getNickname();?></h6>
    <p class="card-text"><?=$article->getText();?></p>
    
    <div class="rating-container">
        <div class="rating-stars">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <form action="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/article/rate" method="POST" style="display: inline;">
                    <input type="hidden" name="article_id" value="<?= $article->getId() ?>">
                    <input type="hidden" name="rating" value="<?= $i ?>">
                    <button type="submit" class="rating-star <?= $article->getUserRating(1) >= $i ? 'active' : '' ?>" style="border: none; background: none; padding: 0; cursor: pointer;">★</button>
                </form>
            <?php endfor; ?>
        </div>
        <span class="average-rating">
            Средний рейтинг: <span id="average-rating-<?= $article->getId() ?>"><?= number_format($article->getAverageRating(), 1) ?></span>
        </span>
    </div>

    <div class="mt-3">
        <a href="<?=dirname($_SERVER['SCRIPT_NAME'])?>/article/<?=$article->getId();?>/edit" class="card-link">Обновить статью</a>
        <form action="<?=dirname($_SERVER['SCRIPT_NAME'])?>/article/<?=$article->getId();?>/delete" method="POST" style="display: inline;">
            <button type="submit" style="background: none; border: none; color:#ff8c00; text-decoration: none; padding: 0; margin: 0; font: inherit; cursor: pointer;">Удалить статью</button>
        </form>
    </div>
  </div>
</div>

<div class="comments-section">
    <h4>Комментарии</h4>
    
    <form class="comment-form" action="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/comment/store" method="POST">
        <input type="hidden" name="id" value="<?= $article->getId() ?>">
        <textarea name="text" placeholder="Напишите ваш комментарий..." required></textarea>
        <button type="submit">Добавить комментарий</button>
    </form>

    <div class="comments-list">
        <?php
        $comments = \src\Models\Comments\Comment::getCommentsByArticleId($article->getId());
        foreach ($comments as $comment):
        ?>
            <div class="comment" data-comment-id="<?= $comment->getId() ?>">
                <div class="comment-header">
                    <strong><?= $comment->getAuthor()->getNickname() ?></strong>
                    <small><?= date('Y-m-d H:i', strtotime($comment->getCreatedAt())) ?></small>
                </div>
                <div class="comment-text"><?= htmlspecialchars($comment->getText()) ?></div>
                <form action="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/comment/delete" method="POST" style="display: inline;">
                    <input type="hidden" name="comment_id" value="<?= $comment->getId() ?>">
                    <button type="submit" class="delete-comment">Удалить</button>
                </form>
                <button class="edit-comment" data-comment-id="<?= $comment->getId() ?>">Редактировать</button>

                <div class="edit-comment-form" style="display: none;">
                    <form action="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/comment/<?= $comment->getId() ?>/update" method="POST">
                        <textarea name="text"><?= htmlspecialchars($comment->getText()) ?></textarea>
                        <button type="submit">Сохранить изменения</button>
                        <button type="button" class="cancel-edit">Отмена</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<link rel="stylesheet" href="<?=dirname($_SERVER['SCRIPT_NAME'])?>/css/rating.css">
<link rel="stylesheet" href="<?=dirname($_SERVER['SCRIPT_NAME'])?>/css/comments.css">

<script>
    const basePath = '<?= dirname($_SERVER['SCRIPT_NAME']) ?>';
</script>

<script src="<?=dirname($_SERVER['SCRIPT_NAME'])?>/js/rating.js"></script>
<script src="<?=dirname($_SERVER['SCRIPT_NAME'])?>/js/comments.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        document.querySelectorAll('.edit-comment').forEach(button => {
            button.addEventListener('click', function() {
                const commentElement = this.closest('.comment');
                const commentText = commentElement.querySelector('.comment-text');
                const editForm = commentElement.querySelector('.edit-comment-form');

                commentText.style.display = 'none';
                editForm.style.display = 'block';
            });
        });

        
        document.querySelectorAll('.cancel-edit').forEach(button => {
            button.addEventListener('click', function() {
                const commentElement = this.closest('.comment');
                const commentText = commentElement.querySelector('.comment-text');
                const editForm = commentElement.querySelector('.edit-comment-form');

                commentText.style.display = 'block';
                editForm.style.display = 'none';
            });
        });
    });
</script>

<?php require(dirname(__DIR__).'/footer.html');?>
