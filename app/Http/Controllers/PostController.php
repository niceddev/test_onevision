<?php

namespace App\Http\Controllers;

use App\Contracts\ExternalSourceInterface;
use App\DTO\PostDTO;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(
        protected PostService             $postService,
        protected PostRepository          $postRepository,
        protected ExternalSourceInterface $source,
    )
    {
    }

    public function index(): View
    {
        $currentPage = request()->input('page', 0);
        $perPage = 10;

        return view('modules.post.index', [
            'posts'            => $this->postService->getPaginated($currentPage, $perPage),
            'postsTotalAmount' => Post::count(),
        ]);
    }

    public function create(): View
    {
        return view('modules.post.create');
    }

    public function store(PostRequest $postRequest): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $currentUserId = auth()->user()->id;

            $postDTO = new PostDTO(
                userId: $currentUserId,
                title: $postRequest->input('title'),
                body: $postRequest->input('body'),
                dummyPostId: $this->postService->getNextPostId()
            );

            $this->source->addNewPost(
                $postDTO
            );

            $this->postRepository->create(
                $postDTO
            );

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->route('posts.create')
                ->with('error', $exception->getMessage());
        }

        return redirect()->route('posts.index')->with('success', __('Пост успешно создан!'));
    }

    public function edit(Post $post): View
    {
        $postData = $this->source->getPostById($post->id);

        $postDTO = new PostDTO(
            userId: auth()->user()->id,
            title: $postData['title'],
            body: $postData['body'],
            dummyPostId: $post->id,
            authorName: $post->user->name
        );

        return view('modules.post.edit', [
            'post' => $postDTO
        ]);
    }

    public function update(PostRequest $postRequest, Post $post): RedirectResponse
    {
        $postDTO = new PostDTO(
            userId: auth()->user()->id,
            title: $postRequest->input('title'),
            body: $postRequest->input('body'),
            dummyPostId: $post->id,
        );

        DB::beginTransaction();
        try {
            $this->source->updatePost($postDTO);
            $this->postRepository->update($post, $postDTO);

            DB::commit();
        } catch (\Exception) {
            DB::rollBack();
            return redirect()->route('posts.create')->with('error', __('Ошибка на стороне внешнего сервиса!'));
        }

        return redirect()->route('posts.index')->with('success', 'Пост изменен!');
    }

    public function destroy(Post $post): RedirectResponse
    {
        try {
            $this->source->deletePost($post->id);
            $this->postRepository->destroy($post->id);
        } catch (\Exception) {
            return redirect()->route('posts.index')->with('error', __('Ошибка на стороне внешнего сервиса!'));
        }

        return redirect()->route('posts.index')->with('success', __('Пост удален!'));
    }

}
