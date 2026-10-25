<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::withCount('posts')->orderBy('name')->get();

        return view('admin.blog.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'alpha_dash', 'max:255', Rule::unique(BlogCategory::class, 'slug')],
        ], [
            'slug.alpha_dash' => 'El slug solo puede tener letras, números, guiones (-) y guiones bajos (_), sin espacios ni tildes.',
            'slug.unique' => 'Ya existe una categoría con ese slug.',
        ]);

        $data['slug'] = ! empty($data['slug']) ? $data['slug'] : Str::slug($data['name']);

        // La primera categoría que se crea queda como predeterminada automáticamente
        $data['is_default'] = ! BlogCategory::exists();

        BlogCategory::create($data);

        return redirect()
            ->route('blog.categories.index')
            ->with('status', 'Categoría creada correctamente.');
    }

    public function update(Request $request, BlogCategory $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $category->update($data);

        return redirect()
            ->route('blog.categories.index')
            ->with('status', 'Categoría actualizada correctamente.');
    }

    public function destroy(BlogCategory $category)
    {
        if ($category->is_default) {
            return back()->with('error', 'No puedes eliminar la categoría predeterminada. Marca otra como predeterminada primero.');
        }

        $default = BlogCategory::where('is_default', true)->first();

        // Sin predeterminada, el cascade borraría los artículos: se bloquea
        if (! $default && $category->posts()->exists()) {
            return back()->with('error', 'Esta categoría tiene artículos y no hay una categoría predeterminada a donde moverlos. Marca una como predeterminada primero.');
        }

        DB::transaction(function () use ($category, $default) {
            // Mover sus artículos a la predeterminada antes de eliminar
            if ($default) {
                $category->posts()->update(['category_id' => $default->id]);
            }

            $category->delete();
        });

        return redirect()
            ->route('blog.categories.index')
            ->with('status', 'Categoría eliminada correctamente.');
    }

    public function setDefault(BlogCategory $category)
    {
        DB::transaction(function () use ($category) {
            BlogCategory::where('id', '!=', $category->id)->update(['is_default' => false]);
            $category->update(['is_default' => true]);
        });

        return back()->with('status', 'Categoría marcada como predeterminada.');
    }
}
