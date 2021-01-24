<?php

namespace Database\Factories;

use App\Models\Proposal;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProposalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Proposal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'lokasi_prakerin' => $this->faker->company,
			'tgl_sah' => $this->faker->dateTimeBetween('-1 months'),
			'file_proposal' => $this->faker->file('storage/faker/proposal', 'storage/app/public/proposal', false),
			'status_code' => Proposal::STATUS_Tunggu_TTDKoor,
			'lembar_sah' => $this->faker->sentence(12),
			'alasanKoor' => $this->faker->sentence(12),
			'alasanKajur' => $this->faker->sentence(12),
			'created_at' => $this->faker->dateTimeBetween('-1 months'),
        ];
    }
}
