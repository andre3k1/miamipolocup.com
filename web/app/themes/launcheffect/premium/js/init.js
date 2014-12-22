// DOCUMENT READY
jQuery(function($){

	// ANIMATE BAR CHART
	$(window).load(function(){
		var barComplete = $('.barComplete').attr('value');

		if($('#bar-complete').length) {
			$('#bar-complete').animate({
				width:barComplete + '%'
			}, 1800, 'easeInOutCubic', function(){
				$('#bar-complete span').animate({opacity:1},1000);
			});
		}

	});

	// FADE IN INNER PAGES NICELY
	if($('#main').length) {
		if($('#hero').length) {
			$('#wrapper header img, #hero img').imagesLoaded(function(){
				$('#nav-responsive, #wrapper header, #hero, #sidebar').animate({opacity:1},300, function(){
					$('#main').animate({opacity:1},300, function(){
						$('#main img').each(function(){
							$(this).imagesLoaded( function($imagesToFadeIn) {
							  $imagesToFadeIn.animate({opacity:1},600);
							});
						});
					});
				});
			});
		} else {
			$('#wrapper header img').imagesLoaded(function(){
				$('#nav-responsive, #wrapper header, #sidebar').animate({opacity:1},300, function(){
					$('#main').animate({opacity:1},300, function(){
						$('#main img').each(function(){
							$(this).imagesLoaded( function($imagesToFadeIn) {
								$imagesToFadeIn.animate({opacity:1},600);
							});
						});
					});
				});
			});
		}
	}

	// LAUNCH MODULE TAB
	$('#launchtab a').click(function(){
		$('#launchlitemodule').slideToggle(function(){
			// Temporary fix for CSS3 border-box causing jQuery to set this container to overflow:hidden;
			// Container needs to be overflow:visible so the returning user tooltip will show.
			$(this).css('overflow','visible');
		});
		LE_Handlers.reuserBubble();
		return false;
	});

	// RESPONSIVE NAV ARROW
	$('<span>&rsaquo;</span>').appendTo($('#nav-responsive nav').find('a'));
	$('#nav-responsive-menu-link').click(function(){
		$(this).toggleClass('open');
		return false;
	});

	// COUNTDOWN TIMER
	var launchMonth = $('input#launchMonth').attr('value');
	var launchDay = $('input#launchDay').attr('value');
	var launchYear = $('input#launchYear').attr('value');
	var launchDate = new Date();
	launchDate = new Date(launchYear, launchMonth - 1, launchDay, 00, 00, 00);
	$('#tearoff').countdown({
		until: launchDate,
		layout: $('#tearoff').html()
	});
	// If three-digits
	if($('input.daysLeft').attr('value') > 99) {
		$('#tearoff').addClass('threedigits');
	}

	// LIGHTBOX GALLERY (PREMIUM)
	$("a[rel^=fancybox]").fancybox({
		transitionIn	: 'elastic',
		transitionOut	: 'elastic',
		titlePosition 	: 'over',
		titleFormat		: function(title, array, idx) {
			if (!title.length||title==''){
				/* removing fallback
				// see if image has alt tags
				caption = array[idx].children[0].alt;
				if (caption&&caption!='') title = caption;
				*/
				title = false;
			}
			return '<span id="fancybox-title-over">Image '+(idx + 1)+' / '+array.length+(title?' - '+title:'')+'</span>';
		}
	});

	// COMMENTS FORM EXPAND
	var mouse_is_inside = false;

    $('#respond').hover(function(){
        mouse_is_inside=true;
    }, function(){
        mouse_is_inside=false;
    });

	$('#comment').focus(function(){
		var $this = $(this);
		if( $('html').hasClass('ie') && (this.value == 'Click to leave a comment...')) this.value = '';
		$this.css('height','auto');
		$('#commentsform-hidden').fadeIn();
		var commentScroll = $('#respond').offset().top - 15;
		$('html,body').animate({scrollTop:commentScroll}, 600);
	}).blur(function(){
		if( $('html').hasClass('ie') && (this.value == ''))
			this.value = 'Click to leave a comment...';
	}).blur();

	$('#respond .required').focus(function(){
		var $this = $(this);
		if( $('html').hasClass('ie') && (this.value == 'Click to leave a comment...')) this.value = '';
		if ( $this.hasClass('errors') ) {
			this.value = '';
			$this.removeClass('errors');
		}
	});

	$('#commentform').submit( function (){
		var $comment = $('#comment'),
			$author = $('#comment-author'),
			$email = $('#comment-email');

		if ($comment.val() == '') {
			$comment.addClass('errors');
		}
		if ($author.length && $author.val() == '') {
			$author.addClass('errors');
			$author.val('Please enter your name.');
		}
		if ($email.length && $email.val() == '') {
			$email.addClass('errors');
			$email.val('Please enter an email address.');
		}
		if ($email.length && $email.val() != '') {
			var email = $email.val().toLowerCase(),
				regex = new RegExp('^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$'),
				isValid = email.match(regex);
			if (!isValid) {
				$email.addClass('errors');
				$email.val('Please enter a valid email address.');
			}
		}
		if ( $(this).find('.errors').length > 0 ) return false;
		return true;
	});

    $('body').mouseup(function(){
        if(! mouse_is_inside) {
        	$('#respond textarea').css('height','46px');
        	$('#commentsform-hidden').hide();
        }
    });

});
