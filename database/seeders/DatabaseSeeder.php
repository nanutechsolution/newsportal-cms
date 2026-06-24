<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Site;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Article;
use App\Models\Page;
use App\Models\WidgetRegistry;
use App\Models\PageWidget;
use App\Enums\ArticleStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Default Admin User
        $admin = User::factory()->create([
            'name' => 'Super Administrator',
            'email' => 'admin@nusaaksara.com',
        ]);

        // 2. Create Default Sites
        $site = Site::create([
            'name' => 'Portal Berita Utama',
            'domain' => 'nusaaksara.com',
            'is_active' => true,
        ]);

        // 3. Create Categories
        $cat1 = Category::create(['site_id' => $site->id, 'name' => 'Nasional', 'slug' => 'nasional', 'order_column' => 1]);
        $cat2 = Category::create(['site_id' => $site->id, 'name' => 'Teknologi', 'slug' => 'teknologi', 'order_column' => 2]);

        // 4. Create Tags
        $tag = Tag::create(['site_id' => $site->id, 'name' => 'Laravel', 'slug' => 'laravel']);

        // 5. Create Articles
        $article = Article::create([
            'site_id' => $site->id,
            'category_id' => $cat1->id,
            'author_id' => $admin->id,
            'title' => 'Selamat Datang di NusaAksara CMS',
            'slug' => 'selamat-datang-di-nusaaksara-cms',
            'content' => 'Ini adalah artikel pertama yang dibuat secara otomatis oleh seeder.',
            'status' => ArticleStatus::Published,
            'published_at' => now(),
        ]);
        $article->tags()->attach($tag->id);

        // 6. Create Pages (Homepage Builder)
        $homePage = Page::create([
            'site_id' => $site->id,
            'title' => 'Homepage',
            'slug' => 'home',
            'layout' => 'homepage-builder',
        ]);

        // 7. Setup Widget Registry & Page Widgets
        $widget = WidgetRegistry::create([
            'name' => 'Trending News Widget',
            'class_name' => 'App\Widgets\TrendingNewsWidget',
            'default_config_schema' => ['limit' => 5],
            'is_active' => true,
        ]);

        PageWidget::create([
            'site_id' => $site->id,
            'page_id' => $homePage->id,
            'widget_registry_id' => $widget->id,
            'configuration' => ['limit' => 5],
            'order_column' => 1,
        ]);
    }
}