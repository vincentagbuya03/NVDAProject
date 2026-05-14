<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'description',
        'teacher_id',
        'degree_id'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function students(){
        return $this->belongsToMany(Student::class, 'course_students', 'course_id', 'student_id');
    }
}
