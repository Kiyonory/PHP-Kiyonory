<?php

namespace src\Controllers;
use src\View\View;
use src\Models\Articles\Article;

class MainController{
    private $view;
    public function __construct()
    {
        $this->view = new View;   
    }

    public function main(): void
    {
        $page = $_GET['page'] ?? 1; 
        $perPage = 5; 

        $sort = $_GET['sort'] ?? 'rating_desc'; 

        $articles = Article::getPageSortedByRating_Primitive((int)$page, $perPage, $sort);

        if ($sort === 'rating_desc' || $sort === 'rating_asc') {
            $articles = Article::getPageSortedByRating_Primitive((int)$page, $perPage, $sort);
        } else { 
            $articles = Article::getPage((int)$page, $perPage); 
        }

        $totalArticles = Article::getTotalCount(); 
        $totalPages = ceil($totalArticles / $perPage); 


        $this->view->renderHtml('main/main', [
            'articles' => $articles,
            'currentPage' => (int)$page,
            'totalPages' => $totalPages,
            'sort' => $sort 
        ]);
    }
}