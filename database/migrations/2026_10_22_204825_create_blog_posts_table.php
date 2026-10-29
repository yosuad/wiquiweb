<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();

            $table->foreignId('category_id')
                ->constrained('blog_categories')
                ->cascadeOnDelete();

            $table->string('featured_image')->nullable();
            $table->string('thumbnail_image')->nullable();

            $table->text('excerpt')->nullable();
            $table->longText('content');

            $table->enum('status', ['draft', 'published'])
                ->default('draft');

            $table->boolean('is_featured')->default(false);

            $table->foreignId('author_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->unsignedInteger('views')->default(0);

            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
