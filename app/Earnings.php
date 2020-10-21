<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Earnings extends Model
{
    protected $fillable = ['sponsor_id','referral_id','amount'];
}
