<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageWidget extends Model
{
    use HasFactory;

    protected $table = 'page_widgets';

    protected $fillable = [
        'site_id',
        'page_id',
        'widget_registry_id',
        'configuration',
        'order_column',
        'is_active',
    ];

    protected $casts = [
        'configuration' => 'array',
        'is_active' => 'boolean',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function registry(): BelongsTo
    {
        return $this->belongsTo(WidgetRegistry::class, 'widget_registry_id');
    }
}