<?php

namespace Database\Factories;

use App\Models\Prodi;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'prodi_id' => Prodi::inRandomOrder()->first()->id,
			'angkatan' => 2017,
			'ktm' => $this->faker->file('storage/faker/ktm', 'storage/app/public/ktm', false),
			'valid' => true
        ];
    }
}
