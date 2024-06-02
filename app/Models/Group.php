<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    // use SoftDeletes; //Para eliminacion suabe
    use SoftDeletes;

    // Si es una tabla que tiene una conexion con otra base de datos,
    // podemos especificarlo aqui referenciando a nuestras variables en .env
    // y nuestra configuracion de la base de datos

    protected $fillable = [
        'name',
        'quota',
        'duration'
    ];

    public function career()
    {
        return $this->belongsTo(career::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function teacherSchedules()
    {
        return $this->hasMany(TeacherSchedule::class);
    }

    public function assistances()
    {
        return $this->hasMany(Assistance::class);
    }

}
