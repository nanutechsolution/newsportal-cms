<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoMetadata extends Model
{
    use HasFactory;

    protected $table = 'seo_metadata';

    protected $fillable = [
        'model_type',
        'model_id',
        'meta_title',
        'meta_description',
        'canonical_url',
        'og_image_url',
        'schema_json',
    ];

    protected $casts = [
        'schema_json' => 'array',
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}