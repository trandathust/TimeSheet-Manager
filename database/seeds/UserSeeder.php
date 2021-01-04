<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Giám Đốc',
                'email' => 'giamdoc@gmail.com',
                'password' => Hash::make('123456'),
                'role'  => 'president'
            ],
            [
                'name' => 'Quản Lý',
                'email' => 'quanly@gmail.com',
                'password' => Hash::make('123456'),
                'role'  => 'manager'
            ],
            [
                'name' => 'Cộng Tác Viên',
                'email' => 'congtacvien@gmail.com',
                'password' => Hash::make('123456'),
                'role'  => 'ctv',
            ],

        ]);
    }
}
