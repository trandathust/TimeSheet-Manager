<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            [
                'name'  => 'Thời Gian Cộng Tác Viên',
                'config_key' => 'date_ctv',
                'config_value' => 3,
            ],
            [
                'name'  => 'Ngày Tính Lương',
                'config_key' => 'date_salary',
                'config_value' => '5',
            ],
            [
                'name'  => 'Chân Trang',
                'config_key' => 'footer',
                'config_value' => 'Copyright © 2014-2019 SkymapGlobal. All rights reserved.',
            ],
            [
                'name'  => 'Logo',
                'config_key' => 'logo',
                'config_value' => '/storage/logo/1/ywzaCri3h1NMS1K6n4Cx.png',
            ],
            [
                'name'  => 'Hệ Số Lương',
                'config_key' => 'salary',
                'config_value' => 35000,
            ]
        ]);
    }
}
