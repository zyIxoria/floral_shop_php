<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
                'phone' => '0912345678',
                'address' => '123 Trần Hưng Đạo, Quận 1, TP HCM',
                'role' => 'admin',
                'status' => 'active',
            ]
        );

        // Customer users with Vietnamese names
        $customers = [
            [
                'name' => 'Nguyễn Thị Hoa',
                'email' => 'hoa.nguyen@gmail.com',
                'phone' => '0901234567',
                'address' => '456 Nguyễn Huệ, Quận 1, TP HCM',
            ],
            [
                'name' => 'Trần Văn Minh',
                'email' => 'minh.tran@gmail.com',
                'phone' => '0902345678',
                'address' => '789 Pasteur, Quận 3, TP HCM',
            ],
            [
                'name' => 'Phạm Thị Linh',
                'email' => 'linh.pham@gmail.com',
                'phone' => '0903456789',
                'address' => '321 Đinh Tiên Hoàng, Quận 1, TP HCM',
            ],
            [
                'name' => 'Vũ Văn Hùng',
                'email' => 'hung.vu@gmail.com',
                'phone' => '0904567890',
                'address' => '654 Võ Văn Tần, Quận 3, TP HCM',
            ],
            [
                'name' => 'Đặng Thị Yến',
                'email' => 'yen.dang@gmail.com',
                'phone' => '0905678901',
                'address' => '987 Nguyễn Thái Học, Quận 1, TP HCM',
            ],
        ];

        foreach ($customers as $customer) {
            User::firstOrCreate(
                ['email' => $customer['email']],
                [
                    'name' => $customer['name'],
                    'password' => Hash::make('12345678'),
                    'phone' => $customer['phone'],
                    'address' => $customer['address'],
                    'role' => 'customer',
                    'status' => 'active',
                ]
            );
        }
    }
}
