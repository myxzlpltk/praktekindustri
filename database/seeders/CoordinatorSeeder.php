<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CoordinatorSeeder extends Seeder{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
		$user1 = User::factory()->create([
			'name' => 'Kartika Candra Kirana, S.Pd., M. Kom.',
			'username' => '199105012019032030',
			'role' => 'coordinator'
		]);
		$user1->coordinator()->create([
			'id_type' => 'NIP',
			'id_number' => '199105012019032030',
		]);
		$user2 = User::factory()->create([
			'name' => 'Achmad Hamdan, S.Pd., M.Pd.',
			'username' => '6400201819443',
			'role' => 'coordinator'
		]);
		$user2->coordinator()->create([
			'id_type' => 'NITP',
			'id_number' => '6400201819443',
		]);
    }
}
