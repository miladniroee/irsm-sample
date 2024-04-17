<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!env('SEED_REAL_DATA')) {
            \App\Models\User::factory()->count(20)->create();
        } else {


            $data = \Nette\Utils\Json::decode(file_get_contents(database_path('json/users.json')));

            foreach ($data as $row) {
                $row = (array)$row;
                $user = \App\Models\User::create([
                    'first_name' => empty($row['first_name']) ? NULL : $row['first_name'],
                    'last_name' => empty($row['last_name']) ? NULL : $row['last_name'],
                    'email' => empty($row['email']) ? NULL : $row['email'],
                    'email_verified_at' => empty($row['email']) ? NULL : now(),
                    'phone' => $row['mobile'] ?? '00000000000',
                    'phone_verified_at' => empty($row['mobile']) ? NULL : now(),
                    'money_spent' => $row['money_spent'],
                    'orders_count' => $row['order_count'],
                    'created_at' => $row['created_at']
                ]);

                $roles = [
                    \App\Enums\RoleType::Customer
                ];

                if ($row['is_admin']) {
                    $roles[] = \App\Enums\RoleType::Admin;
                }

                if ($row['is_seller']) {
                    $roles[] = \App\Enums\RoleType::Seller;
                }

                foreach ($roles as $role):
                    $roleModel = \Spatie\Permission\Models\Role::where('name', $role)->first();
                    $user->assignRole($roleModel);
                endforeach;


                foreach ($row['addresses'] as $address):
                    $address = (array)$address;
                    $user->addresses()->create([
                        'name' => ($address['first_name'] ?? '') . ' ' . ($address['last_name'] ?? ''),
                        'address_1' => $address['address_1'] ?? '',
                        'city' => $address['city'] ?? '',
                        'state' => $address['state'] ?? '',
                        'zip_code' => $address['postcode'] ?? 0,
                    ]);
                endforeach;

                if ($row['store']):
                    $store = $row['store'];
                    $user->store()->create([
                        'name' => $store->store_name ?? '',
                        'phone' => $store->phone ?? null,
                        'address' => $store->street_1 ?? null,
                        'profit_percentage' => $store->dokan_admin_percentage ?? 0,
                    ]);
                endif;
            }
        }
    }
}
