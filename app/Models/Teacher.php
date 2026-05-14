<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Teacher extends Model
{
    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'email',
        'contact_no',
        'birthdate',
        'gender',
        'degree_id',
        'user_id',
        'address',
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
        return $this->hasMany(Course::class);
    }
}
