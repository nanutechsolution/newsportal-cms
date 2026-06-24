<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageView extends Model
{
    use HasFactory;

    // Menonaktifkan updated_at karena kita hanya mencatat waktu dibuat (created_at)
    const UPDATED_AT = null;

    protected $fillable = [
        'site_id',
        'article_id',
        'session_id',
        'view_date',
        'created_at',
    ];

    protected $casts = [
        'view_date' => 'date',
        'created_at' => 'datetime',
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