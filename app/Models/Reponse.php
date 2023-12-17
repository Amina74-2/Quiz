<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reponse extends Model
{
    use HasFactory;

protected $fillable=['reponse','question_id'];

    public function Question(){
        return $this->belongsTo(Question::class);
    }
}
