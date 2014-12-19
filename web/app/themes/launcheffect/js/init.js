// GLOBAL
var LE_Handlers = {
	spinners: {
		big: { 
			lines: 24, 
			length: 8, 
			width: 2, 
			radius: 24, 
			color: '#aaa', 
			speed: 1.25, 
			trail: 60, 
			shadow: false, 
			hwaccel: false, 
			className: 'spinner', 
			zIndex: 2e9, 
			top: 'auto', 
			left: 'auto' 
		},
		little: {
			lines: 10,
			length: 3,
			width: 2,
			radius: 5,
			color: '#FFF',
			speed: 1,
			trail: 60,
			shadow: false
		},
	},
  	leSubmitLoader: function(state){
		var submitSpinnerContainer = document.getElementById('submit-button-spinner');
		if ( state === false ) {
	      	$(submitSpinnerContainer).hide();
		} else {
			$(submitSpinnerContainer).html('').fadeIn('fast');
			submitSpinner = new Spinner(LE_Handlers.spinners.little).spin(submitSpinnerContainer);
		}
  	},
	sharing: {
		init: function (){
			var $blocks = $('.social-block');
			$blocks.each( function (){
				var $block = $(this),
					id = $block.attr('data-id'),
					signup = $block.parents('#signup').length,
					parent_id = (signup ? '' : '-blog');
				
				$block.attr('id', (id+parent_id));
			});
			if ( $('.social-block[id$="blog"]').length && $blocks.length >= wp_js.sharing_platforms.length) 
				LE_Handlers.sharing.buttons('');
		},
		enabled: false,
		buttons: function(refCode){
			if ( !LE_Handlers.sharing.enabled ) return;

			// Referral URL
			var blogURL = wp_js.blogURL,
				refUrl = (refCode!=''?(blogURL+'/?ref='+refCode):window.location.href),
				target = (refCode!=''?'':'-blog'),
				tweetUrl = 'http://twitter.com/intent?url=' + encodeURIComponent(refUrl), 
				tweetMessage = (refCode!=''?(wp_js.twitterMessage||document.title):document.title),
				tumblr_button = document.createElement("a");
		
			// Twitter (note: refUrl might not show up in share box on localhost)
			$('#tweetblock'+target).html('<a href="https://twitter.com/share" class="twitter-share-button" data-url="'+refUrl+'" data-text="'+tweetMessage+'" data-count="none">Tweet</a>');
			twttr.widgets.load();

	        // Facebook (note: won't work on localhost)
	        $("#fblikeblock"+target).html('<div class="fb-like" data-href="'+refUrl+'" data-width="129" data-height="22" data-colorscheme="light" data-layout="button_count" data-action="like" data-show-faces="false" data-send="true"></div>');
			FB.XFBML.parse(document.getElementById('fblikeblock'+target));

	        // Google +
	        gapi.plusone.render('plusoneblock'+target, {'href':refUrl, 'size':'tall', 'annotation':'none'});

	        // Tumblr
	        tumblr_button.setAttribute("href", "http://www.tumblr.com/share/link?url=" + encodeURIComponent(refUrl) + "&name=" + encodeURIComponent(wp_js.meta_title) + "&description=" + encodeURIComponent(wp_js.meta_description));
	        tumblr_button.setAttribute("title", "Share on Tumblr");
	        tumblr_button.setAttribute("onclick", "window.open(this.href, 'tumblr', 'width=460,height=400'); return false;");
	        tumblr_button.setAttribute("style", "display:inline-block; text-indent:-9999px; overflow:hidden; width:81px; height:20px; background:url('http://platform.tumblr.com/v1/share_1.png') top left no-repeat transparent;");
	        tumblr_button.innerHTML = "Share on Tumblr";
	        document.getElementById("tumblrblock"+target).appendChild(tumblr_button);

	        // LinkedIn
	        $('#linkinblock'+target).html('<script type="IN/Share" data-url="'+refUrl+'"></script>');
			IN.parse();
		},
	},
    leSubmit: function(data, returning){
        var blogURL = wp_js.blogURL;

        $('#form, #error, #presignup-content').hide();
        $('#success').fadeIn(function(){
            var successScroll = $('#signup-body').offset().top - 20;
            $('html,body').animate({scrollTop:successScroll}, 300);
        });

        if (returning == true) {

            $('#returninguser, #returninguserurl').show();

            var refCode = data.returncode;

            $('#returninguser span.user').text(data.email);
            $('#returninguser span.clicks').text(data.clicks);
            $('#returninguser span.conversions').text(data.conversions);
            $('#returninguserurl input#returningcode').attr('value', blogURL + '/?ref=' + refCode);

        } else {

            $('#success-content, #newuser').show();

            var refCode = data.code;

            $('#newuser input#successcode').attr('value', blogURL + '/?ref=' + refCode);

            if(data.pass_thru_error == "blocked"){
                $('#pass_thru_error').fadeIn();
                $('#pass_thru_error').html('AWeber Sync Error: Email Blocked.');
            } else if (data.pass_thru_error.AWeberAPIException != undefined){
                err = data.pass_thru_error.AWeberAPIException;
                $('#pass_thru_error').fadeIn();
                $('#pass_thru_error').html(err.type+': '+err.msg);
            }
        }
		LE_Handlers.sharing.buttons(refCode);
    },
	SelectAll: function(id) {
	    document.getElementById(id).focus();
	    document.getElementById(id).select();
	},
	reuserBubble: function(){
		var bubbleRight = ((124 - $('a#reusertip').width())/2)*(-1);
		var bubbleTop = ($('#reuserbubble').height() + $('a#reusertip').height() + 15) * (-1);
	 	var bubblePos = {
	      'right' : bubbleRight,
	      'top' : bubbleTop
	    }

	    $('#reuserbubble').css(bubblePos);

		$('a#reusertip').hover(function(){
			$('#reuserbubble').fadeIn('fast');
		},function(){
			$('#reuserbubble').stop().fadeOut('fast');
		});

		$('a#reusertip').click(function(e){
			e.preventDefault();
		});
	}
}

// DOCUMENT READY
jQuery(function($){

	// FADE IN BACKGROUND IMAGE ON SIGN-UP PAGES
	$(window).load(function(){
		if($('#signup-page').length) {
			$('#background').animate({opacity:1}, 600);
		}
	});

	// EASING EQUATION
	$.extend($.easing,{
	    def: 'easeInOutCubic',
	    easeInOutCubic: function (x, t, b, c, d) {
	        if ((t/=d/2) < 1) {
	        	return c/2*t*t*t + b;
	        }
	        return c/2*((t-=2)*t*t + 2) + b;
	    }
	});

	// BODY ID
	if(!$('#signup-page').length) {
		$('body').attr('id', 'inner-page');
	} else {
		$('body').attr('id', 'signup-bodytag');
		$('html').attr('id', 'signup-htmltag');
	}

	// FADE IN SIGNUP PAGE NICELY
	if($('#signup').length) {

		var signupSpinnerContainer = document.getElementById('signup');
		var signupSpinner = new Spinner(LE_Handlers.spinners.big).spin(signupSpinnerContainer);

		$('#signup-content-wrapper').imagesLoaded( function($imagesToFadeIn) {
			$('.spinner').remove();
			$('#signup-content-wrapper').animate({opacity:1}, 600);
		});

	}

	// IPHONE STICKY FOOTER
	if(navigator.platform == 'iPad' || navigator.platform == 'iPhone' || navigator.platform == 'iPod') {
		//$('ul#footer').css('position','static');
	}

	// EMBED WRAPPER
	$('.lepost iframe, #signup iframe, .lepost object, #signup object, .lepost embed, #signup embed').wrap('<div class="video" />');

	// MODAL POSITION
	$('.modal-trigger').click(function(){
		var modalPos = $(window).scrollTop() + 70;
		$('.jqmWindow').css('top', modalPos + 'px');
	});

	// RETURNING USER TOOLTIP
	LE_Handlers.reuserBubble();

	// ERROR MESSAGING
	if($('.error, #error').length) {
		$('#form-layout li').click(function(){
			$(this).find('#error, .error').fadeOut('fast');
		});

		$('#form-layout li .fieldset').siblings('.error').addClass('fieldset-error');
	}

	// Privacy Policy Modals
	$('.jqmWindow#privacy-policy').jqm({trigger: 'a#modal-privacy', overlay:60});
	$('.jqmWindow#privacy-policy').jqmAddClose('a.close');

	// SUBMIT THE FORM
    $("#form").submit(function(e){
      	e.preventDefault();
		LE_Handlers.leSubmitLoader(true);
        dataString = $("#form").serialize();
        var templateURL = wp_js.themeDir;
        var captcha = true;

        if ($('#captcha').length){
            captcha = false;
            $('#spambot').removeClass('caperror');
            var sum = parseInt($('#num1').val()) + parseInt($('#num2').val());
            if (parseInt($('#captcha').val()) != sum){
                LE_Handlers.leSubmitLoader(false);
			    $('#spambot').html('Incorrect captcha value.').addClass('caperror').fadeIn();
            } else {
                captcha = true;
            }
        }

        if (captcha){
            $.ajax({
                type: "POST",
                url: wp_js.ajaxurl,
                data: dataString,
                dataType: "json",
                success: function(data) {
                    if (data.email_check == "invalid") {
                        LE_Handlers.leSubmitLoader(false);
                        $('#error').html(wp_js.l10n.invalid_email).fadeIn();
                    } else if(data.required.length) {
                        LE_Handlers.leSubmitLoader(false);
                        $('.error').hide();
                        $d = String(data.required).split(",");
                        $.each($d, function(k, v){
                            $("#" + v + ".error").fadeIn();
                        });
                    } else {
						reuser = (data.reuser == "true") ? true : false;
						LE_Handlers.leSubmit(data,reuser);
						FB.XFBML.parse(document.getElementById('fblikeblock'));
						$('body').addClass('submission-success');
                    }
                }
            });
        }
    });

	// SHARES
	window.LE_Shares = setInterval(function (){
		var initialised = 0;
		
		if (parseInt(wp_js.sharing_enabled) > 0) LE_Handlers.sharing.enabled = true;
		for(i=0;i<wp_js.sharing_platforms.length;i++){
			if ( typeof(window[ wp_js.sharing_platforms[i] ]) != 'undefined' ) 
				initialised += 1;
		}
		if ( initialised == wp_js.sharing_platforms.length ) {
			clearInterval(window.LE_Shares);
			delete(window.LE_Shares);
			delete(window.initialised);
			if (LE_Handlers.sharing.enabled) LE_Handlers.sharing.init();
		}
	}, 1000);
	
	// slideshow function
	if(slideshow==true){
		$bg = $('#background');
		if ( $bg.children('div').length ) {
			$bg.addClass('slideshow');
			// do fadeshow
			var ss_args = {
				curr: 0,
				speed: parseFloat(slideshow_speed)*1000,
				duration: parseFloat(slideshow_duration)*1000
			}
			if (!$.support.leadingWhitespace) {
				$bg.children('div').each( function (){
					style = $(this).css('background-image');
					src = style.replace(/^url\(["']?/, '').replace(/["']?\)$/, '');
					$(this).css({
						'filter': "progid:DXImageTransform.Microsoft.AlphaImageLoader(src="+src+",sizingMethod='scale') alpha(opacity=0)",
						'-ms-filter': "progid:DXImageTransform.Microsoft.AlphaImageLoader(src="+src+",sizingMethod='scale') alpha(opacity=0)"
					});
				});
			}
			$bg.children('div').eq(0).delay(500).animate({opacity:1}, ss_args.speed);
			setInterval( function (){
				prev = ss_args.curr;
				next = ss_args.curr+1;
				if (ss_args.curr === false) {
					prev = $bg.children('div').length-1;
					next = 0;
					ss_args.curr=-1;
				}
				$bg.children('div').eq(prev).animate({opacity: 0},ss_args.speed);
				$bg.children('div').eq(next).animate({opacity: 1},ss_args.speed);
				ss_args.curr += 1;
				if (ss_args.curr == $bg.children('div').length-1){
					ss_args.curr=false;
				}
			}, ss_args.duration);
		} else {
			$bg.delay(500).animate({opacity:1});
		}
	}
});
