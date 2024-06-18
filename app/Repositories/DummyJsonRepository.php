<?php

namespace App\Repositories;

use App\Contracts\ExternalSourceInterface;
use App\DTO\PostDTO;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

final class DummyJsonRepository implements ExternalSourceInterface
{
    private string $host;
    private PendingRequest $httpBuilder;

    public function __construct()
    {
        $this->host = config('services.dummyjson.host');

        $this->httpBuilder = Http::withoutVerifying()
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ]);
    }

    public function getAllPostsByUserId(int $userId): array
    {
        return $this->httpBuilder->get(
            $this->buildUrl('/posts/user/' . $userId)
        )
            ->throw()
            ->json();
    }

    public function getPostById(int $postId): array
    {
        return $this->httpBuilder->get(
            $this->buildUrl('/posts/' . $postId)
        )
            ->json();
    }

    public function addNewPost(PostDTO $postDTO): array
    {
        return $this->httpBuilder->post(
            $this->buildUrl('/posts/add'),
            $postDTO->toArray()
        )
            ->throw()
            ->json();
    }

    public function updatePost(PostDTO $postDTO): array
    {
        return $this->httpBuilder->put(
            $this->buildUrl('/posts/' . $postDTO->getDummyPostId()),
            $postDTO->toArray()
        )
            ->throw()
            ->json();
    }

    public function deletePost(int $postId): array
    {
        return $this->httpBuilder->delete(
            $this->buildUrl('/posts/' . $postId)
        )
            ->throw()
            ->json();
    }

    private function buildUrl(string $endpoint): string
    {
        return trim($this->host . $endpoint);
    }

}
