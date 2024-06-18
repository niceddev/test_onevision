<?php

namespace App\Services;

use App\Contracts\ExternalSourceInterface;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{
    public function __construct(
        protected ExternalSourceInterface $source,
        protected PostRepository          $postRepository,
    )
    {
    }

    public function getNextPostId(): int
    {
        return Post::get()->last()?->id + 1 ?? 1;
    }

    public function getPaginated($currentPage, $perPage): LengthAwarePaginator
    {
        $postsArray = $this->postRepository->getAll()
            ->map(function ($post) {
                $postData = $this->source->getPostById($post->dummy_post_id);
                $postData['id'] = $post->id;
                $postData['userId'] = $post->user_id;
                $postData['authorName'] = $post->user->name;
                $postData['body'] = substr($postData['body'], 0, 128) . '...';
                return $postData;
            })
            ->all();

        return new LengthAwarePaginator(
            array_slice($postsArray, ($currentPage * $perPage) - $perPage, $perPage, true),
            count($postsArray),
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );
    }

}
