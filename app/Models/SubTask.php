<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
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
        'task_id',
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

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
