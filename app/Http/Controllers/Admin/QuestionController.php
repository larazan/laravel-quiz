<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestionController extends Controller
{
    //
    public function index(Request $request)
    {
        $page = 10;
        $sort = 'asc';
        $questions = Question::whereHas('user', function (Builder $query) {
            $query->where('role', '!=', 'suspended');
        })
            ->with('user', 'quiz', 'type', 'option')
            ->when($request->q, function($query, $q){
                    $query->where('question_text', 'like', '%'.$q.'%');
                })
        // ->when(request('sort'), function ($q) {
        //     $direction = request('direction', 'asc');
        //     $q->orderBy(request('sort'), $direction);
        // })
         ->paginate($page)
        ->withQueryString();

        $types = Type::OrderBy('name', 'asc')->get();

        return Inertia::render('Admin/Question/Index', [
            'page' => $page,
            'questions' => $questions,
            'types' => $types,
            'search' => $request->only('q'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'questionText' => 'required',
            'difficulty' => 'required',
            'points' => 'required',
            'timeLimitSeconds' => 'required',
        ]);

        $user_id = Auth::user()->id;
        $type_id = $request->typeId;
        $question_text = $request->questionText;
        $difficulty = $request->difficulty;
        $points = $request->points;
        $time_limit_seconds = $request->timeLimitSeconds;
        $hint = $request->hint;

        Question::create([
            'user_id' => $user_id,
            'type_id' => $type_id,
            'question_text' => $question_text,
            'difficulty' => $difficulty,
            'points' => $points,
            'time_limit_seconds' => $time_limit_seconds,
            'hint' => $hint,
        ]);

        return redirect()->route('admin.question.index')->with('success', 'Question created successfully.');
    }

    public function update(Request $request, string $id)
    {
        //
        $request->validate([
           'questionText' => 'required',
            'difficulty' => 'required',
            'points' => 'required',
            'timeLimitSeconds' => 'required',
        ]);

        $question = Question::findOrFail($id);

        $question->user_id = Auth::user()->id;
        $question->type_id = $request->typeId;
        $question->question_text = $request->questionText;
        $question->difficulty = $request->difficulty;
        $question->points = $request->points;
        $question->time_limit_seconds = $request->timeLimitSeconds;
        $question->hint = $request->hint;

        $question->update();
        return redirect()->route('admin.question.index')->with('success', 'Question updated successfully.');
    }

    public function destroy(string $id)
    {
        //
        $question = Question::findOrFail($id);
        $question->delete();
        return redirect()->back()->with('success', 'Question deleted successfully.');
    }

    public function toggleActive(Question $question, Request $request)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $question->update(['is_active' => $request->is_active]);

        return back()->with('success', 'Question status approve change successfully!');
    }

    public function togglePrivate(Question $question, Request $request)
    {
        $request->validate([
            'is_private' => 'required|boolean',
        ]);

        $question->update(['is_private' => $request->is_private]);

        return back()->with('success', 'Question status private change successfully!');
    }
}
