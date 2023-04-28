<?php

namespace Database\Seeders;

use App\Models\Suscripcion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;


class Suscripciones extends Seeder
{
/**
* Run the database seeds.
*/
public function run(): void
{
$suscripciones = [
[
    'id' => 1,
    'nombre_suscripcion' => 'No Suscripción',
    'precio_suscripcion' => 0,
    'duracion' => 0,
    'created_at' => \Carbon\Carbon::now(),
    'updated_at' => \Carbon\Carbon::now()
],
[
    'id' => 2,
    'nombre_suscripcion' => 'PlayStation Plus Essential',
    'precio_suscripcion' => 8.99,
    'duracion' => 1,
    'created_at' => \Carbon\Carbon::now(),
    'updated_at' => \Carbon\Carbon::now()
],
[
    'id' => 3,
    'nombre_suscripcion' => 'PlayStation Plus Extra',
    'precio_suscripcion' => 39.99,
    'duracion' => 3,
    'created_at' => \Carbon\Carbon::now(),
    'updated_at' => \Carbon\Carbon::now()
],
[
    'id' => 4,
    'nombre_suscripcion' => 'PlayStation Plus Premium',
    'precio_suscripcion' => 119.99,
    'duracion' => 3,
    'created_at' => \Carbon\Carbon::now(),
    'updated_at' => \Carbon\Carbon::now()
]

];

Suscripcion::insert($suscripciones);
}
}

?>
