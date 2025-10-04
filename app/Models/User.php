<?php

namespace App\Models;

use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable 
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'no_telp',
        'alamat',
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

    /**
     * Get all donations made by this user
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get successful donations only
     */
    public function successDonations()
    {
        return $this->hasMany(Donation::class)->where('status', 'sukses');
    }

    /**
     * Get total amount donated by this user
     */
    public function getTotalDonatedAttribute()
    {
        return $this->successDonations()->sum('jumlah');
    }

//      public function canAccessPanel(Panel $panel): bool
// {
    
     
//             return $this->hasRole('super_admin');
      
    
// }
}