<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    //
    public function index()
    {
        $quizzes = Quiz::whereHas('user', function (Builder $query) {
            $query->where('role', '!=', 'suspended');
        })
            ->with('user', 'category')
            ->withCount('questions')
            // ->where('approved', true)
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return Inertia::render('Home', [
            'quizzes' => $quizzes,
        ]);

    }
}
