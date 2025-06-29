
$(document).ready(function () {

    "use strict";

      /* --------------------------------------------------
       * back to top
       * --------------------------------------------------*/
      var scrollTrigger = 500; // px
      var t = 0;
      function backToTop() {
          var scrollTop = $(window).scrollTop();
          if (scrollTop > scrollTrigger) {
              $('#back-to-top').addClass('show');
              $('#back-to-top').removeClass('hide');
              t = 1;
          }

          if (scrollTop < scrollTrigger && t==1) {
              $('#back-to-top').addClass('hide');
          }

      };

	  $(document).on('click', '#back-to-top', function() {
          $("html, body").animate({ scrollTop: 0 }, 600);
          return false;
      });



      /* ==========================================================================
      When document is Scrolling, do
      ========================================================================== */

      $(window).on('scroll', function() {
          backToTop();
      });


      /* ==========================================================================
      Dark/Light Switcher
      ========================================================================== */

		//Switch Function
		const switchTheme = () => {
			//Get root element and data-theme value
			const rootElem = document.documentElement
			let dataTheme = rootElem.getAttribute('data-theme'),
			newTheme

			newTheme = (dataTheme == 'light') ? 'dark' : 'light'

			//Set the new HTML attribute
			rootElem.setAttribute('data-theme', newTheme)

			//Set the new local storage item
			localStorage.setItem('theme', newTheme)

			if(dataTheme == 'light'){
				$('#switcher-icon').removeClass('bi bi-moon');
				$('#switcher-icon').addClass('bi bi-sun');

			} else if(dataTheme == 'dark'){
				$('#switcher-icon').removeClass('bi bi-sun');
				$('#switcher-icon').addClass('bi bi-moon');
			}
		}

		//Add event listener for the theme switcher
		document.querySelector('#theme-switcher').addEventListener('click', switchTheme);


		/* ==========================================================================
		Tooltip
		========================================================================== */
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        /*============================================
        Alert Fade
        ==============================================*/

        $(".danger-alert").fadeIn(1000).delay(5000).fadeOut(700);
        $(".alert-warning").fadeIn(1000).delay(5000).fadeOut(700);
        $(".alert-danger").fadeIn(1000).delay(5000).fadeOut(700);
        $(".alert-success").fadeIn(1000).delay(5000).fadeOut(700);


		/* ==========================================================================
		Search Toggle
		========================================================================== */
        let searchblock = document.querySelector(".search-block"),
            searchoverlay = document.querySelector(".search-overlay"),
            search = document.querySelectorAll('[data-toggle="search"]'),
            searchclose = document.querySelectorAll('[data-toggle="search-close"]');
        search.forEach(search => {
            search.addEventListener("click", function() {
                searchblock.classList.add("is-visible"), searchoverlay.classList.add("is-visible"), setTimeout(() => {
                    document.querySelector('[aria-label="search-query"]').focus()
                }, 250)
            })
        }), searchclose.forEach(search => {
            search.addEventListener("click", function() {
                searchblock.classList.remove("is-visible"), searchoverlay.classList.remove("is-visible"), document.querySelector('[aria-label="search-query"]').value = ""
            })
        })

		/* ==========================================================================
		Magnific Popup
		========================================================================== */
		$('.has-popup').magnificPopup({
            type: 'inline',
            fixedContentPos: true,
            fixedBgPos: true,
            overflowY: 'auto',
            closeBtnInside: false,
            preloader: false,
            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in'
        });

  });
