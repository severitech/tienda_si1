<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'paterno',
        'materno',
        'telefono',
        'email',
        'password',
        'estado',
        'ROL',
        'remember_token',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function getRolAttribute()
    {
        return $this->attributes['ROL'];
    }
    public function setRolAttribute($value)
    {
        $this->attributes['ROL'] = $value;
    }
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
     * Get the user's full name
     */
    public function getNameAttribute(): string
    {
        $nombre = $this->nombre ?? '';
        $paterno = $this->paterno ?? '';
        $materno = $this->materno ?? '';
        
        return trim($nombre . ' ' . $paterno . ' ' . $materno);
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        $nombre = $this->nombre ?? '';
        $paterno = $this->paterno ?? '';
        $materno = $this->materno ?? '';
        
        $fullName = trim($nombre . ' ' . $paterno . ' ' . $materno);
        
        if (empty($fullName)) {
            return 'U'; // Default initial if no name
        }
        
        return Str::of($fullName)
            ->explode(' ')
            ->filter(fn($name) => !empty($name))
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }
}
