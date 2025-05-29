<?php

return [
    '~^/?$~' => [\src\Controllers\MainController::class, 'main'],
    '~^/article/(\d+)$~' => [\src\Controllers\ArticleController::class, 'show'],
    '~^/article/(\d+)/edit$~' => [\src\Controllers\ArticleController::class, 'edit'],
    '~^/article/(\d+)/update$~' => [\src\Controllers\ArticleController::class, 'update'],
    '~^/article/(\d+)/delete$~' => [\src\Controllers\ArticleController::class, 'delete'],
    '~^/article/create$~' => [\src\Controllers\ArticleController::class, 'create'],
    '~^/article/store$~' => [\src\Controllers\ArticleController::class, 'store'],
    '~^/article/rate$~' => [\src\Controllers\ArticleController::class, 'rate'],
    '~^/comment/store$~' => [\src\Controllers\CommentController::class, 'store'],
    '~^/comment/delete$~' => [\src\Controllers\CommentController::class, 'delete'],
]; 