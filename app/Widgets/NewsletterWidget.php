<?php

namespace App\Widgets;

use App\Models\PageWidget;
use Illuminate\Support\Facades\View;

class NewsletterWidget extends BaseWidget
{
    public function render(PageWidget $widget): string
    {
        return View::make('widgets.newsletter')->render();
    }
}