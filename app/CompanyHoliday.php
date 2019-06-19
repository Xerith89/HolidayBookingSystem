<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyHoliday extends Model
{
    protected $dates = ['created_at', 'updated_at', 'holiday_date'];
}
