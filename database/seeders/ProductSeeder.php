<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Hoa Hồng - 4 products
            [
                'category_id' => 1,
                'name' => 'Bó Hoa Hồng Đỏ Premium',
                'description' => 'Bó 12 bông hoa hồng đỏ tuyệt đẹp, tươi tắn, thích hợp cho các dịp lãng mạn như Valentine, kỷ niệm hoặc xin lỗi.',
                'price' => 250000,
                'sale_price' => 200000,
                'stock' => 50,
                'image' => 'products/red-roses.jpg',
                'status' => 'active',
            ],
            [
                'category_id' => 1,
                'name' => 'Bó Hoa Hồng Hồng Pastel',
                'description' => 'Bó 15 bông hoa hồng màu hồng nhạt rất nữ tính, phù hợp cho những người yêu thích vẻ đẹp nhẹ nhàng.',
                'price' => 280000,
                'sale_price' => null,
                'stock' => 35,
                'image' => 'products/pink-roses.jpg',
                'status' => 'active',
            ],
            [
                'category_id' => 1,
                'name' => 'Bó Hoa Hồng Trắng Thanh Cao',
                'description' => 'Bó 20 bông hoa hồng trắng tinh khiết, biểu tượng của sự thanh cao và tình yêu thuần khiết.',
                'price' => 320000,
                'sale_price' => 250000,
                'stock' => 40,
                'image' => 'products/white-roses.jpg',
                'status' => 'active',
            ],
            [
                'category_id' => 1,
                'name' => 'Bó Hoa Hồng Cầu Vồng',
                'description' => 'Bó hoa hồng sắc cầu vồng độc đáo, gồm các bông hồng màu khác nhau. Một lựa chọn độc đáo và ấn tượng.',
                'price' => 450000,
                'sale_price' => null,
                'stock' => 20,
                'image' => 'products/rainbow-roses.jpg',
                'status' => 'active',
            ],

            // Hoa Huệ - 3 products
            [
                'category_id' => 2,
                'name' => 'Bó Hoa Huệ Trắng Sang Trọng',
                'description' => 'Bó 10 bông hoa huệ trắng cao quý, thích hợp cho các sự kiện chính thức và lễ tưởng niệm.',
                'price' => 350000,
                'sale_price' => 280000,
                'stock' => 25,
                'image' => 'products/white-lilies.jpg',
                'status' => 'active',
            ],
            [
                'category_id' => 2,
                'name' => 'Bó Hoa Huệ Hồng Rực Rỡ',
                'description' => 'Bó 12 bông hoa huệ hồng sắc vivo, tỏa hương thơm nhẹ và quyến rũ. Bền lâu, thích hợp để trang trí.',
                'price' => 380000,
                'sale_price' => null,
                'stock' => 30,
                'image' => 'products/pink-lilies.jpg',
                'status' => 'active',
            ],
            [
                'category_id' => 2,
                'name' => 'Bó Hoa Huệ Cam Nóng Bỏng',
                'description' => 'Bó 8 bông hoa huệ cam rực rỡ, mang sắc ấm áp. Lý tưởng cho những không gian cần sự sinh động.',
                'price' => 400000,
                'sale_price' => 320000,
                'stock' => 20,
                'image' => 'products/orange-lilies.jpg',
                'status' => 'active',
            ],

            // Hoa Tulip - 3 products
            [
                'category_id' => 3,
                'name' => 'Bó Hoa Tulip Đỏ Tươi',
                'description' => 'Bó 15 bông hoa tulip đỏ tươi tắn, biểu tượng của tình yêu chân thành. Phù hợp cho Valentine.',
                'price' => 200000,
                'sale_price' => 160000,
                'stock' => 45,
                'image' => 'products/red-tulips.jpg',
                'status' => 'active',
            ],
            [
                'category_id' => 3,
                'name' => 'Bó Hoa Tulip Vàng Rực',
                'description' => 'Bó 20 bông hoa tulip vàng tươi sáng, mang lại niềm vui và sự lạc quan cho ngày của bạn.',
                'price' => 220000,
                'sale_price' => null,
                'stock' => 40,
                'image' => 'products/yellow-tulips.jpg',
                'status' => 'active',
            ],
            [
                'category_id' => 3,
                'name' => 'Bó Hoa Tulip Tím Thanh Cao',
                'description' => 'Bó 18 bông hoa tulip tím sang trọng, lý tưởng để tặng những người đặc biệt trong cuộc đời bạn.',
                'price' => 240000,
                'sale_price' => 190000,
                'stock' => 35,
                'image' => 'products/purple-tulips.jpg',
                'status' => 'active',
            ],

            // Hoa Đơn Hương - 3 products
            [
                'category_id' => 4,
                'name' => 'Bó Hoa Đơn Hương Vàng Tươi',
                'description' => 'Bó 5 bông hoa đơn hương vàng rực rỡ, tỏa mùi thơm tự nhiên. Thích hợp để mang vui vẻ vào nhà.',
                'price' => 150000,
                'sale_price' => 120000,
                'stock' => 60,
                'image' => 'products/yellow-sunflowers.jpg',
                'status' => 'active',
            ],
            [
                'category_id' => 4,
                'name' => 'Bó Hoa Đơn Hương Khổng Lồ',
                'description' => 'Bó 3 bông hoa đơn hương siêu to khổng lồ, với đường kính tới 20cm. Ấn tượng mạnh và bền lâu.',
                'price' => 280000,
                'sale_price' => null,
                'stock' => 15,
                'image' => 'products/giant-sunflowers.jpg',
                'status' => 'active',
            ],
            [
                'category_id' => 4,
                'name' => 'Bó Hoa Đơn Hương Đỏ Mận',
                'description' => 'Bó 6 bông hoa đơn hương đỏ mận độc đáo, rất khác lạ so với các hoa đơn hương truyền thống.',
                'price' => 200000,
                'sale_price' => 160000,
                'stock' => 25,
                'image' => 'products/red-sunflowers.jpg',
                'status' => 'active',
            ],

            // Hoa Cẩm Tú - 3 products
            [
                'category_id' => 5,
                'name' => 'Bó Hoa Cẩm Tú Xanh Tuyền',
                'description' => 'Bó 10 bông hoa cẩm tú xanh biếc mịn màng, biểu tượng của sự bình yên và thanh bình. Bền lâu sau khi cắt.',
                'price' => 220000,
                'sale_price' => 180000,
                'stock' => 40,
                'image' => 'products/blue-hydrangea.jpg',
                'status' => 'active',
            ],
            [
                'category_id' => 5,
                'name' => 'Bó Hoa Cẩm Tú Hồng Nữ Tính',
                'description' => 'Bó 8 bông hoa cẩm tú hồng nhạt rất nữ tính, tỏa hương nhẹ nhàng. Thích hợp cho phòng ngủ và phòng khách.',
                'price' => 240000,
                'sale_price' => null,
                'stock' => 35,
                'image' => 'products/pink-hydrangea.jpg',
                'status' => 'active',
            ],
            [
                'category_id' => 5,
                'name' => 'Bó Hoa Cẩm Tú Tím Hoàng Gia',
                'description' => 'Bó 7 bông hoa cẩm tú tím đậm hoàng gia, rất sang trọng và ấn tượng cho bất kì không gian nào.',
                'price' => 260000,
                'sale_price' => 210000,
                'stock' => 28,
                'image' => 'products/purple-hydrangea.jpg',
                'status' => 'active',
            ],

            // Hoa Cúc - 3 products
            [
                'category_id' => 6,
                'name' => 'Bó Hoa Cúc Vàng Tươi',
                'description' => 'Bó 20 bông hoa cúc vàng rực rỡ, mang ý nghĩa về sự vui vẻ và lòng trung thành. Bền lâu rất tốt.',
                'price' => 120000,
                'sale_price' => 90000,
                'stock' => 70,
                'image' => 'products/yellow-chrysanthemum.jpg',
                'status' => 'active',
            ],
            [
                'category_id' => 6,
                'name' => 'Bó Hoa Cúc Trắng Tinh Khiết',
                'description' => 'Bó 18 bông hoa cúc trắng tinh khiết, biểu tượng của sự tươi mới và thanh cao. Lý tưởng cho mọi dịp.',
                'price' => 130000,
                'sale_price' => null,
                'stock' => 65,
                'image' => 'products/white-chrysanthemum.jpg',
                'status' => 'active',
            ],
            [
                'category_id' => 6,
                'name' => 'Bó Hoa Cúc Hồng Yên Ả',
                'description' => 'Bó 22 bông hoa cúc hồng nhạt mềm mại, tỏa hương tự nhiên dễ chịu. Trang trí tốt cho phòng khách.',
                'price' => 140000,
                'sale_price' => 110000,
                'stock' => 55,
                'image' => 'products/pink-chrysanthemum.jpg',
                'status' => 'active',
            ],

            // Sản phẩm đặc biệt - 3 products
            [
                'category_id' => 1,
                'name' => 'Bó Hoa Hồng Mix Sang Trọng',
                'description' => 'Bó hoa hồng mix các loại hồng, trắng, và hồng nhạt được bố trí tôn lên nhau. Lựa chọn hoàn hảo cho những dịp đặc biệt.',
                'price' => 500000,
                'sale_price' => 400000,
                'stock' => 10,
                'image' => 'products/luxury-roses-mix.jpg',
                'status' => 'active',
            ],
            [
                'category_id' => 2,
                'name' => 'Bó Hoa Huệ & Tulip Kết Hợp',
                'description' => 'Sự kết hợp hoàn hảo giữa hoa huệ và hoa tulip, tạo nên bó hoa độc đáo và đặc biệt.',
                'price' => 380000,
                'sale_price' => 320000,
                'stock' => 18,
                'image' => 'products/lilies-tulips-combo.jpg',
                'status' => 'active',
            ],
            [
                'category_id' => 4,
                'name' => 'Bó Hoa Mix 5 Loại Đặc Biệt',
                'description' => 'Bó hoa mix gồm 5 loại hoa khác nhau: hồng, huệ, tulip, cẩm tú, và cúc. Được xếp thành các arrangement xinh đẹp.',
                'price' => 420000,
                'sale_price' => 340000,
                'stock' => 12,
                'image' => 'products/mixed-bouquet.jpg',
                'status' => 'active',
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['slug' => Str::slug($product['name'])],
                [
                    'category_id' => $product['category_id'],
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'sale_price' => $product['sale_price'],
                    'stock' => $product['stock'],
                    'image' => $product['image'],
                    'status' => $product['status'],
                    'rating' => 0,
                    'review_count' => 0,
                ]
            );
        }
    }
}
