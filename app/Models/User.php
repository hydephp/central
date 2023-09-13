<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser, HasAvatar, HasName
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function guest(): static
    {
        $user = User::where('email', 'guest@hydephp.com')->first();
        if (! $user) {
            $user = User::forceCreate([
                'name' => 'Guest',
                'email' => 'guest@hydephp.com',
                'email_verified_at' => now(),
                'password' => Hash::make('guest'),
            ]);
        }

        return $user;
    }

    public function isGuest(): bool
    {
        return $this->email === 'guest@hydephp.com';
    }

    public function isAdmin(): bool
    {
        return in_array($this->email, config('auth.admins')) && $this->hasVerifiedEmail();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        if ($this->isGuest()) {
            return asset('logo.svg');
        }

        return null;
    }

    public function getFilamentName(): string
    {
        return Str::before($this->name, ' ');
    }
}
