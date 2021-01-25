<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class LeaderSeeder extends Seeder{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
		$user = User::factory()->create([
			'name' => 'Aji Prasetya Wibawa, S.T., M.M.T., Ph.D.',
			'username' => '197912182005011001',
			'role' => 'admin'
		]);
		$user->leader()->create([
			'id_type' => 'NIP',
			'id_number' => '197912182005011001',
		]);
    }
}
