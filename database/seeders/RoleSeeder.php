<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => RoleType::Customer,
                'guard_name' => 'web',
                'display_name' => 'کاربر',
            ],
            [
                'name' => RoleType::Admin,
                'guard_name' => 'web',
                'display_name' => 'مدیر',
            ],
            [
                'name' => RoleType::Editor,
                'guard_name' => 'web',
                'display_name' => 'ویرایشگر',
            ],
            [
                'name' => RoleType::Seller,
                'guard_name' => 'web',
                'display_name' => 'فروشنده',
            ],
            [
                'name' => RoleType::ProductEditor,
                'guard_name' => 'web',
                'display_name' => 'ویرایشگر محصول',
            ]
        ]);
    }
}
