<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'is_active',
        'force_password_change',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'force_password_change' => 'boolean',
        ];
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }
    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    /**
     * Get the display name for the user.
     */
    public function getNameAttribute()
    {
        if ($this->role === 'teacher' && $this->teacher) {
            return $this->teacher->fname . ' ' . $this->teacher->lname;
        }
        if ($this->role === 'student' && $this->student) {
            return $this->student->fname . ' ' . $this->student->lname;
        }
        return $this->username;
    }
}

