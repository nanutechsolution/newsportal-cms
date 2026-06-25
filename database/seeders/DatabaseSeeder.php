<?php

namespace Database\Seeders;

use App\Enums\ArticleStatus;
use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use App\Models\PageWidget;
use App\Models\Site;
use App\Models\Tag;
use App\Models\User;
use App\Models\WidgetRegistry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Setup User Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@nusaaksara.com'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password'), // Password default: password
                'email_verified_at' => now(),
            ]
        );

        // 2. Setup Website (Multi-tenant Base)
        $site = Site::firstOrCreate(
            ['domain' => 'nusaaksara.com'],
            [
                'name' => 'NusaAksara Pusat',
                'is_active' => true,
            ]
        );

        // 3. Setup Kategori Berita (Ditambah Olahraga & Ekonomi)
        $kategoriNasional = Category::firstOrCreate(
            ['slug' => 'nasional', 'site_id' => $site->id],
            ['name' => 'Nasional', 'color_hex' => '#ef4444', 'order_column' => 1]
        );

        $kategoriTeknologi = Category::firstOrCreate(
            ['slug' => 'teknologi', 'site_id' => $site->id],
            ['name' => 'Teknologi', 'color_hex' => '#3b82f6', 'order_column' => 2]
        );
        
        $kategoriOlahraga = Category::firstOrCreate(
            ['slug' => 'olahraga', 'site_id' => $site->id],
            ['name' => 'Olahraga', 'color_hex' => '#10b981', 'order_column' => 3]
        );

        $kategoriEkonomi = Category::firstOrCreate(
            ['slug' => 'ekonomi', 'site_id' => $site->id],
            ['name' => 'Ekonomi', 'color_hex' => '#f59e0b', 'order_column' => 4]
        );

        // 4. Setup Tag Artikel (Ditambah Breaking News & Trending)
        $tagViral = Tag::firstOrCreate(['slug' => 'viral', 'site_id' => $site->id], ['name' => 'Viral']);
        $tagEksklusif = Tag::firstOrCreate(['slug' => 'eksklusif', 'site_id' => $site->id], ['name' => 'Eksklusif']);
        $tagBreaking = Tag::firstOrCreate(['slug' => 'breaking-news', 'site_id' => $site->id], ['name' => 'Breaking News']);
        $tagTrending = Tag::firstOrCreate(['slug' => 'trending', 'site_id' => $site->id], ['name' => 'Trending']);

        // 5. Setup 10 Artikel Berita (Campuran Breaking, Trending, dan Standar)
        $articlesData = [
            // --- BREAKING NEWS (is_featured = true) ---
            [
                'title' => 'Presiden Resmikan Infrastruktur Baru di Ibu Kota Nusantara',
                'category_id' => $kategoriNasional->id,
                'is_featured' => true,
                'tags' => [$tagBreaking->id, $tagEksklusif->id],
            ],
            [
                'title' => 'IHSG Tembus Rekor Tertinggi Sepanjang Sejarah Hari Ini',
                'category_id' => $kategoriEkonomi->id,
                'is_featured' => true,
                'tags' => [$tagBreaking->id],
            ],
            
            // --- TRENDING NEWS ---
            [
                'title' => 'Peluncuran AI Terbaru Buatan Anak Bangsa Kejutkan Dunia',
                'category_id' => $kategoriTeknologi->id,
                'is_featured' => false,
                'tags' => [$tagTrending->id, $tagViral->id],
            ],
            [
                'title' => 'Timnas Indonesia Berhasil Lolos ke Semifinal Piala Asia',
                'category_id' => $kategoriOlahraga->id,
                'is_featured' => false,
                'tags' => [$tagTrending->id, $tagEksklusif->id],
            ],
            [
                'title' => 'Fenomena Cuaca Ekstrem Landa Sebagian Besar Wilayah Jawa',
                'category_id' => $kategoriNasional->id,
                'is_featured' => false,
                'tags' => [$tagTrending->id],
            ],

            // --- REGULAR NEWS ---
            [
                'title' => 'Harga Emas Antam Naik Signifikan Mengikuti Pasar Global',
                'category_id' => $kategoriEkonomi->id,
                'is_featured' => false,
                'tags' => [],
            ],
            [
                'title' => 'Review Smartphone Layar Lipat Terbaru: Kelebihan dan Kekurangannya',
                'category_id' => $kategoriTeknologi->id,
                'is_featured' => false,
                'tags' => [$tagEksklusif->id],
            ],
            [
                'title' => 'Persiapan Atlet Menjelang Olimpiade Semakin Matang',
                'category_id' => $kategoriOlahraga->id,
                'is_featured' => false,
                'tags' => [],
            ],
            [
                'title' => 'Pemerintah Siapkan Skema Baru Bantuan Sosial Tahun Depan',
                'category_id' => $kategoriNasional->id,
                'is_featured' => false,
                'tags' => [],
            ],
            [
                'title' => 'Tips Menjaga Keamanan Data Pribadi di Era Digital',
                'category_id' => $kategoriTeknologi->id,
                'is_featured' => false,
                'tags' => [$tagViral->id],
            ],
        ];

        // Looping untuk membuat artikel ke dalam database
        foreach ($articlesData as $index => $data) {
            $slug = Str::slug($data['title']);
            
            $article = Article::firstOrCreate(
                ['slug' => $slug, 'site_id' => $site->id],
                [
                    'category_id' => $data['category_id'],
                    'author_id' => $admin->id,
                    'title' => $data['title'],
                    'excerpt' => 'Ringkasan singkat dari berita: ' . $data['title'] . '. Informasi aktual dan terpercaya persembahan NusaAksara CMS.',
                    'content' => '<p>Ini adalah konten detail dari berita yang berjudul <strong>' . $data['title'] . '</strong>. Di dalam implementasi aslinya, paragraf ini akan berisi reportase lengkap yang ditulis langsung oleh tim redaksi dari lapangan.</p><p>Berita ini menyoroti pentingnya informasi yang cepat, akurat, dan dapat diandalkan oleh masyarakat luas.</p>',
                    'status' => ArticleStatus::Published,
                    'is_featured' => $data['is_featured'],
                    // Membuat tanggal publish sedikit berbeda-beda agar tidak menumpuk di 1 detik yang sama
                    'published_at' => now()->subHours($index), 
                ]
            );

            // Sync tags ke artikel
            if (!empty($data['tags'])) {
                $article->tags()->syncWithoutDetaching($data['tags']);
            }
        }

        // 6. Setup Registri Widget (Untuk Builder)
        $trendingWidget = WidgetRegistry::firstOrCreate(
            ['class_name' => 'App\Widgets\TrendingNewsWidget'],
            [
                'name' => 'Trending News Widget',
                'default_config_schema' => ['limit' => 5, 'title' => 'Berita Terpopuler'],
                'is_active' => true,
            ]
        );

        $bannerWidget = WidgetRegistry::firstOrCreate(
            ['class_name' => 'App\Widgets\BannerAdsWidget'],
            [
                'name' => 'Banner Iklan Homepage',
                'default_config_schema' => ['image_url' => '', 'target_link' => '#'],
                'is_active' => true,
            ]
        );
        
        $breakingWidget = WidgetRegistry::firstOrCreate(
            ['class_name' => 'App\Widgets\BreakingNewsWidget'],
            [
                'name' => 'Breaking News Ticker',
                'default_config_schema' => ['limit' => 3, 'title' => 'BREAKING NEWS'],
                'is_active' => true,
            ]
        );

        // 7. Setup Halaman Beranda (Homepage)
        $homepage = Page::firstOrCreate(
            ['slug' => 'home', 'site_id' => $site->id],
            [
                'title' => 'Beranda Utama',
                'layout' => 'homepage-builder',
                'is_active' => true,
            ]
        );

        // 8. Pasang Widget ke dalam Homepage (Instansiasi)
        // Widget Breaking News ditaruh paling atas (order 1)
        PageWidget::firstOrCreate(
            [
                'site_id' => $site->id,
                'page_id' => $homepage->id,
                'widget_registry_id' => $breakingWidget->id,
            ],
            [
                'configuration' => ['limit' => 3, 'title' => 'BREAKING NEWS HARI INI'],
                'order_column' => 1,
                'is_active' => true,
            ]
        );

        PageWidget::firstOrCreate(
            [
                'site_id' => $site->id,
                'page_id' => $homepage->id,
                'widget_registry_id' => $trendingWidget->id,
            ],
            [
                'configuration' => ['limit' => 6, 'title' => 'Berita Trending Hari Ini'],
                'order_column' => 2,
                'is_active' => true,
            ]
        );

        PageWidget::firstOrCreate(
            [
                'site_id' => $site->id,
                'page_id' => $homepage->id,
                'widget_registry_id' => $bannerWidget->id,
            ],
            [
                'configuration' => ['image_url' => 'https://via.placeholder.com/1200x200?text=Iklan+Banner+NusaAksara', 'target_link' => '#'],
                'order_column' => 3,
                'is_active' => true,
            ]
        );

        $this->command->info('Seeding berhasil! Data 10 Artikel (termasuk Breaking & Trending) beserta kelengkapan CMS telah dimasukkan ke database.');
    }
}