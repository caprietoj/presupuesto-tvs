<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserPermission;
use Illuminate\Support\Facades\DB;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar permisos existentes
        UserPermission::truncate();

        /**
         * IMPORTANTE: Estos usuarios deben existir en la base de datos de Intranet
         * Buscar el ID y email correcto de cada usuario antes de agregar
         * 
         * Para buscar usuarios, ejecutar:
         * php artisan tinker
         * DB::connection('intranet')->table('users')->where('name', 'LIKE', '%nombre%')->get(['id', 'name', 'email']);
         */

        $permissions = [
            // ===== ACCESO TOTAL =====
            [
                'intranet_user_id' => 1,
                'user_email' => 'intranet@tvs.edu.co',
                'user_name' => 'Cristian Andres Prieto J.',
                'access_type' => 'total',
                'allowed_sections' => null,
            ],
            [
                'intranet_user_id' => 1,
                'user_email' => 'jefesistemas@tvs.edu.co',
                'user_name' => 'Cristian Andres Prieto J.',
                'access_type' => 'total',
                'allowed_sections' => null,
            ],
            [
                'intranet_user_id' => 16,
                'user_email' => 'generaldirector@tvs.edu.co',
                'user_name' => 'Maria Del Pilar Robles Rodríguez',
                'access_type' => 'total',
                'allowed_sections' => null,
            ],
            [
                'intranet_user_id' => 92,
                'user_email' => 'administrativedirector@tvs.edu.co',
                'user_name' => 'Juliana Pérez López',
                'access_type' => 'total',
                'allowed_sections' => null,
            ],
            [
                'intranet_user_id' => 84,
                'user_email' => 'contabilidad@tvs.edu.co',
                'user_name' => 'Nini Johanna Arredondo D',
                'access_type' => 'total',
                'allowed_sections' => null,
            ],
            
            // ===== ACCESO POR SECCIONES =====
            [
                'intranet_user_id' => 20,
                'user_email' => 'preschool@tvs.edu.co',
                'user_name' => 'Ana Maria Grisales',
                'access_type' => 'secciones',
                'allowed_sections' => ['PREESCOLAR Y PRIMARIA'],
            ],
            [
                'intranet_user_id' => 21,
                'user_email' => 'coordpep@tvs.edu.co',
                'user_name' => 'HELENA ORTIZ',
                'access_type' => 'secciones',
                'allowed_sections' => ['PEP'],
            ],
            [
                'intranet_user_id' => 19,
                'user_email' => 'escuelamedia@tvs.edu.co',
                'user_name' => 'GINA LORENA HURTADO GÓMEZ',
                'access_type' => 'secciones',
                'allowed_sections' => ['MEDIA'],
            ],
            [
                'intranet_user_id' => 17,
                'user_email' => 'coordpai@tvs.edu.co',
                'user_name' => 'Andrea Carolina Florez Varon',
                'access_type' => 'secciones',
                'allowed_sections' => ['PAI'],
            ],
            [
                'intranet_user_id' => 18,
                'user_email' => 'dp@tvs.edu.co',
                'user_name' => 'Maria Constanza Bernal Baracaldo',
                'access_type' => 'secciones',
                'allowed_sections' => ['ALTA'],
            ],
            [
                'intranet_user_id' => 22,
                'user_email' => 'psicologia2@tvs.edu.co',
                'user_name' => 'Johanna Gavidia Barbosa',
                'access_type' => 'secciones',
                'allowed_sections' => ['DEPARTAMENTO DE APOYO'],
            ],
            [
                'intranet_user_id' => 57,
                'user_email' => 'mabernal@tvs.edu.co',
                'user_name' => 'Miguel Augusto Bernal',
                'access_type' => 'secciones',
                'allowed_sections' => ['DEPORTES ACADEMIA'],
            ],
            [
                'intranet_user_id' => 47,
                'user_email' => 'library@tvs.edu.co',
                'user_name' => 'Laura Rodriguez Laverde',
                'access_type' => 'secciones',
                'allowed_sections' => ['BIBLIOTECA'],
            ],
        ];

        foreach ($permissions as $permission) {
            UserPermission::create($permission);
        }

        $this->command->info('✓ Permisos de usuarios creados exitosamente');
        $this->command->info('Total de usuarios con acceso: ' . UserPermission::count());
    }
}
