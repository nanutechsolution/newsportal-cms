<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleDailyStats extends Model
{
    use HasFactory;

    // Menonaktifkan timestamps karena kita hanya menyimpan data agregasi harian
    public $timestamps = false;

    protected $fillable = [
        'site_id',
        'article_id',
        'stat_date',
        'total_views',
        'unique_visitors',
        'avg_time_on_page',
    ];

    protected $casts = [
        'stat_date' => 'date',
        'total_views' => 'integer',
        'unique_visitors' => 'integer',
        'avg_time_on_page' => 'integer',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}