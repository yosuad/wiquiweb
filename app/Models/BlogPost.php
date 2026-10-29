<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BlogPost extends Model
{
    protected $table = 'blog_posts';

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'featured_image',
        'thumbnail_image',
        'excerpt',
        'content',
        'status',
        'is_featured',
        'author_id',
        'views',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Solo puede haber un post destacado (el banner del blog).
     * Al guardar uno como destacado, se desmarca automáticamente el anterior.
     */
    protected static function booted(): void
    {
        static::saving(function (BlogPost $post) {
            if (! $post->is_featured) {
                return;
            }

            static::where('id', '!=', $post->id ?? 0)
                ->where('is_featured', true)
                ->update(['is_featured' => false]);
        });
    }

    // ── Scopes ──────────────────────────────────────────────────────────

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    // ── Métodos ─────────────────────────────────────────────────────────

    public function incrementViews(): void
    {
        $this->increment('views');
    }

    // ── Relaciones ───────────────────────────────────────────────────────

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tag', 'post_id', 'tag_id');
    }
}
