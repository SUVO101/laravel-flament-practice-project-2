<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    protected $fillable = [
        'title',
        'description',
        'duration',
    ];
    public function students():BelongsToMany
    {
        // return $this->belongsToMany(Student::class,'course_student','course_id','student_id')->withPivot(['status', 'completed_at'])->withTimestamps();
        return $this->belongsToMany(Student::class,'course_student')->withPivot(['status', 'completed_at'])->withTimestamps();
    }
}
