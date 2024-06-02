<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class relation_sub_career extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function career()
    {
        return $this->belongsTo(career::class);
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}