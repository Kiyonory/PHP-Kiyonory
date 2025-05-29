<?php

namespace src\Controllers;

use src\View\View;
use src\Models\Comments\Comment;
use src\Models\Articles\Article;

class CommentController
{
    private $view;
    private $db;
    
    public function __construct() {
        $this->view = new View;
    }

    public function store()
    {
        $comment = new Comment;
        $comment->articleId = (int)$_POST['id'];
        $comment->text = $_POST['text'];
        $comment->authorId = 1;
        
        $comment->save();
        
        return header('Location: ' . dirname($_SERVER['SCRIPT_NAME']) . '/article/' . $comment->getArticleId());
    }

    public function delete()
    {
        if (!isset($_POST['comment_id'])) {
            return;
        }

        $comment = Comment::getById((int)$_POST['comment_id']);
        if (!$comment) {
            return;
        }

        $articleId = $comment->getArticleId();
        $comment->remove();

        return header('Location: ' . dirname($_SERVER['SCRIPT_NAME']) . '/article/' . $articleId);
    }
} 