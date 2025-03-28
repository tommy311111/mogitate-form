<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
        'name' => '春',
         ];
        DB::table('seasons')->insert($param);
        $param = [
        'name' => '夏',
         ];
        DB::table('seasons')->insert($param);
         $param = [
        'name' => '秋',
         ];
        DB::table('seasons')->insert($param);
         $param = [
        'name' => '冬',
         ];
        DB::table('seasons')->insert($param);
    }
}
