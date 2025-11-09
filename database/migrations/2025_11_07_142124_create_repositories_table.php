<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('repositories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('github_id')->unique()->index();
            $table->string('name');
            $table->boolean('private')->default(false);
            $table->text('description')->nullable();
            $table->string('html_url');
            $table->string('default_branch')->nullable();
            $table->bigInteger('branch_count')->default(0);
            $table->bigInteger('pulls_count')->default(0);
            $table->string('language')->default('Markdown');
            $table->timestamp('last_pushed_at')->nullable();
            $table->timestamp('last_synced_at')->nullable();
            $table->bigInteger('size')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repositories');
    }
};
