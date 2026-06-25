<?php

namespace App\Models;

use App\Enums\ArticleStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Article extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, LogsActivity;

    protected $fillable = [
        'site_id',
        'category_id',
        'author_id',
        'editor_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_caption',
        'cover_source',
        'status',
        'is_featured',
        'is_breaking',
        'allow_comments',
        'published_at',
    ];

    protected $casts = [
        'status' => ArticleStatus::class,
        'is_featured' => 'boolean',
        'allow_comments' => 'boolean',
        'is_breaking' => 'boolean',
        'published_at' => 'datetime',
    ];

    
    /**
     * Konfigurasi Spatie Activity Log
     * Merekam setiap perubahan pada kolom fillable.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty() // Hanya rekam kolom yang benar-benar berubah nilainya
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Artikel telah di-{$eventName}");
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function seoMetadata(): MorphOne
    {
        return $this->morphOne(SeoMetadata::class, 'model');
    }

    public function dailyStats(): HasMany
    {
        return $this->hasMany(ArticleDailyStats::class);
    }
}
