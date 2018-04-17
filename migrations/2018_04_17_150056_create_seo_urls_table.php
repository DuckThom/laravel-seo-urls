<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Create seo_urls table.
 *
 * @package     Luna\SeoUrls
 * @author      Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class CreateSeoUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_urls', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_redirect')->default(false);
            $table->string('http_code', 3)->nullable();
            $table->string('source_path');
            $table->string('target_path');
            $table->integer('hits')->default(0);
            $table->timestamp('last_used')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seo_urls');
    }
}
