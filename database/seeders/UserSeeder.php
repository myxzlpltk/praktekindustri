<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'username' => 'admin',
            'role' => 'admin'
        ]);
		User::factory()->create([
			'username' => 'coordinator',
			'role' => 'coordinator'
		]);
        User::factory(10)->create()->each(function($user){
			$user->student()->save(
				Student::factory()->make([
					'nim' => $user->username
				])
			);
		});
    }
}
