<?php

namespace Database\Seeders;

use App\Models\Settings\BillSetting;
use Illuminate\Database\Seeder;

class BillSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $billSettings = [
            ['title' => 'unit_price', 'type' => '1', 'value' => '150'],
            ['title' => 'service_charge', 'type' => '1', 'value' => '40'],
            ['title' => 'penalty_for_late_payment', 'type' => '1', 'value' => '50'],
        ];

        foreach ($billSettings as $setting) {
            $check_exist = BillSetting::where('title', $setting['title'])->first();
            if (!$check_exist) {
                BillSetting::create([
                    'title' => $setting['title'],
                    'type' => $setting['type'],
                    'value' => $setting['value'],
                ]);
            }
        }
    }
}
