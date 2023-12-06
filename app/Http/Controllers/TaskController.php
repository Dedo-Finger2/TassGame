<?php

namespace App\Http\Controllers;

use App\Models\Powerup;
use App\Models\RemainingPowerup;
use App\Models\Task;
use App\Models\User;
use App\Models\SubTask;
use App\Models\Urgence;
use App\Models\Difficulty;
use App\Models\Importance;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\UserInventory;
use Illuminate\Support\Carbon;

class TaskController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $tasks = Task::all();
        $tasksId = Task::where('overdue', false)->pluck('id')->toArray();

        $data['tasks'] = $tasksId;

        $this->checkDueDate($data);

        return view('task.index', [
            'tasks' => $tasks,
        ]);
    }

    public function myTasks() {
        $todayTasks = Task::where('recurring', false)->where('user_id', auth()->user()->id)->where('completed_at', null)->get();
        $recurringTasks = Task::where('recurring', true)->where('user_id', auth()->user()->id)->where('completed_at', null)->get();
        $completedTasks = Task::where('user_id', auth()->user()->id)->where('completed_at', "!=", null)->get();

        $tasksId = Task::where('overdue', false)->pluck('id')->toArray();

        $data['tasks'] = $tasksId;

        $this->checkDueDate($data);
        // $this->refreshRecurringTasks($data);

        return view('task.my-tasks', [
            'todayTasks' => $todayTasks,
            'recurringTasks' => $recurringTasks,
            'completedTasks' => $completedTasks,
        ]);
    }

    public function myCompletedTasks() {
        $completedTasks = Task::where('user_id', auth()->user()->id)->where('completed_at', "!=", null)->get();

        return view('task.my-completed-tasks', [
            'completedTasks' => $completedTasks,
        ]);
    }

    public function completeTasks(Request $request) {
        $data = $request->validate([
            'tasks' => ['array']
        ]);

        if(count($data) <= 0)
            return redirect()->back()->with('error', 'No task selected.');

        if(!$this->checkTaskSubtasks($data))
            return redirect()->back()->with('error', "Complete all tasks's subtasks before completing the task itself!");

        if(count($data['tasks']) == 1) {
            $task = Task::find($data['tasks'][0]);

            if($task->overdue == false)
                $this->checkDueDate($data['tasks']);

            if($task->completed_before == false) {
                $coinBuff = PowerupController::applyPowerupBuffCoins();
                $expBuff = PowerupController::applyPowerupBuffExp();

                if($coinBuff !== null) {
                    $task->coins *= $coinBuff;
                } else {
                    $task->coins = $this->setTaskCoins($task->toArray());
                }

                if($expBuff !== null) {
                    $task->exp *= $expBuff;
                } else {
                    $task->coins = $this->setTaskExp($task->toArray());
                }

                $task->save();

                UserController::earnCoins($task->coins);
                UserController::earnExp($task->exp);
            }


            $task->completed_at = Carbon::now();
            $task->completed_before = true;

            $task->save();
        } else if(count($data['tasks']) > 1) {
            foreach($data['tasks'] as $task_id) {
                $task = Task::find($task_id);
                if($task->overdue == false)
                    $this->checkDueDate($data['tasks']);

                UserController::earnCoins($task->coins);
                UserController::earnExp($task->exp);

                $task->completed_at = Carbon::now();

                $task->save();
            }
        }

        return redirect()->back()->with('success', count($data['tasks'])."  tasks marked as done!");
    }

    public function uncompleteTasks(Request $request) {
        $data = $request->validate([
            'tasks' => ['array']
        ]);

        if(count($data) <= 0)
            return redirect()->back()->with('error', 'No task selected.');

        foreach($data['tasks'] as $task_id) {
            $task = Task::find($task_id);

            UserController::loseCoins($task->coins);
            UserController::loseExp($task->exp);

            $task->completed_at = null;

            $task->save();
        }

        return redirect()->back()->with('success', count($data['tasks'])."  tasks unmarked as done!");
    }


    private function setTaskCoins(array $data) {
        $urgenceCoins = Urgence::where('id', $data['urgence_id'])->pluck('coins');
        $importanceCoins = Importance::where('id', $data['importance_id'])->pluck('coins');
        $difficultyCoins = Difficulty::where('id', $data['difficulty_id'])->pluck('coins');

        $taskSumCoins = $urgenceCoins[0] + $importanceCoins[0] + $difficultyCoins[0];

        return $taskSumCoins;
    }


    private function setTaskExp(array $data) {

        $urgenceExp = Urgence::where('id', $data['urgence_id'])->pluck('exp');
        $importanceExp = Importance::where('id', $data['importance_id'])->pluck('exp');
        $difficultyExp = Difficulty::where('id', $data['difficulty_id'])->pluck('exp');

        $taskSumExp = $urgenceExp[0] + $importanceExp[0] + $difficultyExp[0];

        return $taskSumExp;
    }


    private function checkTaskSubtasks(array $data) {
        foreach($data['tasks'] as $task) {
            $task = Task::where('id', $task)->first();

            if(count($task->completedSubTasks) < count($task->subTasks)) {
                return false;
            }
        }

        return true;
    }





    private function checkDueDate(array $data) {
        date_default_timezone_set("America/Sao_Paulo");

        // $data['tasks'] = $data;

        if(!isset($data['tasks']))

            $data['tasks'] = $data;

        foreach($data['tasks'] as $task_id) {
            $task = Task::where('id', $task_id)->first();

            if($task->due_date != null && $task->overdue == false) {
                // dd("Cheguei");
                $taskDueDate = Carbon::createFromFormat('Y-m-d', $task->due_date)->startOfDay();
                $dateNow = Carbon::now()->setTimezone('America/Sao_Paulo')->startOfDay();

                if($dateNow->gt($taskDueDate)) {
                    $task->overdue = true;
                    $this->applyOverdueDebuff($task);
                }
            } else
                continue;
        }

        return true;
    }


    private function applyOverdueDebuff(Task &$task) {
        if($task->overdue == null)
            return false;

        try {
            $task->coins = $task->coins / 2;
            $task->exp = $task->exp / 2;

            $task->save();
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
    }





    public function refreshRecurringTasks() {
        date_default_timezone_set("America/Sao_Paulo");

        $dateNow = Carbon::now()->setTimezone('America/Sao_Paulo')->startOfDay();
        $refreshedTasks = 0;


        $recurringTasks = Task::where('user_id', auth()->user()->id)
            ->where('completed_at', '!=', null)
            ->where('recurring', true)
            ->get();

        if(count($recurringTasks) == 0)
            return redirect()->back();

        foreach($recurringTasks as $task) {
            if($task->recurring != true)
                continue;
            if($task->completed_at == null)
                continue;

            $taskCompletedAt = Carbon::createFromFormat('Y-m-d H:i:s', $task->completed_at)->startOfDay();

            if($taskCompletedAt->eq($dateNow))
                continue;

            if($taskCompletedAt->lessThan($dateNow)) {
                $task->completed_at = null;
                $task->save();
                $refreshedTasks++;
            } else {
                continue;
            }
        }

        if($refreshedTasks == 0)
            return redirect()->back()->with('error', 'No recurring task avaliable for refresh now. Come back later or tomorrow!');
        else
            return redirect()->back()->with('success', "$refreshedTasks recurring tasks were refreshed.");
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create() {
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
    public function store(Request $request) {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:tasks'],
            'description' => ['string'],
            'recurring' => ['numeric'],
            'importance_id' => ['required', 'exists:importances,id'],
            'urgence_id' => ['required', 'exists:urgences,id'],
            'difficulty_id' => ['required', 'exists:difficulties,id'],
            'user_id' => ['required', 'exists:users,id'],
            'due_date' => ['date', 'nullable'],
        ]);

        $data['coins'] = $this->setTaskCoins($data);
        $data['exp'] = $this->setTaskExp($data);

        $task = Task::create($data);

        if(isset($data['recurring'])) {
            $task->recurring = 1;
            $task->save();
        }

        return redirect()->route('tasks.index')->with('success', 'New task added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task) {
        $subTasks = SubTask::where('task_id', $task->id)->where('completed_at', null)->get();
        $completedSubTasks = SubTask::where('task_id', $task->id)->where('completed_at', "!=", null)->get();

        return view('task.show', [
            'task' => $task,
            'subTasks' => $subTasks,
            'completedSubTasks' => $completedSubTasks,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task) {
        $users = User::all();
        $urgences = Urgence::all();
        $importances = Importance::all();
        $difficulties = Difficulty::all();

        return view('task.edit', [
            'task' => $task,
            'users' => $users,
            'urgences' => $urgences,
            'importances' => $importances,
            'difficulties' => $difficulties,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task) {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:tasks,name,'.$task->id],
            'description' => ['string'],
            'recurring' => ['numeric'],
            'importance_id' => ['required', 'exists:importances,id'],
            'urgence_id' => ['required', 'exists:urgences,id'],
            'difficulty_id' => ['required', 'exists:difficulties,id'],
            'user_id' => ['required', 'exists:users,id'],
            'due_date' => ['date', 'nullable'],
        ]);

        $data['coins'] = $this->setTaskCoins($data);
        $data['exp'] = $this->setTaskExp($data);

        $task->update($data);

        if(isset($data['recurring'])) {
            $task->recurring = true;
            $task->save();
        } else {
            $task->recurring = false;
            $task->save();
        }

        return redirect()->route('tasks.index')->with('success', 'Task updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task) {
        try {
            $task->delete();
            return redirect()->route('tasks.index')->with('success', 'Task deleted!');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
