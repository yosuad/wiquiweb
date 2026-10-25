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
        'featured_status',
        'featured_order',
        'author_id',
        'views',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    /**
     * Solo puede haber un post destacado por orden (1, 2 o 3).
     * Al guardar uno con featured_status = 'featured', libera
     * automáticamente cualquier otro que ocupara esa misma posición.
     */
    protected static function booted(): void
    {
        static::saving(function (BlogPost $post) {
            if ($post->featured_status !== 'featured') {
                return;
            }

            static::where('id', '!=', $post->id ?? 0)
                ->where('featured_status', 'featured')
                ->where('featured_order', $post->featured_order)
                ->update(['featured_status' => 'none', 'featured_order' => null]);
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
