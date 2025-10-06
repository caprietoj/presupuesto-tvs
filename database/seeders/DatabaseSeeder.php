<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Este sistema usa autenticación desde intranet
        // No se necesitan usuarios locales
        
        // Para poblar datos iniciales, ejecutar:
        // php artisan db:seed --class=CentroCostoSeccionSeeder
        
        echo "DatabaseSeeder: No hay datos que poblar aquí." . PHP_EOL;
        echo "Para datos iniciales, ejecuta: php artisan db:seed --class=CentroCostoSeccionSeeder" . PHP_EOL;
    }
}
