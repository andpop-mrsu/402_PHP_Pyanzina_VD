<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $fillable = [
        'game_id',
        'step_number',
        'number1',
        'number2',
        'correct_answer',
        'player_answer',
        'is_correct',
    ];
}
