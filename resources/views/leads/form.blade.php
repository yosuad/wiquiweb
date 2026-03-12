<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Agencia especializada en diseño y desarrollo de páginas web, actualizaciones y diseño para ayudar a tu empresa a destacar. Contáctanos para crear una presencia digital única y efectiva." />
    <meta name="author" content="wiquiweb" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>wiquiweb | @yield('title', 'Inicio')</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/lottie.min.js') }}"></script>
</head>

<body>

    {{-- PRELOADER --}}
    <div class="preloader" id="preloader">
        <div id="preloader__animation" style="width: 150px; height: 150px;"></div>
    </div>

    {{-- CONTENT --}}

    
  <!-- Burbujas decorativas -->
  <div class="bubble bubble--1"></div>
  <div class="bubble bubble--2"></div>
  <div class="bubble bubble--3"></div>

  <div class="contact-wrapper">

    <!-- Header -->
    <div class="contact-header">
      <a href="/" class="contact-header__back">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
        Volver al inicio
      </a>
      <h1 class="contact-header__title">
        <span class="wiqui-gradient-text">Contáctanos</span>
      </h1>
      <p class="contact-header__subtitle">Déjanos tus datos y te contactaremos a la brevedad</p>
    </div>

    <!-- Formulario -->
    <form class="contact-form" id="contactForm" onsubmit="return handleSubmit(event)">

      <!-- Nombre y Apellido -->
      <div class="form-row">
        <div class="form-group">
          <label for="nombre" class="form-label">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Nombre
          </label>
          <input type="text" id="nombre" name="nombre" class="form-input" placeholder="Tu nombre" maxlength="50" required>
          <span class="form-error" id="error-nombre"></span>
        </div>

        <div class="form-group">
          <label for="apellido" class="form-label">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--secondary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Apellido
          </label>
          <input type="text" id="apellido" name="apellido" class="form-input" placeholder="Tu apellido" maxlength="50" required>
          <span class="form-error" id="error-apellido"></span>
        </div>
      </div>

      <!-- Teléfono -->
      <div class="form-group">
        <label for="telefono" class="form-label">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
          Teléfono
        </label>
        <input type="tel" id="telefono" name="telefono" class="form-input" placeholder="+52 55 1234 5678" maxlength="20" required>
        <span class="form-error" id="error-telefono"></span>
      </div>

      <!-- Servicio de interés -->
      <div class="form-group">
        <label for="servicio" class="form-label">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
          Servicio de interés
        </label>
        <select id="servicio" name="servicio" class="form-input form-select" required>
          <option value="" disabled selected>Selecciona un servicio</option>
          <option value="diseno-web">Diseño Web</option>
          <option value="desarrollo-software">Desarrollo de Software</option>
          <option value="marketing-digital">Marketing Digital</option>
          <option value="seo">SEO &amp; Posicionamiento</option>
          <option value="ecommerce">E-Commerce</option>
          <option value="consultoria">Consultoría TI</option>
          <option value="soporte">Soporte Técnico</option>
          <option value="hosting">Hosting &amp; Dominios</option>
        </select>
        <span class="form-error" id="error-servicio"></span>
      </div>

      <!-- Correo electrónico -->
      <div class="form-group">
        <label for="correo" class="form-label">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--secondary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
          Correo electrónico
        </label>
        <input type="email" id="correo" name="correo" class="form-input" placeholder="tu@correo.com" maxlength="100" required>
        <span class="form-error" id="error-correo"></span>
      </div>

      <!-- Botón enviar -->
      <button type="submit" class="form-submit" id="submitBtn">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4z"/><path d="M22 2 11 13"/></svg>
        Enviar solicitud
      </button>
    </form>

  </div>

  <script>
    function handleSubmit(e) {
      e.preventDefault();
      let valid = true;

      // Reset errors
      document.querySelectorAll('.form-error').forEach(el => el.textContent = '');
      document.querySelectorAll('.form-input').forEach(el => el.classList.remove('form-input--error'));

      const nombre = document.getElementById('nombre');
      const apellido = document.getElementById('apellido');
      const telefono = document.getElementById('telefono');
      const servicio = document.getElementById('servicio');
      const correo = document.getElementById('correo');

      if (!nombre.value.trim()) {
        showError('nombre', 'El nombre es obligatorio');
        valid = false;
      }
      if (!apellido.value.trim()) {
        showError('apellido', 'El apellido es obligatorio');
        valid = false;
      }
      if (!telefono.value.trim()) {
        showError('telefono', 'El teléfono es obligatorio');
        valid = false;
      } else if (!/^[\d\s\+\-()]{7,20}$/.test(telefono.value)) {
        showError('telefono', 'Teléfono inválido');
        valid = false;
      }
      if (!servicio.value) {
        showError('servicio', 'Selecciona un servicio');
        valid = false;
      }
      if (!correo.value.trim()) {
        showError('correo', 'El correo es obligatorio');
        valid = false;
      } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo.value)) {
        showError('correo', 'Correo inválido');
        valid = false;
      }

      if (valid) {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="pulse">Enviando...</span>';

        setTimeout(() => {
          alert('¡Formulario enviado! Nos pondremos en contacto contigo pronto.');
          document.getElementById('contactForm').reset();
          btn.disabled = false;
          btn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4z"/><path d="M22 2 11 13"/></svg> Enviar solicitud';
        }, 1200);
      }

      return false;
    }

    function showError(field, message) {
      document.getElementById('error-' + field).textContent = message;
      document.getElementById(field).classList.add('form-input--error');
    }
  </script>

    
    



    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')

</body>

</html>
