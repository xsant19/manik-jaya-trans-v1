<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'phone', 'address'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === 'admin';
    }

    public function rentalBookings()
    {
        return $this->hasMany(RentalBooking::class);
    }

    public function tourBookings()
    {
        return $this->hasMany(TourBooking::class);
    }

    public function transferBookings()
    {
        return $this->hasMany(TransferBooking::class);
    }

    public function shuttleBookings()
    {
        return $this->hasMany(ShuttleBooking::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
