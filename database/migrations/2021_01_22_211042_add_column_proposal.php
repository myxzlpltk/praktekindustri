<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnProposal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
			Schema::table('proposals', function (Blueprint $table) {
				$table->text('alasanKoor')->nullable();
				$table->text('alasanKajur')->nullable();
			});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
			Schema::table('proposals', function (Blueprint $table) {
					$table->dropColumn('alasanKoor', 'alasanKajur');
			});
    }
}