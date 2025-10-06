<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $fillable = [
        'intranet_user_id',
        'user_email',
        'user_name',
        'access_type',
        'allowed_sections',
        'active',
    ];

    protected $casts = [
        'allowed_sections' => 'array',
        'active' => 'boolean',
    ];

    /**
     * Verificar si el usuario tiene acceso total
     */
    public function hasTotalAccess()
    {
        return $this->active && $this->access_type === 'total';
    }

    /**
     * Verificar si el usuario puede acceder a una sección específica
     */
    public function canAccessSection($section)
    {
        if (!$this->active) {
            return false;
        }

        if ($this->access_type === 'total') {
            return true;
        }

        if ($this->access_type === 'secciones') {
            return in_array($section, $this->allowed_sections ?? []);
        }

        return false;
    }

    /**
     * Obtener secciones permitidas
     */
    public function getAllowedSections()
    {
        if ($this->access_type === 'total') {
            return null; // null = todas las secciones
        }

        return $this->allowed_sections ?? [];
    }

    /**
     * Buscar permisos por email de usuario
     */
    public static function findByEmail($email)
    {
        return static::where('user_email', $email)->where('active', true)->first();
    }

    /**
     * Buscar permisos por ID de usuario de intranet
     */
    public static function findByIntranetUserId($userId)
    {
        return static::where('intranet_user_id', $userId)->where('active', true)->first();
    }
}
