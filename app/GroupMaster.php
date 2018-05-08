<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMaster extends Model
{
    protected $table = 'group_master';
    public $timestamps = false;
    protected $fillable = ["title"];
}
