<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $uuid)
    {
        try {
            $request->validate([ 'comment' => 'required|string' ]);

            $task_id = Task::where('uuid', $uuid)->value('id');
            $user_id = auth()->user()->id;

            Comment::create([
                'task_id' => $task_id,
                'user_id' => $user_id,
                'comment' => $request->comment
            ]);

            return redirect()->back()->with('success', 'Komentar berhasil dikirim.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }
}
