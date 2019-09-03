<?php

use Illuminate\Database\Migrations\Migration;

class ImportOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // import options
        $options = config('options');

        foreach ($options as $key => $value) {
            Option::set($key, $value);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('options')->delete();
    }
}
