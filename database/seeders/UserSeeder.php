<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Belen',
            'lastname' => 'Ugarte',
            'document' => '12513827',
            'email' => 'belen@gmail.com',
            'phone' => '60103045',
            'password' => bcrypt('123')
        ]);
         //Usuario administrador
         $rol = Role::create(['name' => 'ADMINISTRADOR']);
         $permisos = Permission::pluck('id','id')->all();
         $rol->syncPermissions($permisos);
         $user = User::find(1);
         $user->assignRole('ADMINISTRADOR'); 
    }
}
