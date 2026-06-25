<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Batasi akses ke Filament Panel hanya untuk user yang memiliki role tertentu.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Untuk saat ini, izinkan semua user yang punya role apapun (kecuali guest murni)
        return $this->hasRole(['super_admin', 'Editor', 'Wartawan']);
    }
    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    public function page(): HasMany
    {
        return $this->hasMany(Page::class, 'author_id');
    }
}
