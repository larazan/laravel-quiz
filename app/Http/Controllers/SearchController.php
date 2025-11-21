<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    //
    public function suggest(Request $request)
    {
        $q = $request->q;

        // Example search – adapt to your models
        $results = \App\Models\Post::where('title', 'like', "%{$q}%")
            ->limit(5)
            ->get(['title', 'slug'])
            ->map(fn ($post) => [
                'title' => $post->title,
                'description' => 'Post',
                'url' => route('posts.show', $post->slug),
            ]);

        return Inertia::render('Empty', [
            'suggestions' => $results,
        ]);
    }
}
