<?php

use App\Models\Proposal;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
			$table->id();
			$table->foreignId('student_id');
			$table->string('lokasi_prakerin');
			$table->string('tgl_sah');
			$table->string('file_proposal');
			$table->enum('status_code', [
				Proposal::STATUS_Tunggu_TTDKoor,
				Proposal::STATUS_Tunggu_TTDKajur,
				Proposal::STATUS_Ditolak_Koor,
				Proposal::STATUS_Ditolak_Kajur,
				Proposal::STATUS_Disahkan,
			]);
			$table->string('lembar_sah')->nullable();
			$table->text('alasanKoor')->nullable();
			$table->text('alasanKajur')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposals');
    }
}
