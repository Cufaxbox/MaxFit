<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DatosPruebaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Creamso el rol Cliente , Instructor ,Administrativo 
        $roles = [
            ['nombre' => 'Cliente', 'descripcion' => 'Puede reservar turnos y ver sus rutinas', 'es_instructor' => 0],
            ['nombre' => 'Instructor', 'descripcion' => 'Puede asignar rutinas a los clientes', 'es_instructor' => 1],
            ['nombre' => 'Administrativo', 'descripcion' => 'Gestiona usuarios y configura turnos', 'es_instructor' => 0],
        ];

        foreach ($roles as $rol) {
            DB::table('roles')->updateOrInsert(
                ['nombre' => $rol['nombre']],
                [
                    'descripcion' => $rol['descripcion'],
                    'es_instructor' => $rol['es_instructor'],
                ]
            );
        }

        //Creamos los permisos para cada rol 
        //'Alta', 'Baja', 'Modificacion', 'Lectura'
        $asignaciones = [
            'Cliente' => [
                'Reservar Turnos' => ['Alta', 'Baja', 'Modificacion', 'Lectura'],
                'Mis Turnos' => ['Alta', 'Baja', 'Modificacion', 'Lectura'],
                'Mis Rutinas' => ['Alta', 'Baja', 'Modificacion', 'Lectura'],
            ],
            'Instructor' => [
                'Rutinas' => ['Alta', 'Baja', 'Modificacion', 'Lectura'],
            ],
            'Administrativo' => [
                'Usuarios' => ['Modificacion', 'Lectura'],
                'Configurar Turnos' => ['Alta', 'Baja', 'Modificacion', 'Lectura'],
            ],
        ];

        foreach ($asignaciones as $rolNombre => $modulosPermisos) {
            $rolId = DB::table('roles')->where('nombre', $rolNombre)->value('id_roles');

            foreach ($modulosPermisos as $moduloNombre => $permisos) {
                $moduloId = DB::table('modulos')->where('nombre', $moduloNombre)->value('id_modulos');

                foreach ($permisos as $permisoNombre) {
                    $permisoId = DB::table('permisos')->where('nombre', $permisoNombre)->value('id_permisos');

                    DB::table('modulo_permiso_rol')->updateOrInsert([
                        'id_roles' => $rolId,
                        'id_modulos' => $moduloId,
                        'id_permisos' => $permisoId,
                    ]);
                }
            }
        }


        //Creamos algunas Actividades
        $actividades = [
            'Natación',
            'Boxeo',
            'Crossfit',
            'Zumba',
            'Musculación',
            'HIIT',
            'Yoga',
        ];

        foreach ($actividades as $nombre) {
            DB::table('actividades')->updateOrInsert(
                ['nombre' => $nombre],
            );
        }


        //Generamos un pool de usuarios 5 instructores , 2 asministrativos y 20 usuarios
        $faker = Faker::create('es_AR'); // Español de Argentina

        $roles = [
            'Instructor' => 5,
            'Administrativo' => 2,
            'Cliente' => 20,
        ];

        foreach ($roles as $rolNombre => $cantidad) {
            $rolId = DB::table('roles')->where('nombre', $rolNombre)->value('id_roles');

            for ($i = 0; $i < $cantidad; $i++) {
                $email = $faker->unique()->safeEmail();
                $nombre = $faker->name();
                $password = $faker->password(8, 12);

                DB::table('users')->insert([
                    'name' => $nombre,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $userId = DB::table('users')->where('email', $email)->value('id');
                DB::table('usuario_rol')->insert([
                    'id_usuario' => $userId,
                    'id_rol' => $rolId,
                ]);
            }
        }


        //Generamos Turnos Aleatorios
        $faker = Faker::create('es_AR');

        // Obtener instructores válidos
        $instructores = DB::table('usuario_rol')
            ->join('roles', 'usuario_rol.id_rol', '=', 'roles.id_roles')
            ->where('roles.nombre', 'Instructor')
            ->pluck('id_usuario')
            ->toArray();

        // Obtener actividades válidas
        $actividades = DB::table('actividades')->pluck('id_actividades')->toArray();

        // Horarios posibles (pueden ajustarse)
        $horarios = ['08:00:00', '09:00:00', '10:00:00', '15:00:00', '17:00:00', '18:00:00', '19:00:00'];

        $usados = []; // Para evitar solapamientos

        foreach ($instructores as $instructorId) {
            $diasAsignados = [];

            for ($i = 0; $i < 4; $i++) { // 4 turnos por instructor
                $dia = $faker->numberBetween(1, 6);
                $hora = $faker->randomElement($horarios);
                $actividadId = $faker->randomElement($actividades);

                $key = "{$instructorId}_{$dia}_{$hora}";
                if (in_array($key, $usados)) {
                    continue; // Ya tiene turno ese día y hora
                }

                DB::table('turno_plantillas')->insert([
                    'dia_semana' => $dia,
                    'hora_inicio' => $hora,
                    'hora_fin' => date('H:i:s', strtotime($hora) + 3600), // +1 hora
                    'cupo' => $faker->numberBetween(3, 10),
                    'instructor_id' => $instructorId,
                    'id_actividad' => $actividadId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $usados[] = $key;
            }
        }

        //Generamso reservas aleatorias con los turnos ya creados
        $faker = Faker::create('es_AR');

        // Obtener clientes válidos
        $clientes = DB::table('usuario_rol')
            ->join('roles', 'usuario_rol.id_rol', '=', 'roles.id_roles')
            ->where('roles.nombre', 'Cliente')
            ->pluck('id_usuario')
            ->toArray();

        // Obtener turnos válidos
        $turnos = DB::table('turno_plantillas')->get();

        foreach ($turnos as $turno) {
            $diaSemana = $turno->dia_semana;
            $cupo = $turno->cupo;
            $idTurno = $turno->id_turno_plantilla;

            // Buscar fechas reales que coincidan con el día de semana
            $fechasValidas = [];
            for ($i = 0; $i < 14; $i++) {
                $fecha = Carbon::now()->addDays($i);
                if ($fecha->dayOfWeekIso === $diaSemana) {
                    $fechasValidas[] = $fecha;
                }
            }

            if (empty($fechasValidas)) continue;

            // Elegimos una fecha válida aleatoria
            $fechaTurno = $faker->randomElement($fechasValidas);
            $clientesReservados = [];

            // Generamos entre 1 y cupo reservas
            $cantidadReservas = $faker->numberBetween(1, $cupo);
            $clientesShuffle = $faker->randomElements($clientes, $cantidadReservas);

            foreach ($clientesShuffle as $clienteId) {
                DB::table('reserva_turnos')->insert([
                    'id_turno_plantilla' => $idTurno,
                    'id_usuario' => $clienteId,
                    'fecha_turno' => $fechaTurno->toDateString(),
                    'estado' => 'confirmada',
                    'fecha_reserva' => Carbon::now(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        //generamso rutinas aleatorias
        $faker = Faker::create('es_AR');

        // Obtener clientes e instructores
        $clientes = DB::table('usuario_rol')
            ->join('roles', 'usuario_rol.id_rol', '=', 'roles.id_roles')
            ->where('roles.nombre', 'Cliente')
            ->pluck('id_usuario')
            ->toArray();

        $instructores = DB::table('usuario_rol')
            ->join('roles', 'usuario_rol.id_rol', '=', 'roles.id_roles')
            ->where('roles.nombre', 'Instructor')
            ->pluck('id_usuario')
            ->toArray();

        foreach ($clientes as $clienteId) {
            $instructorId = $faker->randomElement($instructores);

            DB::table('rutinas')->insert([
                'cliente_id'     => $clienteId,
                'asignado_por_id'  => $instructorId,
                'descripcion'    => $faker->sentence(6),
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ]);
        }
    }
}
