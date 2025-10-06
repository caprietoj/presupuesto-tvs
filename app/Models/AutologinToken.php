<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AutologinToken extends Model
{
    protected $fillable = [
        'token',
        'user_id',
        'user_email',
        'expires_at',
        'used',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];

    /**
     * Generar un nuevo token de autologin
     */
    public static function generateToken($userId, $userEmail, $expiresInMinutes = 5)
    {
        // Limpiar tokens expirados
        static::where('expires_at', '<', now())->delete();
        
        // Limpiar tokens usados de más de 1 hora
        static::where('used', true)
            ->where('created_at', '<', now()->subHour())
            ->delete();

        return static::create([
            'token' => Str::random(64),
            'user_id' => $userId,
            'user_email' => $userEmail,
            'expires_at' => now()->addMinutes($expiresInMinutes),
            'used' => false,
        ]);
    }

    /**
     * Validar y marcar token como usado
     */
    public function consume()
    {
        if ($this->used) {
            return false;
        }

        if ($this->expires_at < now()) {
            return false;
        }

        $this->update(['used' => true]);
        return true;
    }

    /**
     * Scope para tokens válidos
     */
    public function scopeValid($query)
    {
        return $query->where('used', false)
            ->where('expires_at', '>', now());
    }
}
