<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOauthAccessTokensTable extends Migration
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
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('OAUTH_ACCESS_TOKENS', function (Blueprint $table) {
            $table->string('ID', 100)->primary();
            $table->unsignedBigInteger('USER_ID')->nullable()->index();
            $table->unsignedBigInteger('CLIENT_ID');
            $table->string('NAME')->nullable();
            $table->text('SCOPES')->nullable();
            $table->boolean('REVOKED');
            $table->timestamp('CREATED_AT')->nullable();
            $table->timestamp('UPDATED_AT')->nullable();
            $table->dateTime('EXPIRES_AT')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('OAUTH_ACCESS_TOKENS');
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
}
