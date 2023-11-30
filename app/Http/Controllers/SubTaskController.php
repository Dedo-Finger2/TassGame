<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\SubTask;
use App\Models\Urgence;
use App\Models\Difficulty;
use App\Models\Importance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SubTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subTasks = SubTask::all();

        return view('subtask.index', [
            'subTasks' => $subTasks,
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
        $tasks = Task::all();

        return view('subtask.create', [
            'users' => $users,
            'urgences' => $urgences,
            'importances' => $importances,
            'difficulties' => $difficulties,
            'tasks' => $tasks,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:sub_tasks'],
            'description' => ['string'],
            'importance_id' => ['required', 'exists:importances,id'],
            'urgence_id' => ['required', 'exists:urgences,id'],
            'difficulty_id' => ['required', 'exists:difficulties,id'],
            'task_id' => ['required', 'exists:tasks,id'],
        ]);

        $data['coins'] = $this->setTaskCoins($data);
        $data['exp'] = $this->setTaskExp($data);

        SubTask::create($data);

        return redirect()->route('sub-tasks.index')->with('success', 'New task added!');
    }


    private function setTaskCoins(array $data)
    {
        $urgenceCoins = Urgence::where('id', $data['urgence_id'])->pluck('coins');
        $importanceCoins = Importance::where('id', $data['importance_id'])->pluck('coins');
        $difficultyCoins = Difficulty::where('id', $data['difficulty_id'])->pluck('coins');

        $taskSumCoins = $urgenceCoins[0] + $importanceCoins[0] + $difficultyCoins[0];

        return $taskSumCoins / 3;
    }


    private function setTaskExp(array $data)
    {
        $urgenceExp = Urgence::where('id', $data['urgence_id'])->pluck('exp');
        $importanceExp = Importance::where('id', $data['importance_id'])->pluck('exp');
        $difficultyExp = Difficulty::where('id', $data['difficulty_id'])->pluck('exp');

        $taskSumExp = $urgenceExp[0] + $importanceExp[0] + $difficultyExp[0];

        return $taskSumExp / 3;
    }


    public function completeSubTasks(Request $request)
    {
        $data = $request->validate([
            'subTasks'=> ['array'],
        ]);

        if (count($data) <= 0)
            return redirect()->back()->with('error', 'No sub-task selected.');

        foreach ($data['subTasks'] as $subTaks_id) {
            $subTask = SubTask::find($subTaks_id);

            UserController::earnCoins($subTask->coins);
            UserController::earnExp($subTask->exp);

            $subTask->completed_at = Carbon::now();

            $subTask->save();
        }

        return redirect()->back()->with('success', count($data['subTasks']) . "  sub-tasks marked as done!");
    }


    public function uncompleteSubTasks(Request $request)
    {
        $data = $request->validate([
            'subTasks' => ['array']
        ]);

        if (count($data) <= 0)
            return redirect()->back()->with('error', 'No task selected.');

        foreach ($data['subTasks'] as $subTask_id) {
            $subTask = SubTask::find($subTask_id);

            UserController::loseCoins($subTask->coins);
            UserController::loseExp($subTask->exp);

            $subTask->completed_at = null;

            $subTask->save();
        }

        return redirect()->back()->with('success', count($data['subTasks']) . "  subTasks unmarked as done!");
    }


    /**
     * Display the specified resource.
     */
    public function show(SubTask $sub_task)
    {
        return view('subtask.show', [
            'subTask' => $sub_task,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubTask $sub_task)
    {
        $tasks = Task::all();
        $urgences = Urgence::all();
        $importances = Importance::all();
        $difficulties = Difficulty::all();

        return view('subtask.edit', [
            'subTask' => $sub_task,
            'tasks' => $tasks,
            'urgences' => $urgences,
            'importances' => $importances,
            'difficulties' => $difficulties,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubTask $subTask)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:sub_tasks,name,' . $subTask->id],
            'description' => ['string'],
            'importance_id' => ['required', 'exists:importances,id'],
            'urgence_id' => ['required', 'exists:urgences,id'],
            'difficulty_id' => ['required', 'exists:difficulties,id'],
            'task_id' => ['required', 'exists:tasks,id'],
        ]);

        $data['coins'] = $this->setTaskCoins($data);
        $data['exp'] = $this->setTaskExp($data);

        $subTask->update($data);

        return redirect()->route('sub-tasks.index')->with('success', 'SubTask updated!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subtask $subTask)
    {
        //
    }
}
