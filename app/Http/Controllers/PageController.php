<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Carbon\Carbon;

class PageController extends Controller
{
    // ========= Página de inicio =========
    public function start()
    {
        $proyectos     = (int) Setting::get('proyectos_realizados');
        $fechaInicio   = Setting::get('fecha_inicio');
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

    // ========= nosotros =========
    public function nosotros()
    {
        $proyectos     = (int) Setting::get('proyectos_realizados');
        $fechaInicio   = Setting::get('fecha_inicio');
        $anos          = now()->year - Carbon::parse($fechaInicio)->year;
        $colaborativos = round($proyectos * 1.5);
        $clientes      = $proyectos * 20;

        return view('pages.nosotros', compact(
            'proyectos',
            'anos',
            'colaborativos',
            'clientes'
        ));
    }


    // ========= Correos =========
    public function emails()
    {
        return view('pages.services.emails');
    }

     // ========= Diseño =========
        public function design()
    {
        return view('pages.services.design');
    }

     // ========= Consultoría =========
        public function consulting()
    {
        return view('pages.services.consulting');
    }
    // ========= Servicios — Diseño web =========
    public function webDesign()
    {
        return view('pages.services.web-design');
    }
        
    // ========= pagina de contacto =========
        public function portfolio()
    {
        return view('pages.portfolio');
    }

    // ========= pagina de contacto =========
    public function contact()
    {
        return view('pages.contact');
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
