<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Urgence;
use App\Models\Difficulty;
use App\Models\Importance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
        $todayTasks     = Task::where('recurring', false)->where('user_id', auth()->user()->id)->where('completed_at', null)->get();
        $recurringTasks = Task::where('recurring', true)->where('user_id', auth()->user()->id)->where('completed_at', null)->get();
        $completedTasks = Task::where('user_id', auth()->user()->id)->where('completed_at', "!=", null)->get();

        return view('task.my-tasks', [
            'todayTasks'     => $todayTasks,
            'recurringTasks' => $recurringTasks,
            'completedTasks' => $completedTasks,
        ]);
    }

    public function myCompletedTasks()
    {
        $completedTasks = Task::where('user_id', auth()->user()->id)->where('completed_at', "!=", null)->get();

        return view('task.my-completed-tasks', [
            'completedTasks' => $completedTasks,
        ]);
    }

    public function completeTasks(Request $request)
    {
        $data = $request->validate([
            'tasks' => ['array']
        ]);

        if (count($data) <= 0)
            return redirect()->back()->with('error', 'No task selected.');

        foreach ($data['tasks'] as $task_id) {
            $task = Task::find($task_id);

            UserController::earnCoins($task->coins);
            UserController::earnExp($task->exp);

            $task->completed_at = Carbon::now();

            $task->save();
        }

        return redirect()->back()->with('success', count($data['tasks']) . "  tasks marked as done!");
    }

    public function uncompleteTasks(Request $request)
    {
        $data = $request->validate([
            'tasks' => ['array']
        ]);

        if (count($data) <= 0)
            return redirect()->back()->with('error', 'No task selected.');

        foreach ($data['tasks'] as $task_id) {
            $task = Task::find($task_id);

            UserController::loseCoins($task->coins);
            UserController::loseExp($task->exp);

            $task->completed_at = null;

            $task->save();
        }

        return redirect()->back()->with('success', count($data['tasks']) . "  tasks unmarked as done!");
    }


    private function setTaskCoins(array $data)
    {
        $urgenceCoins    = Urgence::where('id', $data['urgence_id'])->pluck('coins');
        $importanceCoins = Importance::where('id', $data['importance_id'])->pluck('coins');
        $difficultyCoins = Difficulty::where('id', $data['difficulty_id'])->pluck('coins');

        $taskSumCoins = $urgenceCoins[0] + $importanceCoins[0] + $difficultyCoins[0];

        return $taskSumCoins;
    }


    private function setTaskExp(array $data)
    {
        $urgenceExp    = Urgence::where('id', $data['urgence_id'])->pluck('exp');
        $importanceExp = Importance::where('id', $data['importance_id'])->pluck('exp');
        $difficultyExp = Difficulty::where('id', $data['difficulty_id'])->pluck('exp');

        $taskSumExp = $urgenceExp[0] + $importanceExp[0] + $difficultyExp[0];

        return $taskSumExp;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users        = User::all();
        $urgences     = Urgence::all();
        $importances  = Importance::all();
        $difficulties = Difficulty::all();

        return view('task.create', [
            'users'        => $users,
            'urgences'     => $urgences,
            'importances'  => $importances,
            'difficulties' => $difficulties,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => ['required', 'string', 'unique:tasks'],
            'description'   => ['string'],
            'recurring'     => ['numeric'],
            'importance_id' => ['required', 'exists:importances,id'],
            'urgence_id'    => ['required', 'exists:urgences,id'],
            'difficulty_id' => ['required', 'exists:difficulties,id'],
            'user_id'       => ['required', 'exists:users,id'],
        ]);

        $data['coins'] = $this->setTaskCoins($data);
        $data['exp'] = $this->setTaskExp($data);

        $task = Task::create($data);

        if (isset($data['recurring'])) {
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
