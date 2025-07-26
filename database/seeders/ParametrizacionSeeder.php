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
    public function run(): void
    {
        // Permisos basico de sistema
        $permisos = ['Alta', 'Baja', 'Modificacion', 'Lectura'];
        foreach ($permisos as $permiso) {
            DB::table('permisos')->updateOrInsert(['nombre' => $permiso]);
        }


        //Todos los Modulos del sistema
        $modulos = [
            ['nombre' => 'Roles', 'descripcion' => 'Gestion de roles y permisos.'],
            ['nombre' => 'Actividades', 'descripcion' => 'Actividades del sistema. Ej: Natacion, Boxeo, Etc'],
            ['nombre' => 'Usuarios', 'descripcion' => 'Gestion de Usuarios para asignar Roles'],
            ['nombre' => 'Configurar Turnos', 'descripcion' => 'Gestion de Turnos asignamos dia y horario a la actividad'],
            ['nombre' => 'Reservar Turnos', 'descripcion' => 'Gestion de Turnos se puede reservar un turno'],
        ];

        foreach ($modulos as $modulo) {
            DB::table('modulos')->updateOrInsert(
                ['nombre' => $modulo['nombre']],
                ['descripcion' => $modulo['descripcion']]
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
    }
}
