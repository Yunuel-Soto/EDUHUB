<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'enrollment',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function teacherSchedules()
    {
        return $this->hasMany(TeacherSchedule::class);
    }

    public function getRoles($rol)
    {
        $roles = Auth::user()->rol;
        $rolesArray = preg_split("/[;]/", $roles);

        return in_array($rol, $rolesArray);
    }

    public function ROLES() {
        return $ROLES = [
            'ROLE_USER',
            'ROLE_STUDENT',
            'ROLE_TEACHER',
            'ROLE_ADMIN',
            'ROLE_SUPERADMIN',
        ];
    }
}
