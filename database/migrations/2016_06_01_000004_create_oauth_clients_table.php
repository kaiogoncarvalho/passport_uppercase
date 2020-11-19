<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOauthClientsTable extends Migration
{
    /**
     * The database schema.
     *
     * @var \Illuminate\Database\Schema\Builder
     */
    protected $schema;

    /**
     * Create a new migration instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->schema = Schema::connection($this->getConnection());
    }

    /**
     * Get the migration connection name.
     *
     * @return string|null
     */
    public function getConnection()
    {
        return config('passport.storage.database.connection');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('OAUTH_CLIENTS', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->unsignedBigInteger('USER_ID')->nullable()->index();
            $table->string('NAME');
            $table->string('SECRET', 100)->nullable();
            $table->string('PROVIDER')->nullable();
            $table->text('REDIRECT');
            $table->boolean('PERSONAL_ACCESS_CLIENT');
            $table->boolean('PASSWORD_CLIENT');
            $table->boolean('REVOKED');
            $table->timestamp('CREATED_AT')->nullable();
            $table->timestamp('UPDATED_AT')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('OAUTH_CLIENTS');
    }
}
