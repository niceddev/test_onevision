<?php

namespace App\Contracts;

use App\DTO\PostDTO;

interface ExternalSourceInterface
{
    public function getAllPostsByUserId(int $userId): array;
    public function getPostById(int $postId): array;
    public function addNewPost(PostDTO $postDTO): array;
    public function updatePost(PostDTO $postDTO): array;
    public function deletePost(int $postId): array;

}
