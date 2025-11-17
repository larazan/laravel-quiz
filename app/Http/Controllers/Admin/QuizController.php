<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quiz;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Type;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuizController extends Controller
{
    //
    public function index(Request $request)
    {
        $page = 10;
        $sort = 'asc';
        $quizzes = Quiz::whereHas('user', function (Builder $query) {
            $query->where('role', '!=', 'suspended');
        })
            ->with('user', 'category', 'type')
            ->withCount('questions')
            ->when($request->q, function($query, $q){
                    $query->where('title', 'like', '%'.$q.'%');
                })
        // ->when(request('sort'), function ($q) {
        //     $direction = request('direction', 'asc');
        //     $q->orderBy(request('sort'), $direction);
        // })
         ->paginate($page)
        ->withQueryString();

        $categories = Category::OrderBy('name', 'asc')->get();
        $types = Type::OrderBy('name', 'asc')->get();

        return Inertia::render('Admin/Quiz/Index', [
           'page' => $page,
            'quizzes' => $quizzes,
            'categories' => $categories,
            'types' => $types,
            'search' => $request->only('q'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoryId' => 'required',
            'title' => 'required',
            'description' => 'required',
            'difficulty' => 'required',
            'timeLimitSeconds' => 'required',
            'displayMode' => 'required',
        ]);

        $user_id = Auth::user()->id;
        $category_id = $request->categoryId;
        $type_id = $request->typeId;
        $title = $request->title;
        $description = $request->description;
        $difficulty = $request->difficulty;
        $time_limit_seconds = $request->timeLimitSeconds;
        $display_mode = $request->displayMode;

        Quiz::create([
            'user_id' => $user_id,
            'category_id' => $category_id,
            'type_id' => $type_id,
            'title' => $title,
            'description' => $description,
            'difficulty' => $difficulty,
            'time_limit_seconds' => $time_limit_seconds,
            'display_mode' => $display_mode,
        ]);

        return redirect()->route('admin.quiz.index')->with('success', 'Quiz created successfully.');
    }

    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'categoryId' => 'required',
            'title' => 'required',
            'description' => 'required',
            'difficulty' => 'required',
            'timeLimitSeconds' => 'required',
            'displayMode' => 'required',
        ]);

        $quiz = Quiz::findOrFail($id);

        $quiz->user_id = Auth::user()->id;
        $quiz->category_id = $request->categoryId;
        $quiz->type_id = $request->typeId;
        $quiz->title = $request->title;
        $quiz->description = $request->description;
        $quiz->difficulty = $request->difficulty;
        $quiz->time_limit_seconds = $request->timeLimitSeconds;
        $quiz->display_mode = $request->displayMode;

        $quiz->update();
        return redirect()->route('admin.quiz.index')->with('success', 'Quiz updated successfully.');
    }

    public function destroy(string $id)
    {
        //
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();
        return redirect()->back()->with('success', 'Quiz deleted successfully.');
    }

    public function togglePublish(Quiz $quiz, Request $request)
    {
        $request->validate([
            'is_published' => 'required|boolean',
        ]);

        $quiz->update(['is_published' => $request->is_published]);

        return back()->with('success', 'Quiz status publish change successfully!');
    }

    public function toggleApprove(Quiz $quiz, Request $request)
    {
        $request->validate([
            'is_approved' => 'required|boolean',
        ]);

        $quiz->update(['is_approved' => $request->is_approved]);

        return back()->with('success', 'Quiz status approve change successfully!');
    }

    public function togglePrivate(Quiz $quiz, Request $request)
    {
        $request->validate([
            'is_private' => 'required|boolean',
        ]);

        $quiz->update(['is_private' => $request->is_private]);

        return back()->with('success', 'Quiz status private change successfully!');
    }
}
