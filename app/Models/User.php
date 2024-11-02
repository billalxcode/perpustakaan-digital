<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'rfid',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    protected static function booted()
    {
        static::creating(function (User $user) {
            // dd($user->hasAnyRole(['admin', 'officer', 'general']));
            if (! $user->hasAnyRole(['admin', 'officer'])) {
                $user->assignRole('general');
            }
        });
    }

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        if ($panel->getId() === 'general') {
            return $this->hasRole('general');
        } elseif ($panel->getId() === 'admin') {
            return $this->hasRole('admin');
        } elseif ($panel->getId() === 'officer') {
            return $this->hasRole('officer');
        } else {
            return false;
        }
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return 'https://boring-avatars-api.vercel.app/api/avatar?size=40&variant=marble';
    }
}
