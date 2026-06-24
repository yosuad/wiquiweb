@extends('layouts.app')

@section('title', 'Consultoría Digital — Wiquiweb')

@push('styles')
    @vite('resources/css/pages/services/consulting.css')
@endpush

@section('content')

    <!-- ════════════════ HERO ════════════════ -->
    <section class="consulting-hero">
        <div class="consulting-hero__container">

            <nav class="consulting-hero__breadcrumb" aria-label="Breadcrumb">
                <ol class="consulting-hero__breadcrumb-list">
                    <li class="consulting-hero__breadcrumb-item">
                        <a href="{{ route('home') }}" class="consulting-hero__breadcrumb-link">Inicio</a>
                    </li>
                    <li class="consulting-hero__breadcrumb-item consulting-hero__breadcrumb-item--sep" aria-hidden="true">/</li>
                    <li class="consulting-hero__breadcrumb-item">
                        <a href="#" class="consulting-hero__breadcrumb-link">Servicios</a>
                    </li>
                    <li class="consulting-hero__breadcrumb-item consulting-hero__breadcrumb-item--sep" aria-hidden="true">/</li>
                    <li class="consulting-hero__breadcrumb-item consulting-hero__breadcrumb-item--active" aria-current="page">
                        Consultoría Digital
                    </li>
                </ol>
            </nav>

            <div class="consulting-hero__badge">
                <i data-lucide="lightbulb" aria-hidden="true"></i>
                <span>Consultoría Digital</span>
            </div>

            <h1 class="consulting-hero__title">
                Claridad digital para <span class="consulting-hero__title-highlight">hacer crecer tu negocio</span>
            </h1>

            <p class="consulting-hero__description">
                Antes de invertir en tecnología, necesitas saber exactamente qué necesitas y por qué.
                Te ayudamos a entender tus procesos, identificar oportunidades y trazar el camino correcto.
            </p>

            <div class="consulting-hero__actions">
                <a href="{{ route('contact') }}" class="btn btn--primary">
                    <i data-lucide="calendar" aria-hidden="true"></i>
                    Agendar sesión
                </a>
                <a href="#para-quien" class="btn btn--outline-light">
                    <i data-lucide="arrow-down" aria-hidden="true"></i>
                    ¿Para quién es?
                </a>
            </div>

        </div>
    </section>

    <!-- ════════════════ PARA QUIÉN ES ════════════════ -->
    <section id="para-quien" class="consulting-for">
        <div class="consulting-for__container">

            <div class="consulting-for__header">
                <p class="consulting-for__subtitle">¿Es para ti?</p>
                <h2 class="consulting-for__title">
                    Diseñada para empresas que <span class="consulting-for__title-highlight">quieren avanzar</span>
                </h2>
                <p class="consulting-for__description">
                    Si te identificas con alguna de estas situaciones, la consultoría es el primer paso que necesitas.
                </p>
            </div>

            <div class="consulting-for__grid">

                <div class="consulting-for-card">
                    <div class="consulting-for-card__icon"><i data-lucide="help-circle" aria-hidden="true"></i></div>
                    <h3 class="consulting-for-card__title">No sabes por dónde empezar</h3>
                    <p class="consulting-for-card__text">Sabes que necesitas digitalizarte pero no tienes claro qué herramienta necesitas, cuánto cuesta o qué viene primero.</p>
                </div>

                <div class="consulting-for-card">
                    <div class="consulting-for-card__icon"><i data-lucide="git-branch" aria-hidden="true"></i></div>
                    <h3 class="consulting-for-card__title">Tus procesos no están claros</h3>
                    <p class="consulting-for-card__text">No tienes documentados los flujos de tu empresa — quién hace qué, cuándo y cómo. Eso hace imposible automatizar o delegar correctamente.</p>
                </div>

                <div class="consulting-for-card">
                    <div class="consulting-for-card__icon"><i data-lucide="trending-up" aria-hidden="true"></i></div>
                    <h3 class="consulting-for-card__title">Quieres crecer pero algo frena</h3>
                    <p class="consulting-for-card__text">Tu negocio funciona pero sientes que podrías escalar más rápido si tuvieras la tecnología y los procesos correctos.</p>
                </div>

                <div class="consulting-for-card">
                    <div class="consulting-for-card__icon"><i data-lucide="database" aria-hidden="true"></i></div>
                    <h3 class="consulting-for-card__title">Necesitas un CRM o ERP</h3>
                    <p class="consulting-for-card__text">Antes de implementar un sistema, necesitas tener claros tus procesos. Te ayudamos a mapearlo todo para que la implementación sea exitosa.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ════════════════ QUÉ INCLUYE ════════════════ -->
    <section class="consulting-includes">
        <div class="consulting-includes__container">

            <div class="consulting-includes__header">
                <p class="consulting-includes__subtitle">¿Qué obtienes?</p>
                <h2 class="consulting-includes__title">
                    Una hoja de ruta <span class="consulting-includes__title-highlight">clara y accionable</span>
                </h2>
                <p class="consulting-includes__description">
                    Cada sesión tiene un objetivo concreto. No reuniones sin propósito — cada minuto cuenta.
                </p>
            </div>

            <div class="consulting-includes__list">

                <div class="consulting-item">
                    <div class="consulting-item__number">01</div>
                    <div class="consulting-item__body">
                        <h3 class="consulting-item__title">Diagnóstico de tu situación actual</h3>
                        <p class="consulting-item__text">Analizamos dónde estás, qué herramientas usas, qué problemas tienes y qué oportunidades estás dejando pasar.</p>
                    </div>
                </div>

                <div class="consulting-item">
                    <div class="consulting-item__number">02</div>
                    <div class="consulting-item__body">
                        <h3 class="consulting-item__title">Diagrama de flujo de procesos</h3>
                        <p class="consulting-item__text">Mapeamos visualmente cómo funciona tu empresa — desde que llega un cliente hasta que se cierra el proceso. Claridad total sobre quién hace qué y cuándo.</p>
                    </div>
                </div>

                <div class="consulting-item">
                    <div class="consulting-item__number">03</div>
                    <div class="consulting-item__body">
                        <h3 class="consulting-item__title">Hoja de ruta digital</h3>
                        <p class="consulting-item__text">Te entregamos un plan de acción concreto con los pasos a seguir, las herramientas recomendadas y el orden correcto para implementarlas.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ════════════════ PROCESO ════════════════ -->
    <section class="consulting-process">
        <div class="consulting-process__container">

            <div class="consulting-process__header">
                <p class="consulting-process__subtitle">Cómo funciona</p>
                <h2 class="consulting-process__title">
                    Simple, directo y <span class="consulting-process__title-highlight">orientado a resultados</span>
                </h2>
            </div>

            <div class="consulting-process__steps">

                <div class="consulting-step">
                    <div class="consulting-step__number">01</div>
                    <div class="consulting-step__icon"><i data-lucide="calendar" aria-hidden="true"></i></div>
                    <h3 class="consulting-step__title">Agendas tu sesión</h3>
                    <p class="consulting-step__text">Llenas el formulario de contacto y coordenamos una sesión de máximo 45 minutos.</p>
                </div>

                <div class="consulting-step__connector" aria-hidden="true"></div>

                <div class="consulting-step">
                    <div class="consulting-step__number">02</div>
                    <div class="consulting-step__icon"><i data-lucide="video" aria-hidden="true"></i></div>
                    <h3 class="consulting-step__title">Sesión de consultoría</h3>
                    <p class="consulting-step__text">Nos reunimos virtualmente. Escuchamos, analizamos y te damos claridad sobre tu situación.</p>
                </div>

                <div class="consulting-step__connector" aria-hidden="true"></div>

                <div class="consulting-step">
                    <div class="consulting-step__number">03</div>
                    <div class="consulting-step__icon"><i data-lucide="file-check" aria-hidden="true"></i></div>
                    <h3 class="consulting-step__title">Recibes tu plan</h3>
                    <p class="consulting-step__text">Te entregamos un documento con los hallazgos, diagramas y pasos concretos a seguir.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ════════════════ CTA ════════════════ -->
    <section class="consulting-cta">
        <div class="consulting-cta__container">
            <p class="consulting-cta__subtitle">¿Listo para tener claridad?</p>
            <h2 class="consulting-cta__title">El primer paso es una conversación</h2>
            <p class="consulting-cta__description">
                Cuéntanos dónde estás y hacia dónde quieres ir. Nosotros te ayudamos a trazar el camino.
            </p>
            <a href="{{ route('contact') }}" class="btn btn--primary">
                <i data-lucide="calendar" aria-hidden="true"></i>
                Agendar sesión
            </a>
        </div>
    </section>

@endsection