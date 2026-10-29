<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Páginas públicas del sitio (inicio, nosotros, servicios, portafolio,
 * blog, contacto y privacidad).
 */
class PageController extends Controller
{
    /*
    |--------------------------------------------------------------------
    | INICIO Y NOSOTROS
    |--------------------------------------------------------------------
    */

    /**
     * Página de inicio, con las cifras de la empresa.
     */
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

    /**
     * Página "Nosotros", con las mismas cifras que el inicio.
     */
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

    /*
    |--------------------------------------------------------------------
    | SERVICIOS
    |--------------------------------------------------------------------
    */

    public function emails()
    {
        return view('site.services.emails');
    }

    public function design()
    {
        return view('site.services.design');
    }

    public function consulting()
    {
        return view('site.services.consulting');
    }

    public function webDesign()
    {
        return view('site.services.web-design');
    }

    public function landing()
    {
        return view('site.services.landing');
    }

    /*
    |--------------------------------------------------------------------
    | PORTAFOLIO Y CONTACTO
    |--------------------------------------------------------------------
    */

    public function portfolio()
    {
        return view('site.portfolio.index');
    }

    public function yosuad()
    {
        return view('site.portfolio.yosuad');
    }

    public function contact()
    {
        return view('site.contact');
    }

    /*
    |--------------------------------------------------------------------
    | BLOG
    |--------------------------------------------------------------------
    */

    /**
     * Listado público del blog.
     *
     * - Sin filtro: muestra el artículo principal en el banner y el resto en la grilla.
     * - Con filtro (?categoria=slug): muestra solo esa categoría, sin banner.
     */
    public function blog(Request $request)
    {
        // Categoría seleccionada en los filtros (null = "Todos")
        $activeCategory = $request->filled('categoria')
            ? BlogCategory::where('slug', $request->categoria)->first()
            : null;

        // Artículo principal: solo en la vista "Todos"
        $featured = $activeCategory
            ? null
            : BlogPost::published()
                ->where('is_featured', true)
                ->with(['category', 'author'])
                ->first();

        // Grilla paginada (excluye el principal para no repetirlo)
        $posts = BlogPost::published()
            ->when($featured, fn ($q) => $q->where('id', '!=', $featured->id))
            ->when($activeCategory, fn ($q) => $q->where('category_id', $activeCategory->id))
            ->with(['category', 'author'])
            ->orderByDesc('published_at')
            ->paginate(9)
            ->withQueryString();

        // Categorías para los filtros: solo las que tienen artículos publicados
        $categories = BlogCategory::withCount(['posts' => fn ($q) => $q->published()])
            ->having('posts_count', '>', 0)
            ->orderBy('name')
            ->get();

        return view('site.blog.index', compact('featured', 'posts', 'categories', 'activeCategory'));
    }

    /**
     * Artículo individual del blog.
     */
    public function blogPost(Request $request, string $slug)
    {
        $post = BlogPost::published()
            ->where('slug', $slug)
            ->with(['category', 'author', 'tags'])
            ->firstOrFail();

        // Vista "consciente": solo suma si cumple las reglas (ver countView)
        $this->countView($request, $post);

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

    /**
     * Suma una vista al artículo solo si es una visita real:
     *
     * 1. No cuenta si hay un usuario logueado (revisiones propias del panel).
     * 2. No cuenta robots de buscadores ni previsualizaciones de redes.
     * 3. Una vista por visitante por artículo cada 24 horas.
     *    El visitante se identifica por IP + navegador, guardados cifrados
     *    (hash) en caché; el registro se borra solo a las 24 horas.
     */
    private function countView(Request $request, BlogPost $post): void
    {
        // Regla 1: usuarios logueados
        if (auth()->check()) {
            return;
        }

        // Regla 2: robots y previsualizaciones
        $userAgent = (string) $request->userAgent();
        if ($userAgent === '' || preg_match('/bot|crawl|spider|slurp|facebookexternalhit|whatsapp|preview/i', $userAgent)) {
            return;
        }

        // Regla 3: una vez cada 24 horas por visitante
        $visitor = hash('sha256', $request->ip().'|'.$userAgent);
        $key = "blog_view:{$post->id}:{$visitor}";

        // Cache::add solo guarda si la clave NO existe; devuelve true la primera vez
        if (Cache::add($key, true, now()->addDay())) {
            $post->incrementViews();
        }
    }

    /*
    |--------------------------------------------------------------------
    | LEGALES Y FORMULARIOS
    |--------------------------------------------------------------------
    */

    public function privacy()
    {
        return view('site.privacy-policy');
    }

    /**
     * Formulario de leads para campañas de Meta.
     */
    public function form()
    {
        return view('leads.form');
    }
}
