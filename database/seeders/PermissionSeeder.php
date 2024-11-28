<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            // Grupo: Roles
            ['name' => 'ver-role', 'grupo' => 'ROLES'],
            ['name' => 'crear-role', 'grupo' => 'ROLES'],
            ['name' => 'editar-role', 'grupo' => 'ROLES'],
            ['name' => 'eliminar-role', 'grupo' => 'ROLES'],
            ['name' => 'restaurar-role', 'grupo' => 'ROLES'],

            // Grupo: User
            ['name' => 'ver-usuario', 'grupo' => 'USUARIOS'],
            ['name' => 'crear-usuario', 'grupo' => 'USUARIOS'],
            ['name' => 'editar-usuario', 'grupo' => 'USUARIOS'],
            ['name' => 'eliminar-usuario', 'grupo' => 'USUARIOS'],
            ['name' => 'restaurar-usuario', 'grupo' => 'USUARIOS'],

            // Grupo: Placas
            ['name' => 'ver-boards', 'grupo' => 'PLACAS'],
            ['name' => 'crear-boards', 'grupo' => 'PLACAS'],
            ['name' => 'editar-boards', 'grupo' => 'PLACAS'],
            ['name' => 'eliminar-boards', 'grupo' => 'PLACAS'],
            ['name' => 'restaurar-boards', 'grupo' => 'PLACAS'],

            // Grupo: Orders
            ['name' => 'ver-ordenes', 'grupo' => 'ORDENES'],
            ['name' => 'ver-almacen', 'grupo' => 'ORDENES'],
            ['name' => 'ver-recibido', 'grupo' => 'ORDENES'],
            ['name' => 'ver-completado', 'grupo' => 'ORDENES'],
            ['name' => 'revertir-orden', 'grupo' => 'ORDENES'],  
            ['name' => 'ver-ordenesd', 'grupo' => 'ORDENES'],
            ['name' => 'ver-orders', 'grupo' => 'ORDENES'],

            ['name' => 'ver-molds', 'grupo' => 'REPORTES'],

            // Grupo: Config
            ['name' => 'ver-log_Acceso', 'grupo' => 'ADMINISTRACIÓN'],
            ['name' => 'ver-dashboard', 'grupo' => 'ADMINISTRACIÓN'],
        ];

        foreach ($permisos as $permiso) {
            Permission::create([
                'name' => $permiso['name'],
                'grupo' => $permiso['grupo'],
            ]);
        }
    }
}
