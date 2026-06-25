<?php

namespace App\Widgets;

use App\Models\PageWidget;

abstract class BaseWidget
{
    /**
     * Setiap widget yang dibuat harus memiliki fungsi render()
     * yang mengembalikan string HTML (bisa dari view() Laravel).
     */
    abstract public function render(PageWidget $widget): string;
}