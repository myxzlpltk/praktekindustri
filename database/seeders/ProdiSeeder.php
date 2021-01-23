<?php

namespace Database\Seeders;

use App\Models\Prodi;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
		Prodi::create(['name' => 'S1 Pendidikan Teknik Informatika', 'code' => 'S1PTI']);
		Prodi::create(['name' => 'S1 Pendidikan Teknik Elektro', 'code' => 'S1PTE']);
		Prodi::create(['name' => 'S1 Teknik Informatika', 'code' => 'S1TI']);
		Prodi::create(['name' => 'S1 Teknik Elektro', 'code' => 'S1TE']);
		Prodi::create(['name' => 'D3 Teknik Elektro', 'code' => 'D3ELKO']);
		Prodi::create(['name' => 'D3 Teknik Elektronika', 'code' => 'D3ELKA']);
    }
}
