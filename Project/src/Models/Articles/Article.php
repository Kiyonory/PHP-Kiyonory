<?php

namespace src\Models\Articles;
use src\Models\ActiveRecordEntity;
use src\Models\Users\User;
use src\Services\Db;

class Article extends ActiveRecordEntity
{
        protected $title;
        protected $text;
        protected $authorId;
        protected $createdAt;

        protected static function getTableName(){
            return 'articles';
        }

        public function setTitle(string $title){
            $this->title = $title;
        }
        public function setText(string $text){
            $this->text = $text;
        }
        public function setAuthor(User $author){
            $this->authorId = $author;
        }
        public function getTitle()
        {
            return $this->title;
        }
        public function getText()
        {
            return $this->text;
        }
        public function getAuthorId() :User
        {
            return User::getById($this->authorId);
        }
        public function getCreatedAt()
        {
            return $this->createdAt;
        }

        public function getAverageRating(): float
        {
            return ArticleRating::getAverageRating($this->getId());
        }

        public function getUserRating(int $userId): ?int
        {
            return ArticleRating::getUserRating($this->getId(), $userId);
        }

        public function rate(int $userId, int $rating): void
        {
            if ($rating < 1 || $rating > 5) {
                throw new \InvalidArgumentException('Rating must be between 1 and 5');
            }

            $sql = 'INSERT INTO article_ratings (article_id, user_id, rating) 
                    VALUES (:article_id, :user_id, :rating)
                    ON DUPLICATE KEY UPDATE rating = :rating';
            
            Db::getInstance()->query($sql, [
                ':article_id' => $this->getId(),
                ':user_id' => $userId,
                ':rating' => $rating
            ]);
        }

        public static function getTotalCount(): int
        {
            $sql = 'SELECT COUNT(*) as count FROM ' . self::getTableName();
            $db = \src\Services\Db::getInstance();
            $result = $db->query($sql);
            return (int)$result[0]->count;
        }

        public static function getPage(int $page, int $perPage): array
        {
            $offset = ($page - 1) * $perPage;
            $sql = 'SELECT * FROM ' . self::getTableName() . ' ORDER BY created_at DESC LIMIT :limit OFFSET :offset';
            $db = \src\Services\Db::getInstance();
            return $db->query($sql, [
                ':limit' => $perPage,
                ':offset' => $offset
            ], self::class);
        }

        public static function getPageSortedByRating_Primitive(int $page, int $perPage, string $sort = 'rating_desc'): array
        {
            $allArticles = self::findAll();

            $articlesWithRatings = [];
            foreach ($allArticles as $article) {
                $articlesWithRatings[] = [
                    'article' => $article,
                    'average_rating' => $article->getAverageRating()
                ];
            }

            usort($articlesWithRatings, function($a, $b) use ($sort) {
                $ratingA = $a['average_rating'];
                $ratingB = $b['average_rating'];

                if ($ratingA == $ratingB) {
                    return 0;
                }

                if ($sort === 'rating_asc') {
                    return ($ratingA < $ratingB) ? -1 : 1;
                } else { 
                    return ($ratingA > $ratingB) ? -1 : 1;
                }
            });

            $offset = ($page - 1) * $perPage;
            $limit = $perPage;

            $paginatedArticlesWithRatings = array_slice($articlesWithRatings, $offset, $limit);

            $paginatedArticles = [];
            foreach ($paginatedArticlesWithRatings as $item) {
                $paginatedArticles[] = $item['article'];
            }

            return $paginatedArticles;
        }
    }
