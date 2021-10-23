<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        $tasks = Task::query()->orderByDesc('id')->get();
        return response()->json(['data' => $tasks]);
    }

    public function store(TaskRequest $request)
    {
        try {
            //TODO make a validation for now select user to have a default useer for task
            $user = User::find(1);
            $task = $user->tasks()->create($request->validated());
            return response()->json(['data' => $task]);
        } catch (\Throwable $t) {
            return response()->json(['message' => $t->getMessage()]);
        }
    }

    public function destroy(Task $task)
    {
       try {
           $deletedTask = $task->delete();
           return response()->json(['data' => $deletedTask, 'message' => 'Tasks was deleted']);
       } catch(\Throwable $t) {
           return response()->json(['message' => $t->getMessage()]);
       }
    }
}
