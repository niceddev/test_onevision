<?php

namespace App\Repositories;

use App\DTO\PostDTO;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

final class PostRepository
{
    public function __construct()
    {
    }

    public function getAll(): Collection
    {
        return Post::orderBy('id')->get();
    }

    public function create(PostDTO $postDTO): Post
    {
        return Post::create([
            'user_id'       => $postDTO->getUserId(),
            'dummy_post_id' => $postDTO->getDummyPostId()
        ]);
    }

    public function update(Post $post, PostDTO $postDTO): bool
    {
        return $post->update([
            'user_id'       => $postDTO->getUserId(),
            'dummy_post_id' => $postDTO->getDummyPostId()
        ]);
    }

    public function destroy(int $postId): int
    {
        return Post::destroy($postId);
    }

}
