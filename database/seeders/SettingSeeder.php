<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
			Setting::create([
				'key' => 'nama_kajur',
				'value' => 'Dr. Hakkun Elmunsyah, S.T., M.T.',
				'description' => 'Nama Kepala Jurusan'
			]);
			Setting::create([
				'key' => 'nip_kajur',
				'value' => 'NIP 196509161995121001',
				'description' => 'NIP/NITP Kepala Jurusan'
			]);
			Setting::create([
				'key' => 'nama_koor',
				'value' => 'Achmad Hamdan, S.Pd., M.Pd.',
				'description' => 'Nama Koordinator Praktek Industri'
			]);
			Setting::create([
				'key' => 'nip_koor',
				'value' => 'NITP 6400201819443',
				'description' => 'NIP/NITP Koordinator Praktek Industri'
			]);
    }
}
