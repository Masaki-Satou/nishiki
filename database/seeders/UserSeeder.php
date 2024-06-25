<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
                'id'=>100,//最初のユーザーID　ここまではゲストユーザー用
                'name'=>'佐藤　政樹',
                'email'=>'masakisatou0907@gmail.com',
                'password'=>Hash::make(('masakisatou')),
            ],

            [
                'id'=>101,//最初のユーザーID　ここまではゲストユーザー用
                'name'=>'ワンベスト佐藤',
                'email'=>'onebest.sato@gmail.com',
                'password'=>Hash::make(('onebestsato')),
            ],

            [
                'id'=>102,//最初のユーザーID　ここまではゲストユーザー用
                'name'=>'ワンベスト山下',
                'email'=>'onebest.yamashita@gmail.com',
                'password'=>Hash::make(('onebest')),
            ],


        ]);
    }
}
