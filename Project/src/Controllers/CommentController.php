<?php

namespace src\Controllers;

use src\View\View;
use src\Models\Comments\Comment;
use src\Models\Articles\Article;

class CommentController extends AbstractController
{
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

    public function update(int $id)
    {
        if (empty($_POST['text'])) {
           
            return header('Location: ' . $_SERVER['HTTP_REFERER'] ?? dirname($_SERVER['SCRIPT_NAME']) . '/');
        }

        $comment = Comment::getById($id);
        if (!$comment) {
            
             header('HTTP/1.1 404 Not Found');
             echo 'Комментарий не найден';
             exit();
        }

        $comment->text = $_POST['text'];
        $comment->save();

        
        return header('Location: ' . dirname($_SERVER['SCRIPT_NAME']) . '/article/' . $comment->getArticleId());
    }
} 