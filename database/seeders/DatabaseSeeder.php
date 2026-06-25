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
    public function run(): void
    {
        // 1. Setup User Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@nusaaksara.com'],
            ['name' => 'Super Administrator', 'password' => Hash::make('password'), 'email_verified_at' => now()]
        );

        // 2. Setup Website
        $site = Site::firstOrCreate(['domain' => 'nusaaksara.com'], ['name' => 'NusaAksara Pusat', 'is_active' => true]);

        // 3. Setup Kategori
        $kategoriNasional = Category::firstOrCreate(['slug' => 'nasional', 'site_id' => $site->id], ['name' => 'Nasional', 'color_hex' => '#ef4444', 'order_column' => 1]);
        $kategoriTeknologi = Category::firstOrCreate(['slug' => 'teknologi', 'site_id' => $site->id], ['name' => 'Teknologi', 'color_hex' => '#3b82f6', 'order_column' => 2]);
        $kategoriOlahraga = Category::firstOrCreate(['slug' => 'olahraga', 'site_id' => $site->id], ['name' => 'Olahraga', 'color_hex' => '#10b981', 'order_column' => 3]);
        $kategoriEkonomi = Category::firstOrCreate(['slug' => 'ekonomi', 'site_id' => $site->id], ['name' => 'Ekonomi', 'color_hex' => '#f59e0b', 'order_column' => 4]);
        $kategoriOpini = Category::firstOrCreate(['slug' => 'opini', 'site_id' => $site->id], ['name' => 'Opini', 'color_hex' => '#6b7280', 'order_column' => 5]);

        // 4. Setup Tags
        $tagBreaking = Tag::firstOrCreate(['slug' => 'breaking-news', 'site_id' => $site->id], ['name' => 'Breaking News']);
        $tagTrending = Tag::firstOrCreate(['slug' => 'trending', 'site_id' => $site->id], ['name' => 'Trending']);

        // 5. Setup 20 Artikel (Termasuk Opini)
        for ($i = 1; $i <= 20; $i++) {
            $cat = ($i % 5 == 0) ? $kategoriOpini : $kategoriNasional;
            $title = ($i % 5 == 0) ? "Opini: Tantangan Digitalisasi Masa Depan $i" : "Berita Utama Hari Ini Nomor $i";
            
            $article = Article::firstOrCreate(
                ['slug' => Str::slug($title), 'site_id' => $site->id],
                [
                    'category_id' => $cat->id,
                    'author_id' => $admin->id,
                    'title' => $title,
                    'excerpt' => 'Liputan eksklusif mengenai ' . $title,
                    'content' => '<p>Konten berita mendalam terkait ' . $title . '</p>',
                    'status' => ArticleStatus::Published,
                    'is_featured' => ($i <= 3), // 3 berita pertama jadi featured
                    'published_at' => now()->subHours($i),
                ]
            );
        }

        // 6. Setup Widget Registry
        $widgets = [
            ['class' => 'App\Widgets\BreakingNewsWidget', 'name' => 'Breaking News Ticker'],
            ['class' => 'App\Widgets\TrendingNewsWidget', 'name' => 'Trending News'],
            ['class' => 'App\Widgets\LatestNewsWidget', 'name' => 'Latest News'],
            ['class' => 'App\Widgets\BannerAdsWidget', 'name' => 'Banner Iklan'],
            ['class' => 'App\Widgets\EditorsPickWidget', 'name' => 'Editor\'s Pick'],
            ['class' => 'App\Widgets\OpinionWidget', 'name' => 'Opini Section'],
            ['class' => 'App\Widgets\NewsletterWidget', 'name' => 'Newsletter'],
        ];

        foreach ($widgets as $w) {
            WidgetRegistry::firstOrCreate(['class_name' => $w['class']], ['name' => $w['name'], 'is_active' => true]);
        }

        // 7. Setup Halaman Beranda & Pasang Widget
        $homepage = Page::firstOrCreate(['slug' => 'home', 'site_id' => $site->id], ['title' => 'Beranda Utama', 'layout' => 'homepage-builder']);
        
        $order = 1;
        foreach ($widgets as $w) {
            $registry = WidgetRegistry::where('class_name', $w['class'])->first();
            
            // PERBAIKAN: Menambahkan 'site_id' ke dalam parameter firstOrCreate
            PageWidget::firstOrCreate(
                [
                    'page_id' => $homepage->id, 
                    'widget_registry_id' => $registry->id
                ],
                [
                    'site_id' => $site->id, // Tambahkan ini
                    'configuration' => ['limit' => 5], 
                    'order_column' => $order++, 
                    'is_active' => true
                ]
            );
        }
    }
}