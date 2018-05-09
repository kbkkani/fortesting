<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoporateClient extends Model
{

    protected $fillable = [
        'business_name',
        'contact_no',
        'email',
        'pointof_fname_and_lastname',
        'pointof_email',
        'prefix_code',
        'isage',
        'agreement_text',
        'logo',
        'header_color',
        'footer_color'];

    public function courses()
    {
        return $this->belongsToMany('App\Course', 'client_course',
            'client_id', 'course_id');
    }


    public function subDomains(){
        return $this->hasMany('App\SubDomain','client_id');
    }

}
