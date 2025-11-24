<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Quiz;
use Inertia\Inertia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    //
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $quizzes = Quiz::whereHas('user', function (Builder $query) {
            $query->where('role', '!=', 'suspended');
        })
            ->with('user', 'category')
            ->withCount('questions')
            ->when($request->q, function($query, $q){
                $query->where('title', 'like', '%'.$q.'%');
            })
            // ->where('approved', true)
            ->filter(request(['search', 'user_id', 'cat', 'diff']))
            ->latest()
            ->paginate(2)
            ->withQueryString();

        $categories = Category::OrderBy('name', 'asc')->get();

        return Inertia::render('Front/Quiz/QuizList', [
            'quizzes' => $quizzes,
            'categories' => $categories,
            'search' => $request->only('q'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $quiz = Quiz::whereHas('user', function (Builder $query) {
            $query->where('role', '!=', 'suspended');
        })
            ->with('user', 'category')
            ->withCount('questions')
            ->where('slug', $slug)
            ->firstOrFail();

        return Inertia::render('Front/Quiz/Show', [
            'quiz' => $quiz,
        ]);
    }
}


