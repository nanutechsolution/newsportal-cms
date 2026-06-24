<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ArticleStatus: string implements HasColor, HasIcon, HasLabel
{
    case Draft = 'draft';
    case Review = 'review';
    case Revision = 'revision';
    case Approved = 'approved';
    case Scheduled = 'scheduled';
    case Published = 'published';
    case Archived = 'archived';
    case Rejected = 'rejected';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Review => 'Menunggu Review',
            self::Revision => 'Revisi',
            self::Approved => 'Disetujui',
            self::Scheduled => 'Terjadwal',
            self::Published => 'Diterbitkan',
            self::Archived => 'Diarsipkan',
            self::Rejected => 'Ditolak',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Review => 'warning',
            self::Revision => 'danger',
            self::Approved => 'success',
            self::Scheduled => 'info',
            self::Published => 'success',
            self::Archived => 'gray',
            self::Rejected => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Draft => 'heroicon-m-pencil',
            self::Review => 'heroicon-m-eye',
            self::Revision => 'heroicon-m-arrow-path',
            self::Approved => 'heroicon-m-check-badge',
            self::Scheduled => 'heroicon-m-clock',
            self::Published => 'heroicon-m-globe-americas',
            self::Archived => 'heroicon-m-archive-box',
            self::Rejected => 'heroicon-m-x-circle',
        };
    }
}