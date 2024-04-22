<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'Super Admin', 'name_bn' => 'পরিচালক'],
            ['name' => 'Register', 'name_bn' => 'রেজিস্ট্রার অফ কপিরাইট'],
            ['name' => 'Assistant Register', 'name_bn' => 'কপিরাইট সহকারী রেজিস্ট্রার'],
            ['name' => 'Deputy Register', 'name_bn' => 'কপিরাইট ডেপুটি রেজিস্ট্রার'],
            ['name' => 'Examiner', 'name_bn' => 'কপিরাইট পরীক্ষক'],
            ['name' => 'Assistant Examiner', 'name_bn' => 'কপিরাইট সহকারী পরীক্ষক'],
            ['name' => 'Indexer', 'name_bn' => 'কপিরাইট ইনডেক্সার'],
            ['name' => 'Inspector', 'name_bn' => 'কপিরাইট পরিদর্শক'],
            ['name' => 'Librarian', 'name_bn' => 'কপিরাইট গ্রন্থাগারিক'],
            ['name' => 'Applicant', 'name_bn' => 'আবেদনকারী'],
            ['name' => 'Programmer', 'name_bn' => 'কপিরাইট সহকারী প্রোগ্রামার'],
            ['name' => 'Calligrapher', 'name_bn' => 'কপিরাইট ক্যালিগ্রাফার']
        ];

        DB::table('roles')->insert($roles);
    }
}
