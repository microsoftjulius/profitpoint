<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Investments extends Model
{
    protected $fillable = ['type','amount','phone_number','status','created_by'];
}
