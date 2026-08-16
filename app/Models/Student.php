<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    protected $fillable = [
    'name',
    'email',
    'course_id',
    'semester',
    'profile_image'
     ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}