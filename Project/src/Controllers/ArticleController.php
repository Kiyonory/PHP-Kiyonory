<?php

namespace src\Controllers;
use src\View\View;
use src\Models\Articles\Article;
use src\Models\Comments\Comment;
use src\Models\Users\User;
use src\Models\Articles\ArticleRating;

class ArticleController extends AbstractController
{
    public function index(){
        $articles = Article::findAll();
        $this->view->renderHtml('article/index', ['articles'=>$articles]);
    }

    public function show($id){
        $article = Article::getById($id);
            if ($article == []) 
        {
            $this->view->renderHtml('error/404', [], 404);
            return;
        }

        $this->view->renderHtml('article/show', ['article'=>$article]);
    }

    public function edit($id){
        $article = Article::getById($id);
        $this->view->renderHtml('article/edit', ['article'=>$article]);
    }

    public function update($id){
        $article = Article::getById($id);
        $article->title = $_POST['title'];
        $article->text = $_POST['text'];
        $article->save();
        return header('Location: /Byudaev_241_321/PHP-Kiyonory/Project/www/article/'.$article->getId());
    }

    public function create(){
        $this->view->renderHtml('article/create');
    }

    public function store(){
        $title = $_POST['title'] ?? '';
        $text = $_POST['text'] ?? '';

        if (empty($title) || empty($text)) {
            $error = 'Заголовок и текст статьи не могут быть пустыми.';
            $this->view->renderHtml('article/create', ['error' => $error, 'title' => $title, 'text' => $text]);
            return; 
        }

        $article = new Article;
        $article->title = $title;
        $article->text = $text;
        $article->authorId = 1;
        $article->save();

        return header('Location: /Byudaev_241_321/PHP-Kiyonory/Project/www/');
    }

    public function delete(int $id){
        $article = Article::getById($id);
        $article->remove();
        return header('Location: /Byudaev_241_321/PHP-Kiyonory/Project/www/');
    }

    public function rate()
    {
        echo "Rating POST data: ";
        print_r($_POST);

        if (!isset($_POST['article_id']) || !isset($_POST['rating'])) {
            return header('Location: ' . $_SERVER['HTTP_REFERER'] ?? dirname($_SERVER['SCRIPT_NAME']) . '/');
        }

        $articleId = (int)$_POST['article_id'];
        $ratingValue = (int)$_POST['rating'];
        $userId = 1; 

        $article = Article::getById($articleId);
        if (!$article) {
            return header('Location: ' . dirname($_SERVER['SCRIPT_NAME']) . '/error/404');
        }

        $existingRating = ArticleRating::getUserRating($articleId, $userId);

        if ($existingRating) {
            $allRatings = ArticleRating::findAll(); 
            $ratingToUpdate = null;
            foreach ($allRatings as $rating) {
                if ($rating->getArticleId() === $articleId && $rating->getUserId() === $userId) {
                    $ratingToUpdate = $rating;
                    break;
                }
            }
            
            if ($ratingToUpdate) {
                 $ratingToUpdate->rating = $ratingValue;
                 $ratingToUpdate->save();
            }

        } else {
            $newRating = new ArticleRating();
            $newRating->articleId = $articleId;
            $newRating->userId = $userId;
            $newRating->rating = $ratingValue;
            $newRating->save();
        }

        return header('Location: ' . dirname($_SERVER['SCRIPT_NAME']) . '/article/' . $articleId);
    }
}