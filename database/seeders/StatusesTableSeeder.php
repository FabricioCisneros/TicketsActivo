<?php

namespace Database\Seeders;

use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Status::count() === 0) {
            $now = Carbon::now();
            Status::insert([
                ['name' => 'Abierto', 'created_at' => $now, 'updated_at' => $now],
                ['name' => 'Pendiente', 'created_at' => $now, 'updated_at' => $now],
                ['name' => 'Resuelto', 'created_at' => $now, 'updated_at' => $now],
                ['name' => 'Cerrado', 'created_at' => $now, 'updated_at' => $now],
                ['name' => 'Caducado', 'created_at' => $now, 'updated_at' => $now],
            ]);
        }
    }
}
