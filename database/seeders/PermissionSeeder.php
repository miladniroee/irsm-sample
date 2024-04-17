<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionsByRole = [];
        $permissionsByRole['product_editor'] = [
            'create product' => 'ایجاد محصول',
            'edit product' => 'ویرایش محصول',
            'delete product' => 'حذف محصول',
            'view product' => 'مشاهده محصول',
            'view products' => 'مشاهده محصولات',
            'create variation' => 'ایجاد متغیر',
            'edit variation' => 'ویرایش متغیر',
            'delete variation' => 'حذف متغیر',
        ];

        $permissionsByRole['seller'] = [
            ...$permissionsByRole['product_editor'],
            'view order' => 'مشاهده سفارش',
            'view orders' => 'مشاهده سفارشات',
            'update order' => 'ویرایش وضعیت سفارش',
        ];

        $permissionsByRole['editor'] = [
            ...$permissionsByRole['seller'],
            'create post' => 'ایجاد پست',
            'edit post' => 'ویرایش پست',
            'delete post' => 'حذف پست',
            'view post' => 'مشاهده پست',
            'view posts' => 'مشاهده پست‌ها',
        ];

        $permissionsByRole['admin'] = [
            ...$permissionsByRole['editor'],
            'create user' => 'ایجاد کاربر',
            'edit user' => 'ویرایش کاربر',
            'delete user' => 'حذف کاربر',
            'view user' => 'مشاهده کاربر',
            'view users' => 'مشاهده کاربران',
            'create order' => 'ایجاد سفارش',
            'edit order' => 'ویرایش سفارش',
            'delete order' => 'حذف سفارش',
        ];


        Permission::insert(collect($permissionsByRole['admin'])->map(function ($name, $display_name) {
            return [
                'name' => $display_name,
                'display_name' => $name,
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray());

        foreach ($permissionsByRole as $role => $permissions) {
            $role = Role::whereName($role)->first();

            foreach ($permissions as $name => $display_name) {
                $permission = Permission::whereName($name)->first();
                DB::table('role_has_permissions')->insert([
                    'permission_id' => $permission->id,
                    'role_id' => $role->id,
                ]);
            }

        }
    }
}
