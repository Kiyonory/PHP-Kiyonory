<?php

namespace src\Controllers;

use src\Models\Articles\Article;

class RatingController extends AbstractController
{
    public function rate(): void
    {
        if (!isset($_POST['article_id']) || !isset($_POST['rating'])) {
            $this->view->renderJson(['error' => 'Missing required parameters'], 400);
            return;
        }

        $articleId = (int)$_POST['article_id'];
        $rating = (int)$_POST['rating'];
        $userId = 1; 

        try {
            $article = Article::getById($articleId);
            if (!$article) {
                $this->view->renderJson(['error' => 'Article not found'], 404);
                return;
            }

            $article->rate($userId, $rating);
            $averageRating = $article->getAverageRating();

            $this->view->renderJson([
                'success' => true,
                'average_rating' => $averageRating,
                'user_rating' => $rating
            ]);
        } catch (\InvalidArgumentException $e) {
            $this->view->renderJson(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            $this->view->renderJson(['error' => 'Internal server error'], 500);
        }
    }
} 