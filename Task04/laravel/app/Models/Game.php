<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'player_name',
        'correct_answers',
        'total_questions',
    ];

    public function steps()
    {
        return $this->hasMany(Step::class);
    }
}
