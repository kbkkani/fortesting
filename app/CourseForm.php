<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseForm extends Model
{
    protected $table = 'course_forms';
    protected $fillable = ['course_id', 'type'];
    public $timestamps = false;
}
