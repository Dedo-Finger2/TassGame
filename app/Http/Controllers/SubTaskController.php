<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\SubTask;
use App\Models\Urgence;
use App\Models\Difficulty;
use App\Models\Importance;
use Illuminate\Http\Request;

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
            'name' => ['required', 'string', 'unique:subtasks'],
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

        return $taskSumCoins;
    }


    private function setTaskExp(array $data)
    {
        $urgenceExp = Urgence::where('id', $data['urgence_id'])->pluck('exp');
        $importanceExp = Importance::where('id', $data['importance_id'])->pluck('exp');
        $difficultyExp = Difficulty::where('id', $data['difficulty_id'])->pluck('exp');

        $taskSumExp = $urgenceExp[0] + $importanceExp[0] + $difficultyExp[0];

        return $taskSumExp;
    }
}
