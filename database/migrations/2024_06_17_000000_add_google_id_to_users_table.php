<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddGoogleIdToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('googleID')->nullable()->unique()->after('email');
        });

        // Jadikan password nullable tanpa doctrine/dbal (only for MySQL)
        if (DB::connection()->getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE users MODIFY password VARCHAR(255) NULL');
        }
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('googleID');
        });

        if (DB::connection()->getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE users MODIFY password VARCHAR(255) NOT NULL');
        }
    }
}
