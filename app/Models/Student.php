<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'contact_no',
        'birthdate',
        'gender',
        'degree_id',
        'user_id',
        'address',
        'email',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function degree(): BelongsTo
    {
        return $this->belongsTo(Degree::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_students', 'student_id', 'course_id');
    }
}
