<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Carbon\Carbon;

class PageController extends Controller
{
    // ========= Página de inicio =========
    public function start()
    {
        $proyectos     = (int) Setting::get('proyectos_realizados', 11);
        $fechaInicio   = Setting::get('fecha_inicio', '2021-12-02');
        $anos          = now()->year - Carbon::parse($fechaInicio)->year;
        $colaborativos = round($proyectos * 1.5);
        $clientes      = $proyectos * 20;

        return view('pages.start', compact(
            'proyectos',
            'anos',
            'colaborativos',
            'clientes'
        ));
    }

    // ========= Servicios — Diseño web =========
    public function webDesign()
    {
        return view('pages.services.web-design');
    }

    // ========= Política de privacidad =========
    public function privacy()
    {
        return view('pages.privacyPolicy');
    }

    // ========= Formulario leads Meta =========
    public function form()
    {
        return view('leads.form');
    }
}