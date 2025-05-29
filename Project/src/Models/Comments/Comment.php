<?php

namespace src\Models\Comments;

use src\Models\ActiveRecordEntity;
use src\Models\Users\User;
use src\Models\Articles\Article;
use src\Services\Db;

class Comment extends ActiveRecordEntity
{
    protected $text;
    protected $authorId;
    protected $articleId;
    protected $createdAt;

    protected static function getTableName(): string
    {
        return 'comments';
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getAuthor(): User
    {
        if (is_int($this->authorId)) {
            $this->authorId = User::getById($this->authorId);
        }
        
        return $this->authorId;
    }

    public function getArticleId(): int
    {
        return $this->articleId;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }

    public function setArticleId(int $articleId): void
    {
        $this->articleId = $articleId;
    }

    public static function getCommentsByArticleId(int $articleId): array
    {
        $sql = 'SELECT * FROM "'.self::getTableName().'" WHERE "article_id" = :article_id ORDER BY "created_at" DESC';
        return Db::getInstance()->query($sql, [':article_id' => $articleId], self::class);
    }
} 