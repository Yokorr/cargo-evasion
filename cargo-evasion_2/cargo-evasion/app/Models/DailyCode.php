<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyCode extends Model
{
    protected $fillable = ['date_day', 'access_code'];
}
