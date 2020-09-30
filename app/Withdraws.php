<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdraws extends Model
{
    protected $fillable = ['amount','status','status_explanation','transaction_id','created_by'];
}
