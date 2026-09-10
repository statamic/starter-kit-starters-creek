<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Statamic\Facades\Entry;
use Statamic\Facades\User;
use Statamic\View\View;

Route::get('search', function (Request $request) {
    $query = $request->query('q', '');
    $query = is_string($query) ? mb_substr(trim($query), 0, 200) : '';

    return View::make('search', [
        'title' => 'Search',
        'intro' => 'Search articles from the publication.',
        'search_query' => $query,
        'has_search_query' => $query !== '',
        'has_articles' => Entry::query()->where('collection', 'blog')->whereStatus('published')->exists(),
    ])->layout('layout');
})->middleware('statamic.web');

Route::get('authors/{handle}', function (string $handle) {
    $author = User::query()->where('handle', $handle)->first();
    if (! $author) {
        return response(View::make('errors.404', ['title' => 'Page not found'])->layout('layout')->render(), 404);
    }

    return View::make('author.show', ['title' => $author->get('name'), 'intro' => $author->get('bio') ?? 'Articles by '.$author->get('name')])->layout('layout');
})->middleware('statamic.web');

// Custom author routes are not automatically discovered by the optional SSG.
if (class_exists(\Statamic\StaticSite\SSG::class)) {
    \Statamic\StaticSite\SSG::addUrls(fn () => User::all()
        ->filter(fn ($user) => filled($user->get('handle')))
        ->map(fn ($user) => '/authors/'.$user->get('handle'))
        ->values()
        ->all());
}
