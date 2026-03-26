<?php

namespace App\Models;
use Actuallymab\LaravelComment\Models\Comment as LaravelComment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class Comment extends LaravelComment
{
    protected $appends = ['student'];
    use HasFactory;

    /**
     * Get the student that owns the Comment
     *
     */
    public function getStudentAttribute()
    {
        return Student::find($this->commented_id);
    }
}
