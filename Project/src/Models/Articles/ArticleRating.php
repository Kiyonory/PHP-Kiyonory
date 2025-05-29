<?php

namespace src\Models\Articles;

use src\Models\ActiveRecordEntity;
use src\Models\Users\User;
use src\Services\Db;

class ArticleRating extends ActiveRecordEntity
{
    protected $articleId;
    protected $userId;
    protected $rating;
    protected $createdAt;

    protected static function getTableName(): string
    {
        return 'article_ratings';
    }

    public function getArticleId(): int
    {
        return $this->articleId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public static function getAverageRating(int $articleId): float
    {
        $sql = 'SELECT AVG(rating) as avg_rating FROM ' . self::getTableName() . ' WHERE article_id = :article_id';
        $result = Db::getInstance()->query($sql, [':article_id' => $articleId]);
        return (float)($result[0]->avg_rating ?? 0);
    }

    public static function getUserRating(int $articleId, int $userId): ?int
    {
        $sql = 'SELECT rating FROM ' . self::getTableName() . ' WHERE article_id = :article_id AND user_id = :user_id';
        $result = Db::getInstance()->query($sql, [
            ':article_id' => $articleId,
            ':user_id' => $userId
        ]);
        return $result ? (int)$result[0]->rating : null;
    }
} 