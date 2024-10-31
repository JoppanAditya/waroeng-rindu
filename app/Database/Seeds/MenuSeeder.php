<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['id' => 1, 'name' => 'Makanan'],
            ['id' => 2, 'name' => 'Minuman'],
            ['id' => 3, 'name' => 'Camilan'],
            ['id' => 4, 'name' => 'Kopi'],
            ['id' => 5, 'name' => 'Dessert'],
        ];

        $menus = [
            [
                'name' => 'Nasi Goreng Kampung',
                'category_id' => 1,
                'description' => 'Nasi goreng kampung khas dengan bumbu rempah yang kuat, disajikan dengan telur mata sapi, potongan ayam suwir, serta irisan cabai merah segar. Cocok dinikmati hangat-hangat bersama kerupuk dan acar yang menambah kesegaran.',
                'price' => 25000
            ],
            [
                'name' => 'Soto Ayam',
                'category_id' => 1,
                'description' => 'Soto ayam dengan kuah bening yang gurih, kaya akan rempah, dilengkapi dengan irisan ayam suwir, bihun, dan telur rebus. Disajikan bersama sambal, perasan jeruk nipis, dan kerupuk yang renyah untuk sensasi rasa yang lebih segar.',
                'price' => 20000
            ],
            [
                'name' => 'Mie Goreng Jawa',
                'category_id' => 1,
                'description' => 'Mie goreng khas Jawa yang dimasak dengan bumbu kecap dan campuran sayuran segar seperti sawi dan kol. Tersedia potongan ayam dan telur yang berpadu dengan rasa manis dan gurih, menciptakan kelezatan yang autentik.',
                'price' => 18000
            ],
            [
                'name' => 'Nasi Uduk',
                'category_id' => 1,
                'description' => 'Nasi uduk yang harum dengan santan dan daun pandan, disajikan dengan lauk pauk seperti ayam goreng, tempe kering, orek, serta sambal kacang yang pedas manis. Sebuah sajian sarapan yang menggugah selera.',
                'price' => 22000
            ],
            [
                'name' => 'Ayam Bakar Kecap',
                'category_id' => 1,
                'description' => 'Ayam bakar yang dimarinasi dengan bumbu kecap manis dan rempah-rempah, dipanggang hingga meresap dan memiliki kulit yang sedikit karamelisasi. Disajikan dengan nasi hangat dan sambal terasi yang pedas.',
                'price' => 30000
            ],
            [
                'name' => 'Es Teh Manis',
                'category_id' => 2,
                'description' => 'Minuman segar dari teh pilihan yang diseduh dan dicampur dengan gula alami, kemudian ditambahkan es batu. Sangat cocok untuk menemani sajian makan Anda di hari yang panas.',
                'price' => 8000
            ],
            [
                'name' => 'Es Jeruk',
                'category_id' => 2,
                'description' => 'Perasan jeruk asli yang segar, dicampur dengan sedikit gula dan es batu, memberikan rasa manis asam yang menyegarkan. Pilihan tepat untuk menyegarkan tenggorokan Anda.',
                'price' => 10000
            ],
            [
                'name' => 'Kopi Tubruk',
                'category_id' => 4,
                'description' => 'Kopi hitam yang diseduh dengan cara tradisional, menghasilkan cita rasa yang pekat dan kuat. Disajikan dengan ampas kopi yang kaya, memberikan pengalaman minum kopi yang otentik.',
                'price' => 15000
            ],
            [
                'name' => 'Teh Poci',
                'category_id' => 2,
                'description' => 'Teh poci khas yang diseduh dalam poci tanah liat, menghasilkan aroma khas yang menenangkan. Cocok dinikmati di sore hari untuk menghangatkan tubuh dan merilekskan pikiran.',
                'price' => 12000
            ],
            [
                'name' => 'Wedang Jahe',
                'category_id' => 2,
                'description' => 'Minuman hangat yang terbuat dari rebusan jahe, gula merah, dan sedikit pandan, menciptakan rasa pedas manis yang menghangatkan tubuh. Pilihan sempurna untuk malam yang dingin.',
                'price' => 15000
            ],
            [
                'name' => 'Pisang Goreng',
                'category_id' => 3,
                'description' => 'Pisang goreng yang renyah di luar namun lembut di dalam, disajikan dengan taburan gula halus atau parutan keju. Menjadi teman sempurna untuk menikmati waktu santai Anda.',
                'price' => 10000
            ],
            [
                'name' => 'Tempe Mendoan',
                'category_id' => 3,
                'description' => 'Tempe yang digoreng setengah matang dengan balutan tepung yang gurih. Tempe mendoan ini cocok dinikmati dengan sambal kecap yang pedas manis.',
                'price' => 12000
            ],
            [
                'name' => 'Singkong Keju',
                'category_id' => 3,
                'description' => 'Singkong yang dikukus hingga empuk, kemudian digoreng dan disajikan dengan taburan keju parut. Rasa gurih dan manis berpadu dengan tekstur singkong yang lembut.',
                'price' => 14000
            ],
            [
                'name' => 'Martabak Manis',
                'category_id' => 5,
                'description' => 'Martabak manis dengan tekstur lembut, diisi dengan berbagai topping seperti cokelat, keju, dan kacang. Setiap gigitan menawarkan rasa manis yang memanjakan lidah.',
                'price' => 35000
            ],
            [
                'name' => 'Es Cendol',
                'category_id' => 2,
                'description' => 'Es cendol yang terbuat dari tepung hunkwe, disajikan dengan gula merah cair dan santan, menciptakan rasa manis gurih yang pas untuk menghilangkan dahaga.',
                'price' => 12000
            ],
            [
                'name' => 'Kopi Susu',
                'category_id' => 4,
                'description' => 'Perpaduan sempurna antara kopi hitam dan susu kental manis, menciptakan minuman dengan rasa yang creamy dan aroma kopi yang khas. Cocok untuk dinikmati di pagi atau sore hari.',
                'price' => 18000
            ],
            [
                'name' => 'Es Campur',
                'category_id' => 5,
                'description' => 'Es campur dengan berbagai bahan seperti agar-agar, alpukat, cincau, dan buah-buahan segar. Disiram dengan sirup dan susu, menciptakan minuman penutup yang menyegarkan.',
                'price' => 20000
            ],
            [
                'name' => 'Bakso Sapi',
                'category_id' => 1,
                'description' => 'Bakso sapi dengan kuah kaldu sapi yang gurih dan nikmat, disajikan dengan mie kuning, bihun, serta taburan bawang goreng dan seledri.',
                'price' => 25000
            ],
            [
                'name' => 'Roti Bakar Cokelat',
                'category_id' => 5,
                'description' => 'Roti bakar dengan isian cokelat yang meleleh, dipanggang hingga renyah di luar namun lembut di dalam. Pilihan sempurna untuk pencinta cokelat.',
                'price' => 15000
            ],
            [
                'name' => 'Jus Alpukat',
                'category_id' => 2,
                'description' => 'Jus alpukat yang lembut dan creamy, ditambah dengan susu kental manis dan sedikit es serut. Menawarkan kesegaran dan rasa yang kaya di setiap tegukan.',
                'price' => 17000
            ],
        ];

        foreach ($menus as &$menu) {
            $menu['slug'] = url_title($menu['name'], '-', true);
            $menu['image'] = $menu['slug'] . '.jpg';
        }

        $this->db->table('menus')->insertBatch($menus);
        $this->db->table('menu_categories')->insertBatch($categories);
    }
}
