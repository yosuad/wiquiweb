<!DOCTYPE html>
<html lang="es">

<head>
	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<!-- SITE TITLE -->
	<title><?php echo $data['page_tag']; ?></title>
	<!-- Latest Bootstrap min CSS -->
	<link rel="stylesheet" href="Assets/bootstrap/css/bootstrap.min.css">
	<!-- Google Font -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Rubik:wght@400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- Icon CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>/Assets/fonts/themify-icons.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="<?= base_url(); ?>Assets/css/line-awesome.css">
	<link rel="stylesheet" href="<?= base_url(); ?>Assets/fonts/fontawesome/fontawesome.css">
	<!--- owl carousel Css-->
	<link rel="stylesheet" href="<?= base_url(); ?>Assets/owlcarousel/css/owl.carousel.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>Assets/owlcarousel/css/owl.theme.default.min.css">
	<!--jquery-simple-mobilemenu Css-->
	<link rel="stylesheet" href="<?= base_url(); ?>Assets/css/jquery-simple-mobilemenu.css">
	<!--magnific-popup Css-->
	<link rel="stylesheet" href="<?= base_url(); ?>Assets/css/magnific-popup.css">
	<!--animate Css-->
	<link rel="stylesheet" href="<?= base_url(); ?>Assets/css/animate.css">
	<!--YouTubePopUp Css-->
	<link rel="stylesheet" href="<?= base_url(); ?>Assets/css/YouTubePopUp.css">
	<!--Slick Css-->
	<link rel="stylesheet" href="<?= base_url(); ?>Assets/css/slick.css">
	<!--slick theme Css-->
	<link rel="stylesheet" href="<?= base_url(); ?>Assets/css/slick-theme.css">
	<!-- Style CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>Assets/css/style.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
</head>


<body data-spy="scroll" data-offset="80">

	<!-- START PRELOADER -->
	<div class="preloader" id="preloader">
		<div id="animacion-container" style="width: 150px; height: 150px;"></div>
		<!-- <div class="loader">
			<img src="<?= base_url(); ?>Assets/img/logo_loader.png" alt="Cargando" class="loader__img">
		</div> -->
	</div>
	<!-- END PRELOADER -->

<!-- ensayo carga -->
<script>
        // window.onload = function() {
        //     // Tiempo de espera de 1 minuto (60,000 ms)
        //     setTimeout(function() {
        //         var preloader = document.getElementById('preloader');
        //         preloader.style.display = 'none'; // Oculta el preloader después de 1 minuto
        //     }, 60000); // 60000 milisegundos = 1 minuto
        // };
		
		var animation = lottie.loadAnimation({
			container: document.getElementById('animacion-container'),
			renderer: 'svg',
			loop: true,
			autoplay: true,
			path: '../Assets/img/loader.json'
		});
        
    </script>
<!-- FIN ENSAYO -->





</body>

</html>