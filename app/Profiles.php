<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
    protected $fillable = ['phone_number','country','currency','profile_picture'];
}
