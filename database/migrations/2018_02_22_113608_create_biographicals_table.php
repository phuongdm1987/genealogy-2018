<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBiographicalsTable
 */
class CreateBiographicalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biographical', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('person_id');
            $table->string('birth_place')->nullable();
            $table->string('company')->nullable();
            $table->string('career')->nullable();
            $table->string('school')->nullable();
            $table->string('subject')->nullable();
            $table->string('degree')->nullable();
            $table->text('hobbies')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('biographical');
    }
}
