<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WidgetRegistry extends Model
{
    use HasFactory;

    protected $table = 'widget_registry';

    protected $fillable = [
        'name',
        'class_name',
        'default_config_schema',
        'is_active',
    ];

    protected $casts = [
        'default_config_schema' => 'array',
        'is_active' => 'boolean',
    ];

    public function pageWidgets(): HasMany
    {
        return $this->hasMany(PageWidget::class);
    }
}