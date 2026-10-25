<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Setting;
use Carbon\Carbon;

class PageController extends Controller
{
    // ========= Página de inicio =========
    public function start()
    {
        $proyectos = (int) Setting::get('proyectos_realizados');
        $fechaInicio = Setting::get('fecha_inicio');
        $anos = now()->year - Carbon::parse($fechaInicio)->year;
        $colaborativos = round($proyectos * 1.5);
        $clientes = $proyectos * 20;

        return view('site.start', compact(
            'proyectos',
            'anos',
            'colaborativos',
            'clientes'
        ));
    }

    // ========= Nosotros =========
    public function about()
    {
        $proyectos = (int) Setting::get('proyectos_realizados');
        $fechaInicio = Setting::get('fecha_inicio');
        $anos = now()->year - Carbon::parse($fechaInicio)->year;
        $colaborativos = round($proyectos * 1.5);
        $clientes = $proyectos * 20;

        return view('site.about', compact(
            'proyectos',
            'anos',
            'colaborativos',
            'clientes'
        ));
    }

    // ========= Correos =========
    public function emails()
    {
        return view('site.services.emails');
    }

    // ========= Diseño =========
    public function design()
    {
        return view('site.services.design');
    }

    // ========= Consultoría =========
    public function consulting()
    {
        return view('site.services.consulting');
    }

    // ========= Servicios — Diseño web =========
    public function webDesign()
    {
        return view('site.services.web-design');
    }

    // ========= Servicios — Landing page =========
    public function landing()
    {
        return view('site.services.landing');
    }

    // ========= Demo de Yosuad =========
    public function yosuad()
    {
        return view('site.portfolio.yosuad');
    }

    // ========= Portafolio =========
    public function portfolio()
    {
        return view('site.portfolio.index');
    }

    // ========= Contacto =========
    public function contact()
    {
        return view('site.contact');
    }

    // ========= Blog — listado =========
    public function blog()
    {
        // Destacados para el hero (posiciones 1, 2, 3)
        $featured = BlogPost::published()
            ->where('featured_status', 'featured')
            ->with('category')
            ->orderBy('featured_order')
            ->get()
            ->keyBy('featured_order');

        // Listado paginado (excluye los destacados para no repetirlos)
        $posts = BlogPost::published()
            ->where('featured_status', 'none')
            ->with(['category', 'author'])
            ->orderByDesc('published_at')
            ->paginate(9);

        $categories = BlogCategory::withCount(['posts' => fn ($q) => $q->published()])
            ->having('posts_count', '>', 0)
            ->orderBy('name')
            ->get();

        return view('site.blog.index', compact('featured', 'posts', 'categories'));
    }

    // ========= Blog — artículo =========
    public function blogPost(string $slug)
    {
        $post = BlogPost::published()
            ->where('slug', $slug)
            ->with(['category', 'author', 'tags'])
            ->firstOrFail();

        // Incrementar vistas
        $post->incrementViews();

        // Artículos relacionados: misma categoría, excluyendo el actual
        $related = BlogPost::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->with('category')
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('site.blog.show', compact('post', 'related'));
    }

    // ========= Política de privacidad =========
    public function privacy()
    {
        return view('site.privacy-policy');
    }

    // ========= Formulario leads Meta =========
    public function form()
    {
        return view('leads.form');
    }
}
