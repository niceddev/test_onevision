@extends('layouts.app')

@section('title')
    {{ __('Создать пользователя') }}
@endsection

@section('content')

    <section>
        <div class="py-16 px-4 mx-auto max-w-2xl">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
                {{ __('Новый пост') }}
            </h2>
            <form action="{{ route('posts.store') }}" method="POST">
                @csrf
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                    <div class="sm:col-span-2">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            {{ __('Заголовок') }}
                        </label>
                        <input type="text" name="title" id="title"
                               placeholder="{{ __('Введите заголовок поста') }}" required=""
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="body" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            {{ __('Контент') }}
                        </label>
                        <textarea name="body" id="body" rows="4"
                                  placeholder="{{ __('О чем этот пост?') }}"
                                  class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                    </div>
                </div>
                <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-green-500 rounded-lg focus:ring-4 focus:ring-green-200 dark:focus:ring-green-900 hover:bg-green-600">
                    {{ __('Создать пост') }}
                </button>
                <a href="{{ route('posts.index') }}" type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-yellow-400 rounded-lg focus:ring-4 focus:ring-yellow-200 dark:focus:ring-yellow-900 hover:bg-yellow-500">
                    {{ __('Отмена') }}
                </a>
            </form>
        </div>
    </section>

@endsection
