<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayPlanPDF extends Model
{
    use HasFactory;

    protected $fillable = [
        'holiday_plan_id', 
        'file_path'
    ];

    public function holidayPlan()
    {
        return $this->belongsTo(HolidayPlan::class);
    }
}
