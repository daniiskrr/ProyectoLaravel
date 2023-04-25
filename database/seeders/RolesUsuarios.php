<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;


class RolesUsuarios extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id' => 1,
                'nombre' => 'Administrador'
            ],
            [
                'id' => 2,
                'nombre' => 'Usuario'
            ]
        ];

        Role::insert($roles);
    }
}
