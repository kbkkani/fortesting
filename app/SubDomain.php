<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubDomain extends Model
{

    protected $fillable = [
        'client_id',
        'domain_url'];
    //
}
