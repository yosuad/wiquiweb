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

/**
 * Gestión de artículos del blog (panel admin).
 *
 * Reglas de negocio:
 * - Estados: borrador (draft) o publicado (published).
 * - Solo un artículo puede ser el principal (is_featured); el modelo
 *   desmarca el anterior automáticamente al guardar uno nuevo.
 * - La fecha de publicación se asigna al publicar, salvo que se escriba una.
 */
class BlogPostController extends Controller
{
    /*
    |--------------------------------------------------------------------
    | LISTADO
    |--------------------------------------------------------------------
    */

    /**
     * Lista los artículos con filtro por estado y búsqueda por título.
     * El artículo principal siempre aparece primero.
     */
    public function index(Request $request)
    {
        $query = BlogPost::query()
            ->with(['category', 'author'])
            ->orderByDesc('is_featured')
            ->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        $posts = $query->paginate(10)->withQueryString();

        // Contadores para las pestañas de filtro
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

    /**
     * Muestra el formulario de nuevo artículo.
     * $currentFeatured: el artículo principal actual (para el aviso del formulario).
     */
    public function create()
    {
        $categories = BlogCategory::orderBy('name')->get();
        $currentFeatured = BlogPost::where('is_featured', true)->first();

        return view('admin.blog.create', compact('categories', 'currentFeatured'));
    }

    /**
     * Guarda un artículo nuevo.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'alpha_dash', 'max:255', Rule::unique('blog_posts', 'slug')],
            'category_id' => ['required', 'exists:blog_categories,id'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'is_featured' => ['nullable', 'boolean'],
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

        // Subida de imágenes (el nombre del archivo se basa en el slug)
        $data['featured_image'] = $this->storeImage($request, 'featured_image', 'blog/featured', $data['slug']);
        $data['thumbnail_image'] = $this->storeImage($request, 'thumbnail_image', 'blog/thumbnails', $data['slug'].'-thumbnail');

        $data['is_featured'] = $request->boolean('is_featured');
        $data['author_id'] = auth()->id();
        $data['published_at'] = $this->resolvePublishedAt($data['status'], $data['published_at'] ?? null);

        $post = BlogPost::create($data);

        if (! empty($data['tags'])) {
            $post->tags()->sync($this->resolveTagIds($data['tags']));
        }

        return redirect()
            ->route('blog.index')
            ->with('success', 'Artículo creado correctamente.');
    }

    /*
    |--------------------------------------------------------------------
    | EDITAR / ACTUALIZAR
    |--------------------------------------------------------------------
    */

    /**
     * Muestra el formulario de edición.
     * $currentFeatured excluye al propio artículo.
     */
    public function edit(BlogPost $post)
    {
        $categories = BlogCategory::orderBy('name')->get();
        $authors = User::orderBy('name')->get();
        $currentFeatured = BlogPost::where('is_featured', true)
            ->where('id', '!=', $post->id)
            ->first();

        return view('admin.blog.edit', compact('post', 'categories', 'authors', 'currentFeatured'));
    }

    /**
     * Actualiza un artículo existente.
     */
    public function update(Request $request, BlogPost $post)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'alpha_dash', 'max:255', Rule::unique('blog_posts', 'slug')->ignore($post->id)],
            'category_id' => ['required', 'exists:blog_categories,id'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'is_featured' => ['nullable', 'boolean'],
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

        // Slug automático si se dejó vacío: se regenera solo si cambió el título
        if (empty($data['slug'])) {
            $data['slug'] = $post->title !== $data['title']
                ? $this->generateUniqueSlug($data['title'], $post->id)
                : $post->slug;
        }

        // Reemplazo de imágenes (borra la anterior del disco)
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

        // Si no se eligió autor, se conserva el actual
        if (empty($data['author_id'])) {
            unset($data['author_id']);
        }

        $data['is_featured'] = $request->boolean('is_featured');
        $data['published_at'] = $this->resolvePublishedAt(
            $data['status'],
            $data['published_at'] ?? null,
            $post->published_at
        );

        $post->update($data);

        $post->tags()->sync(
            isset($data['tags']) ? $this->resolveTagIds($data['tags']) : []
        );

        return redirect()
            ->route('blog.index')
            ->with('success', 'Artículo actualizado correctamente.');
    }

    /*
    |--------------------------------------------------------------------
    | ELIMINAR
    |--------------------------------------------------------------------
    */

    /**
     * Elimina un artículo y sus imágenes del disco.
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
            ->with('success', 'Artículo eliminado correctamente.');
    }

    /*
    |--------------------------------------------------------------------
    | EDITOR DE CONTENIDO (Quill.js)
    |--------------------------------------------------------------------
    */

    /**
     * Sube una imagen insertada dentro del contenido y devuelve su URL.
     * La llama form.js desde el botón de imagen del editor.
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
     * Si ya existe, agrega -1, -2, etc.
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
}
