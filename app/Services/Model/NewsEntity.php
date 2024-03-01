<?php

namespace App\Services\Model;

use App\Models\News;

class NewsEntity
{
    private ?int $id;
    private ?string $title;
    private ?string $content;
    private ?int $creatorId;
    private ?string $imageUrl;
    private ?string $createdAt;
    private ?UserEntity $user;

    public function __construct(
        ?int        $id = null,
        ?string     $title = null,
        ?string     $content = null,
        ?int        $creatorId = null,
        ?string     $imageUrl = null,
        ?string     $createdAt = null,
        ?UserEntity $user = null,
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->creatorId = $creatorId;
        $this->imageUrl = $imageUrl;
        $this->createdAt = $createdAt;
        $this->user = $user;
    }

    public static function fromNews(?News $news): NewsEntity
    {
        $user = UserEntity::fromUser($news->user);

        return new NewsEntity(
            id: $news->id,
            title: $news->title,
            content: $news->content,
            creatorId: $news->creator_id,
            imageUrl: $news->image_url,
            createdAt: $news->created_at,
            user: $user,
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function getCreatorId(): ?int
    {
        return $this->creatorId;
    }

    public function setCreatorId(?int $creatorId): void
    {
        $this->creatorId = $creatorId;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUser(): ?UserEntity
    {
        return $this->user;
    }

    public function setUser(?UserEntity $user): void
    {
        $this->user = $user;
    }


}
