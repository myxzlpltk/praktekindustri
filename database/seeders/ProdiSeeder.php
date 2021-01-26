<?php

namespace Database\Seeders;

use App\Models\Coordinator;
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
    	$coordinators = Coordinator::all();

		Prodi::create([
			'coordinator_id' => $coordinators->get(1)->id,
			'name' => 'S1 Pendidikan Teknik Informatika',
			'code' => 'S1PTI',
		]);
		Prodi::create([
			'coordinator_id' => $coordinators->get(0)->id,
			'name' => 'S1 Pendidikan Teknik Elektro',
			'code' => 'S1PTE',
		]);
		Prodi::create([
			'coordinator_id' => $coordinators->get(1)->id,
			'name' => 'S1 Teknik Informatika',
			'code' => 'S1TI',
		]);
		Prodi::create([
			'coordinator_id' => $coordinators->get(0)->id,
			'name' => 'S1 Teknik Elektro',
			'code' => 'S1TE',
		]);
		Prodi::create([
			'coordinator_id' => $coordinators->get(0)->id,
			'name' => 'D3 Teknik Elektro',
			'code' => 'D3ELKO',
		]);
		Prodi::create([
			'coordinator_id' => $coordinators->get(1)->id,
			'name' => 'D3 Teknik Elektronika',
			'code' => 'D3ELKA',
		]);
    }
}
