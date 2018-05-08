<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';
    public $timestamps = false;

    public function client()
    {
        return $this->belongsToMany('App\CoporateClient', 'client_course',
            'course_id', 'client_id');
    }

    public function courseType(){
        return $this->hasOne('App\CourseForm');
    }

}
