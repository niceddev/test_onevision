<?php

namespace App\DTO;

class PostDTO
{
    public function __construct(
        protected int     $userId,
        protected string  $title,
        protected string  $body,
        protected ?int    $dummyPostId = null,
        protected ?string $authorName = null,
    )
    {
    }

    public function getDummyPostId(): ?int
    {
        return $this->dummyPostId;
    }

    public function setDummyPostId(?int $dummyPostId): self
    {
        $this->dummyPostId = $dummyPostId;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getAuthorName(): ?string
    {
        return $this->authorName;
    }

    public function setAuthorName(?string $authorName): self
    {
        $this->authorName = $authorName;
        return $this;
    }


    public function toArray(): array
    {
        return [
            'id'         => $this?->dummyPostId,
            'title'      => $this->title,
            'body'       => $this->body,
            'userId'     => $this->userId,
            'authorName' => $this->authorName,
        ];
    }
}
