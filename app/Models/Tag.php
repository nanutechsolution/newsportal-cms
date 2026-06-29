<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'name',
        'slug',
    ];

     /**
     * Metode boot model untuk mencegat aksi database.
     */
    protected static function booted(): void
    {
        static::creating(function (Tag $tag) {
            // Otomatis mengisi site_id jika kosong (misal: saat dibuat via inline form di Filament)
            // Ini akan mengambil ID dari website utama secara default.
            if (empty($tag->site_id)) {
                $tag->site_id = Site::first()?->id;
            }
        });
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}