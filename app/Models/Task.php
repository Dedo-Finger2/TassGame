<?php

namespace App\Models;

use App\Models\User;
use App\Models\SubTask;
use App\Models\Difficulty;
use App\Models\Importance;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'exp',
        'coins',
        'importance_id',
        'urgence_id',
        'difficulty_id',
        'user_id',
    ];

    public function urgence()
    {
        return $this->belongsTo(Urgence::class);
    }


    public function importance()
    {
        return $this->belongsTo(Importance::class);
    }


    public function difficulty()
    {
        return $this->belongsTo(Difficulty::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subTasks()
    {
        return $this->hasMany(SubTask::class);
    }

    public function completedSubTasks()
    {
        return $this->hasMany(SubTask::class)->whereNotNull('completed_at');
    }

}
