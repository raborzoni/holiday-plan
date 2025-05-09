<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HolidayPlan;
use Carbon\Carbon;

class HolidayPlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Plano de exemplo associado ao admin
        HolidayPlan::create([
            'title' => 'Holiday Plan Example',
            'description' => 'Holiday Plan Example.',
            'date' => Carbon::now()->addDays(30)->format('Y-m-d'),
            'location' => 'Rio de Janeiro, BR',
            'participants' => ['Admin Buzzvel'],
        ]);
    }
}