/*
Author       : Themesvila
Template Name: Portfx
Version      : 1.0
*/


(function($) {
	'use strict';

		// Counter Js
		jQuery(document).ready(function($) {

			/*Counter */
			$('.single-counter h4').counterUp({
				delay: 10,
				time: 1000
			});
			
			/* Active Menu */
			$(".mobile_menu").simpleMobileMenu({			
				"menuStyle": "slide"
			});
			
			/*START PROGRESS-BAR JS*/
			$('.skillbar > span').each(function(){
				var $this = $(this);
				var width = $(this).data('percent');
				$this.css({
					'transition' : 'width 2s'
				});
				
				setTimeout(function() {
					$this.appear(function() {
							$this.css('width', width + '%');
					});
				}, 800);
			});
			/*END PROGRESS-BAR JS*/
		
		});
		

		
		/*PRELOADER JS*/
		$(window).on('load', function() { 
			$('.preloader').fadeOut();
			$('.preloader').delay(350).fadeOut('slow'); 
		}); 
		
		
		/*END PRELOADER JS*/		
	

		/* Image Popup */
		 $('.popbtn').magnificPopup({
			 type:'image',
			 gallery:{
				enabled:true
			  }
		});		
		

		 /*START Portfolio*/	
		$('.project-slider').owlCarousel({
			items : 5,
			autoplay: true,
			center: true,
			loop: true,
			navText: ["<svg fill='none' viewBox='0 0 91 16'><path fill='#1C3F39' d='M.289 7.43a1 1 0 00.008 1.413l6.398 6.33a1 1 0 001.407-1.422L2.414 8.125 8.04 2.437a1 1 0 00-1.422-1.406L.29 7.429zm90.704-.786L.995 7.133l.01 2 90-.49-.012-2z'/></svg>" ,"<svg fill='none' viewBox='0 0 91 16'><path fill='#1C3F39' d='M90.707 8.707a1 1 0 000-1.414L84.343.929a1 1 0 10-1.414 1.414L88.585 8l-5.656 5.657a1 1 0 001.414 1.414l6.364-6.364zM0 9h90V7H0v2z'/></svg>"],
			nav: true,
			dots: true,
			margin: 30,
			responsive:{
				0:{
					items:1,
					
				},
				575:{
					items:2,
					
				},
				768:{
					items:3,
					
				},
				1000:{
					items:4,
			
				},
				1200:{
					items:5,
			
				}
			}
		});
		
		/*END Portfolio*/
		
		/*START PARTNER LOGO*/
		$('.client-slider').owlCarousel({
			margin: 30,
			autoPlay: 5000, //Set AutoPlay to 3 seconds
			items : 6,			
			nav: false,
			dots: false,
			loop: true,
			responsive:{
				0:{
					items:2,
					
				},
				575:{
					items:3,
					
				},
				768:{
					items:4,
					
				},
				1000:{
					items:5,
			
				},
				1200:{
					items:6,
			
				}
			}
		});
		/*END PARTNER LOGO*/
		
		 /*START Testimonials*/	
		$('.testimonial-slider').owlCarousel({
			items : 3,
			autoplay: true,
			center: true,
			loop: true,
			navText: ["<svg fill='none' viewBox='0 0 91 16'><path fill='#1C3F39' d='M.289 7.43a1 1 0 00.008 1.413l6.398 6.33a1 1 0 001.407-1.422L2.414 8.125 8.04 2.437a1 1 0 00-1.422-1.406L.29 7.429zm90.704-.786L.995 7.133l.01 2 90-.49-.012-2z'/></svg>" ,"<svg fill='none' viewBox='0 0 91 16'><path fill='#1C3F39' d='M90.707 8.707a1 1 0 000-1.414L84.343.929a1 1 0 10-1.414 1.414L88.585 8l-5.656 5.657a1 1 0 001.414 1.414l6.364-6.364zM0 9h90V7H0v2z'/></svg>"],
			nav: true,
			dots: true,
			margin: 35,
			responsive:{
				0:{
					items:1,
					
				},
				575:{
					items:1,
					
				},
				768:{
					items:2,
					
				},
				1000:{
					items:3,
			
				},
				1200:{
					items:3,
			
				}
			}
		});
		
		/*END Testimonials*/
		
		/* WOW */
		new WOW().init();	
		
})(jQuery);

