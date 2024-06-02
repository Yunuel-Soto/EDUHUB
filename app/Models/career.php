<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class career extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function relationSubCareer()
    {
        return $this->hasMany(relation_sub_career::class);
    }

    public function group()
    {
        return $this->hasMany(Group::class);
    }
}