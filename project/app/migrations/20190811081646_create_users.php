<?php

use \App\Migrations\Migration;

class CreateUsers extends Migration {

    public function up() {

        if (!$this->schema->hasTable('users')) {
            $this->schema->create('users', function(Illuminate\Database\Schema\Blueprint $table) {
                // Auto-increment id
                $table->increments('id');
                $table->string('email');
                $table->string('password');
                $table->enum('state', ['on', 'off']);
            });
        }
    }

    public function down() {
        $this->schema->dropIfExists('users');
    }

}
