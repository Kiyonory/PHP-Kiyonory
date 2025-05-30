<?php require(dirname(__DIR__).'/header.php');?>

<div class="container mt-4">
    <h1>Статьи</h1>

    <div class="sorting-options mb-3">
        Сортировать:
        <a href="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/?sort=rating_desc">По рейтингу (сначала лучшие)</a> |
        <a href="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/?sort=rating_asc">По рейтингу (сначала худшие)</a> |
        <a href="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/?sort=date_desc">По дате (сначала новые)</a>
    </div>

    <?php if (empty($articles)): ?>
        <p>Статей пока нет</p>
    <?php else: ?>
        <div class="row">
            <?php foreach ($articles as $article): ?>
                <div style="border: 5px solid #ccc; margin-bottom: 10px; padding: 10px;">
                    <h2><a href="<?=dirname($_SERVER['SCRIPT_NAME'])?>/article/<?=$article->getId()?>" style="text-decoration: none; color: inherit;"><?= htmlspecialchars($article->getTitle()) ?></a></h2>
                    <p>Дата: <?= date('Y-m-d H:i', strtotime($article->getCreatedAt())) ?> | Автор: <?= htmlspecialchars($article->getAuthorId()->getNickname()) ?></p>
                    
                    <?php
                    $averageRating = $article->getAverageRating();
                    $starRating = '';
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= round($averageRating)) {
                            $starRating .= '<span class="star filled"></span>';
                        } else {
                            $starRating .= '<span class="star"></span>';
                        }
                    }
                    ?>
                    <div class="rating" data-id="<?= $article->getId() ?>"><?= $starRating ?></div>
                    <p><?= mb_substr(htmlspecialchars($article->getText()), 0, 100) ?>...</p>
                    <a href="<?=dirname($_SERVER['SCRIPT_NAME'])?>/article/<?=$article->getId()?>">Читать далее</a>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/?page=<?= $currentPage - 1 ?>&sort=<?= $sort ?>">Предыдущая</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                            <a class="page-link" href="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/?page=<?= $i ?>&sort=<?= $sort ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/?page=<?= $currentPage + 1 ?>&sort=<?= $sort ?>">Следующая</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>


<link rel="stylesheet" href="<?=dirname($_SERVER['SCRIPT_NAME'])?>/css/rating.css">
<script src="<?=dirname($_SERVER['SCRIPT_NAME'])?>/js/rating.js"></script>

<script>
    const basePath = '<?= dirname($_SERVER['SCRIPT_NAME']) ?>';
</script>

<?php require(dirname(__DIR__).'/footer.html');?>
