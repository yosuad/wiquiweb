<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogPostController extends Controller
{
    /*
    |--------------------------------------------------------------------
    | LISTADO
    |--------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = BlogPost::query()
            ->with(['category', 'author'])
            ->orderByRaw("
                CASE
                    WHEN featured_status = 'featured' THEN featured_order
                    ELSE 99
                END
            ")
            ->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        $posts = $query->paginate(10)->withQueryString();

        $counts = [
            'all' => BlogPost::count(),
            'published' => BlogPost::where('status', 'published')->count(),
            'draft' => BlogPost::where('status', 'draft')->count(),
        ];

        return view('admin.blog.index', compact('posts', 'counts'));
    }

    /*
    |--------------------------------------------------------------------
    | CREAR
    |--------------------------------------------------------------------
    */

    public function create()
    {
        $categories = BlogCategory::orderBy('name')->get();
        $slots = $this->getFeaturedSlots();

        return view('admin.blog.create', compact('categories', 'slots'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'alpha_dash', 'max:255', Rule::unique('blog_posts', 'slug')],
            'category_id' => ['required', 'exists:blog_categories,id'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'featured_status' => ['required', 'in:none,featured_1,featured_2,featured_3'],
            'published_at' => ['nullable', 'date'],
            'featured_image' => ['required', 'image', 'max:2048'],
            'thumbnail_image' => ['required', 'image', 'max:2048'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
        ], [
            'slug.alpha_dash' => 'El slug solo puede tener letras, números, guiones (-) y guiones bajos (_), sin espacios ni tildes.',
            'slug.unique' => 'Ese slug ya está en uso por otro artículo. Prueba con uno distinto.',
        ]);

        // Slug automático si no se escribió
        if (empty($data['slug'])) {
            $data['slug'] = $this->generateUniqueSlug($data['title']);
        }

        // Subida de imágenes
        $data['featured_image'] = $this->storeImage($request, 'featured_image', 'blog/featured', $data['slug']);
        $data['thumbnail_image'] = $this->storeImage($request, 'thumbnail_image', 'blog/thumbnails', $data['slug'].'-thumbnail');

        $data['author_id'] = auth()->id();
        $data['published_at'] = $this->resolvePublishedAt($data['status'], $data['published_at'] ?? null);

        [$data['featured_status'], $data['featured_order']] = $this->resolveFeaturedSlot(
            $data['featured_status']
        );

        $post = BlogPost::create($data);

        if (! empty($data['tags'])) {
            $post->tags()->sync($this->resolveTagIds($data['tags']));
        }

        return redirect()
            ->route('blog.index')
            ->with('status', 'Artículo creado correctamente.');
    }

    /*
    |--------------------------------------------------------------------
    | EDITAR / ACTUALIZAR
    |--------------------------------------------------------------------
    */

    public function edit(BlogPost $post)
    {
        $categories = BlogCategory::orderBy('name')->get();
        $slots = $this->getFeaturedSlots($post->id);
        $authors = User::orderBy('name')->get();

        return view('admin.blog.edit', compact('post', 'categories', 'slots', 'authors'));
    }

    public function update(Request $request, BlogPost $post)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'alpha_dash', 'max:255', Rule::unique('blog_posts', 'slug')->ignore($post->id)],
            'category_id' => ['required', 'exists:blog_categories,id'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'featured_status' => ['required', 'in:none,featured_1,featured_2,featured_3'],
            'author_id' => ['nullable', 'exists:users,id'],
            'published_at' => ['nullable', 'date'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
            'thumbnail_image' => ['nullable', 'image', 'max:2048'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
        ], [
            'slug.alpha_dash' => 'El slug solo puede tener letras, números, guiones (-) y guiones bajos (_), sin espacios ni tildes.',
            'slug.unique' => 'Ese slug ya está en uso por otro artículo. Prueba con uno distinto.',
        ]);

        // Slug automático si se dejó vacío y el título cambió
        if (empty($data['slug'])) {
            $data['slug'] = $post->title !== $data['title']
                ? $this->generateUniqueSlug($data['title'], $post->id)
                : $post->slug;
        }

        // Reemplazo de imágenes (borra la anterior)
        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('uploads')->delete($post->featured_image);
            }
            $data['featured_image'] = $this->storeImage($request, 'featured_image', 'blog/featured', $data['slug']);
        }

        if ($request->hasFile('thumbnail_image')) {
            if ($post->thumbnail_image) {
                Storage::disk('uploads')->delete($post->thumbnail_image);
            }
            $data['thumbnail_image'] = $this->storeImage($request, 'thumbnail_image', 'blog/thumbnails', $data['slug'].'-thumbnail');
        }

        if (empty($data['author_id'])) {
            unset($data['author_id']);
        }

        $data['published_at'] = $this->resolvePublishedAt(
            $data['status'],
            $data['published_at'] ?? null,
            $post->published_at
        );

        [$data['featured_status'], $data['featured_order']] = $this->resolveFeaturedSlot(
            $data['featured_status'],
            $post->id
        );

        $post->update($data);

        $post->tags()->sync(
            isset($data['tags']) ? $this->resolveTagIds($data['tags']) : []
        );

        return redirect()
            ->route('blog.index')
            ->with('status', 'Artículo actualizado correctamente.');
    }

    /*
    |--------------------------------------------------------------------
    | ELIMINAR
    |--------------------------------------------------------------------
    */

    public function destroy(BlogPost $post)
    {
        if ($post->featured_image) {
            Storage::disk('uploads')->delete($post->featured_image);
        }

        if ($post->thumbnail_image) {
            Storage::disk('uploads')->delete($post->thumbnail_image);
        }

        $post->delete();

        return redirect()
            ->route('blog.index')
            ->with('status', 'Artículo eliminado correctamente.');
    }

    /*
    |--------------------------------------------------------------------
    | EDITOR DE CONTENIDO (Quill.js)
    |--------------------------------------------------------------------
    */

    public function uploadContentImage(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'max:4096'],
        ]);

        $path = $request->file('image')->store('blog/content', 'uploads');

        return response()->json([
            'url' => asset('uploads/'.$path),
        ]);
    }

    /*
    |--------------------------------------------------------------------
    | HELPERS PRIVADOS
    |--------------------------------------------------------------------
    */

    /**
     * Genera un slug único a partir del título.
     */
    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (
            BlogPost::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Guarda una imagen en el disco "uploads" con un nombre basado en el slug.
     */
    private function storeImage(Request $request, string $field, string $folder, string $filename): string
    {
        $file = $request->file($field);

        return $file->storeAs($folder, $filename.'.'.$file->getClientOriginalExtension(), 'uploads');
    }

    /**
     * Fecha de publicación:
     * - Si se escribió una fecha, se respeta.
     * - Si ya tenía fecha, se conserva.
     * - Si se publica sin fecha, se usa la fecha actual.
     * - Si es borrador sin fecha, queda vacía.
     */
    private function resolvePublishedAt(string $status, ?string $input, $current = null)
    {
        if (! empty($input)) {
            return $input;
        }

        if ($current) {
            return $current;
        }

        return $status === 'published' ? now() : null;
    }

    /**
     * Convierte nombres de etiquetas en IDs, creando las que no existan.
     */
    private function resolveTagIds(array $names): array
    {
        return collect($names)->map(function ($name) {
            return BlogTag::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            )->id;
        })->all();
    }

    /**
     * Devuelve qué post ocupa cada una de las 3 posiciones destacadas.
     */
    private function getFeaturedSlots(?int $excludeId = null): array
    {
        $featured = BlogPost::query()
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->where('featured_status', 'featured')
            ->orderBy('featured_order')
            ->get()
            ->keyBy('featured_order');

        return [
            'featured_1' => $featured->get(1),
            'featured_2' => $featured->get(2),
            'featured_3' => $featured->get(3),
        ];
    }

    /**
     * Convierte el valor del formulario en estado + orden.
     * $value puede ser: none | featured_1 | featured_2 | featured_3
     * Si la posición está ocupada, el modelo libera al anterior al guardar.
     */
    private function resolveFeaturedSlot(string $value, ?int $postId = null): array
    {
        if ($value === 'none') {
            return ['none', null];
        }

        return ['featured', (int) str_replace('featured_', '', $value)];
    }
}
