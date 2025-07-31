<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

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
        'name',
        'email',
        'password',
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

    // Crea la relación con la tabla rol
    public function rol()
    {
        return $this->belongsToMany(Rol::class, 'usuario_rol', 'id_usuario', 'id_rol');
    }

    // Obtenemos el nombre del rol
    public function getRolNombreAttribute()
    {
        return $this->rol->first()?->nombre;
    }

    public function tienePermiso($moduloNombre, $permisoNombre)
    {
        return DB::table('usuario_rol')
            ->join('modulo_permiso_rol', 'usuario_rol.id_rol', '=', 'modulo_permiso_rol.id_roles')
            ->join('modulos', 'modulo_permiso_rol.id_modulos', '=', 'modulos.id_modulos')
            ->join('permisos', 'modulo_permiso_rol.id_permisos', '=', 'permisos.id_permisos')
            ->where('usuario_rol.id_usuario', $this->id)
            ->where('modulos.nombre', $moduloNombre)
            ->where('permisos.nombre', $permisoNombre)
            ->exists();
    }

    public function scopeInstructores($query)
    {
        return $query->whereHas('rol', fn($q) => $q->where('es_instructor', true));
    }
}
