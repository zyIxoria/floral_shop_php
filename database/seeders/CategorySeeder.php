<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Hoa Hồng',
                'description' => 'Những bông hoa hồng tươi sắc, biểu tượng của tình yêu và lãng mạn. Phù hợp cho các dịp đặc biệt.',
                'image' => 'categories/roses.jpg',
            ],
            [
                'name' => 'Hoa Huệ',
                'description' => 'Hoa huệ thanh lịch và sang trọng, mang vẻ đẹp quý phái. Thích hợp để tặng và trang trí.',
                'image' => 'categories/lilies.jpg',
            ],
            [
                'name' => 'Hoa Tulip',
                'description' => 'Hoa tulip rực rỡ sắc màu, tượng trưng cho sự hoàn hảo và ưu tú. Đa dạng màu sắc.',
                'image' => 'categories/tulips.jpg',
            ],
            [
                'name' => 'Hoa Đơn Hương',
                'description' => 'Hoa đơn hương thơm ngát, tươi sáng và vui vẻ. Thích hợp cho không gian sống.',
                'image' => 'categories/sunflowers.jpg',
            ],
            [
                'name' => 'Hoa Cẩm Tú',
                'description' => 'Hoa cẩm tú thanh tú và tinh tế, với sắc xanh biếc tương trưng cho sự bình yên.',
                'image' => 'categories/hydrangea.jpg',
            ],
            [
                'name' => 'Hoa Cúc',
                'description' => 'Hoa cúc vàng rực rỡ, mang ý nghĩa về lòng trung thành và vui vẻ. Bền lâu sau khi cắt.',
                'image' => 'categories/chrysanthemum.jpg',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'image' => $category['image'],
                ]
            );
        }
    }
}
