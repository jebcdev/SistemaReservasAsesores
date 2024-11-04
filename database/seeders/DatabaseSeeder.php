<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       // Eliminar todos los archivos de la carpeta assets/img/users/
       $directory = public_path('assets/img/users/');
       if (File::exists($directory)) {
           File::deleteDirectory($directory);
           // Volver a crear la carpeta después de eliminarla
           File::makeDirectory($directory, 0755, true);
       }
        
        $this->call([
            RoleUserDetailSeeder::class,
            ReservationSeeder::class,
            
        ]);
    }
}
