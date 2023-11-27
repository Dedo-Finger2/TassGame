<?php

namespace App\Http\Controllers;

use App\Models\Difficulty;
use App\Models\Importance;
use App\Models\Task;
use App\Models\Urgence;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();

        return view('task.index', [
            'tasks' => $tasks,
        ]);
    }

    public function myTasks()
    {
        $todayTasks = Task::where('recurring', false)->where('user_id', auth()->user()->id)->get();
        $recurringTasks = Task::where('recurring', true)->where('user_id', auth()->user()->id)->get();

        return view('task.my-tasks', [
            'todayTasks' => $todayTasks,
            'recurringTasks' => $recurringTasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $urgences = Urgence::all();
        $importances = Importance::all();
        $difficulties = Difficulty::all();

        return view('task.create', [
            'users' => $users,
            'urgences' => $urgences,
            'importances' => $importances,
            'difficulties' => $difficulties,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:tasks'],
            'exp' => ['required', 'numeric', 'min:1'],
            'coins' => ['required', 'numeric', 'min:1'],
            'description' => ['string'],
            'recurring' => ['numeric'],
            'importance_id' => ['required', 'exists:importances,id'],
            'urgence_id' => ['required', 'exists:urgences,id'],
            'difficulty_id' => ['required', 'exists:difficulties,id'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $task = Task::create($data);

        if ($data['recurring']) {
            $task->recurring = 1;
            $task->save();
        }

        return redirect()->route('tasks.index')->with('success', 'New task added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
