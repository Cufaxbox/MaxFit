<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class ParametrizacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    //en esta clase cargamos todos los datos de parametrizacion que utlizamos por default en el sistema
    // Crea los roles del sistema y sus permisos establecidos
    public function run(): void
    {
        // Permisos basico de sistema
        $permisos = ['Alta', 'Baja', 'Modificacion', 'Lectura'];
        foreach ($permisos as $permiso) {
            DB::table('permisos')->updateOrInsert(['nombre' => $permiso]);
        }


        //Todos los Modulos del sistema
        $modulos = [
            ['nombre' => 'Roles', 'descripcion' => 'Gestión de roles y permisos.', 'ruta_index' => 'roles.index'],
            ['nombre' => 'Actividades', 'descripcion' => 'Actividades del sistema. Ej: Natación, Boxeo, Etc', 'ruta_index' => 'actividades.index'],
            ['nombre' => 'Usuarios', 'descripcion' => 'Gestión de Usuarios para asignar Roles', 'ruta_index' => 'usuarios.index'],
            ['nombre' => 'Configurar Turnos', 'descripcion' => 'Asignamos día y horario a la actividad', 'ruta_index' => 'turno_plantillas.index'],
            ['nombre' => 'Reservar Turnos', 'descripcion' => 'Permite a los usuarios reservar un turno', 'ruta_index' => 'reservar_turnos.index'],
        ];

        foreach ($modulos as $modulo) {
            DB::table('modulos')->updateOrInsert(
                ['nombre' => $modulo['nombre']],
                ['descripcion' => $modulo['descripcion'], 'ruta_index' => $modulo['ruta_index']]
            );
        }

        //Creamso el rol admin
        DB::table('roles')->updateOrInsert(
            ['nombre' => 'Admin'],
            ['descripcion' => 'Todos los permisos']
        );

        //Crearmos usuario admin
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('1234'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );


        // Creamos el rol Cliente
        DB::table('roles')->updateOrInsert(
            ['nombre' => 'Cliente'],
            ['descripcion' => 'Rol por defecto para usuarios registrados']
        );

        //Asignamos rol Admin al usuario

        $adminUserId = DB::table('users')->where('email', 'admin@gmail.com')->value('id');
        $adminRoleId = DB::table('roles')->where('nombre', 'Admin')->value('id_roles');
        DB::table('usuario_rol')->updateOrInsert([
            'id_usuario' => $adminUserId,
            'id_rol' => $adminRoleId,
        ]);

        //Asigmos TODOS los permisos del sistema al rol Admin
        $moduloIds = DB::table('modulos')->pluck('id_modulos');
        $permisoIds = DB::table('permisos')->pluck('id_permisos');

        foreach ($moduloIds as $moduloId) {
            foreach ($permisoIds as $permisoId) {
                DB::table('modulo_permiso_rol')->updateOrInsert([
                    'id_roles' => $adminRoleId,
                    'id_modulos' => $moduloId,
                    'id_permisos' => $permisoId,
                ]);
            }
        }

        // Asignar todos los permisos al rol Cliente solo para módulos: Actividades y Reservar Turnos
        $clienteRoleId = DB::table('roles')->where('nombre', 'Cliente')->value('id_roles');

        $modulosCliente = DB::table('modulos')
            ->whereIn('nombre', ['Actividades', 'Reservar Turnos'])
            ->pluck('id_modulos');

        foreach ($modulosCliente as $moduloId) {
            foreach ($permisoIds as $permisoId) {
                DB::table('modulo_permiso_rol')->updateOrInsert([
                    'id_roles' => $clienteRoleId,
                    'id_modulos' => $moduloId,
                    'id_permisos' => $permisoId,
                ]);
            }
        }
    }
}
