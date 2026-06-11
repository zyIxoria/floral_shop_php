<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Category::truncate();
        Schema::enableForeignKeyConstraints();

        $categories = [
            [
                'id' => 1,
                'name' => 'Hoa Hồng',
                'slug' => 'hoa-hong',
                'description' => 'Những bông hoa hồng tươi sắc, biểu tượng của tình yêu và lãng mạn. Phù hợp cho các dịp đặc biệt.',
                'image' => 'categories/roses.jpg',
            ],
            [
                'id' => 2,
                'name' => 'Hoa Huệ',
                'slug' => 'hoa-hue',
                'description' => 'Hoa huệ thanh lịch và sang trọng, mang vẻ đẹp quý phái. Thích hợp để tặng và trang trí.',
                'image' => 'https://i.pinimg.com/736x/25/ec/48/25ec487e5a740a85522e29e17ebe670a.jpg',
            ],
            [
                'id' => 3,
                'name' => 'Hoa Tulip',
                'slug' => 'hoa-tulip',
                'description' => 'Hoa tulip rực rỡ sắc màu, tượng trưng cho sự hoàn hảo và ưu tú. Đa dạng màu sắc.',
                'image' => 'categories/tulips.jpg',
            ],
            [
                'id' => 4,
                'name' => 'Hoa Đơn Hương',
                'slug' => 'hoa-don-huong',
                'description' => 'Hoa đơn hương thơm ngát, tươi sáng và vui vẻ. Thích hợp cho không gian sống.',
                'image' => 'https://i.pinimg.com/736x/b6/07/c6/b607c6e0d33cf37ad6be29eed6a53fab.jpg',
            ],
            [
                'id' => 5,
                'name' => 'Hoa Cẩm Tú',
                'slug' => 'hoa-cam-tu',
                'description' => 'Hoa cẩm tú thanh tú và tinh tế, với sắc xanh biếc tương trưng cho sự bình yên.',
                'image' => 'categories/hydrangea.jpg',
            ],
            [
                'id' => 6,
                'name' => 'Hoa Cúc',
                'slug' => 'hoa-cuc',
                'description' => 'Hoa cúc vàng rực rỡ, mang ý nghĩa về lòng trung thành và vui vẻ. Bền lâu sau khi cắt.',
                'image' => 'https://i.pinimg.com/736x/bf/b7/9f/bfb79f583ef411c3561f5c2fdcc98a27.jpg',
            ],
            [
                'id' => 7,
                'name' => 'Hoa Mix',
                'slug' => 'hoa-mix',
                'description' => 'Hoa mix nhiều loại',
                'image' => 'https://i.pinimg.com/736x/a8/c1/7c/a8c17cadcd5b258a69e861c32b9dc66c.jpg',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'id' => $category['id'],
                'name' => $category['name'],
                'slug' => $category['slug'],
                'description' => $category['description'],
                'image' => $category['image'],
            ]);
        }
    }
}
