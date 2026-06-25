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
        // Pastikan site_id ini sudah ada di tabel 'sites'
        $siteId = 1; 

        // Daftar Kategori Standar Portal Berita Profesional
        $realCategories = [
            ['name' => 'Nasional', 'desc' => 'Berita terkini seputar peristiwa dan kabar terbaru di Indonesia.'],
            ['name' => 'Internasional', 'desc' => 'Kabar dan isu global terbaru dari berbagai belahan dunia.'],
            ['name' => 'Politik', 'desc' => 'Dinamika politik, pemerintahan, pemilu, dan kebijakan publik.'],
            ['name' => 'Ekonomi & Bisnis', 'desc' => 'Informasi seputar pergerakan pasar, IHSG, keuangan, dan bisnis.'],
            ['name' => 'Olahraga', 'desc' => 'Berita olahraga terlengkap, dari sepak bola hingga bulu tangkis.'],
            ['name' => 'Teknologi', 'desc' => 'Perkembangan gadget, internet, sains, dan inovasi teknologi.'],
            ['name' => 'Hiburan', 'desc' => 'Kabar selebriti, film, musik, seni, dan dunia hiburan.'],
            ['name' => 'Gaya Hidup', 'desc' => 'Tren fashion, kuliner, travel, dan gaya hidup modern.'],
            ['name' => 'Kesehatan', 'desc' => 'Tips kesehatan, info medis, gizi, dan kebugaran keluarga.'],
            ['name' => 'Otomotif', 'desc' => 'Berita seputar mobil, motor, modifikasi, dan industri otomotif.'],
            ['name' => 'Pendidikan', 'desc' => 'Informasi seputar sekolah, kampus, beasiswa, dan pendidikan.'],
            ['name' => 'Opini', 'desc' => 'Kolom opini, tajuk rencana, dan pandangan dari para pakar.'],
        ];

        $dataToInsert = [];
        $order = 1;

        foreach ($realCategories as $category) {
            // Generate warna hex acak untuk label kategori
            $randomColor = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);

            $dataToInsert[] = [
                'site_id'      => $siteId, //
                'parent_id'    => null,    //
                'name'         => $category['name'], //
                'slug'         => Str::slug($category['name']), //
                'description'  => $category['desc'], //
                'color_hex'    => $randomColor,      //
                'icon_class'   => 'heroicon-o-folder', //
                'order_column' => $order++,          //
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
        }

        // Insert ke database
        Category::insert($dataToInsert);

        $this->command->info(count($realCategories) . ' Kategori Berita Utama berhasil di-generate!');
    }
}