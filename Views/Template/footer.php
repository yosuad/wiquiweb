<!-- START PRELOAD -->
<script>
    // Cargar la animación usando la biblioteca Lottie
    var animation = lottie.loadAnimation({
        // Definir el contenedor donde se mostrará la animación
        container: document.getElementById('animacion-container'),
        // Usar SVG como el renderizador para la animación
        renderer: 'svg',
        // Configurar la animación para que se repita indefinidamente
        loop: true,
        // No comenzar la animación automáticamente al cargar
        autoplay: false,
        // Definir la ruta al archivo JSON que contiene la animación
        path: '<?= base_url(); ?>/Assets/img/loader.json',
    });

    // Esta función se ejecutará cuando la página se haya cargado completamente
    window.onload = function() {
        // Establecer la animación en el fotograma 20 de la animación al cargar
        animation.goToAndStop(20, true);

        // Establecer un retraso de tiempo antes de continuar con la animación y ocultar el preloader
        setTimeout(function() {
            // Reproducir la animación después del retraso
            animation.play();

            // Ocultar el preloader después de 1 minuto
            preloader.style.display = 'none';
        });
    };
</script>
<!-- END PRELOAD -->
</body>

</html>