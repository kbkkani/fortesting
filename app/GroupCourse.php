<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupCourse extends Model
{
    protected $table = 'group_courses';
    public $timestamps = false;
    protected $fillable = ['course_id',"group_id"];
}
