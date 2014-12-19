/*
launch-effect - v - 2014-02-04
A viral marketing theme for WordPress empowering designers, marketers, and enthusiasts to build websites with relative ease
Lovingly coded by Barrel  - http://barrelny.com 
*/
/*
 * jqModal - Minimalist Modaling with jQuery
 *   (http://dev.iceburg.net/jquery/jqModal/)
 *
 * Copyright (c) 2007,2008 Brice Burgess <bhb@iceburg.net>
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 * 
 * $Version: 03/01/2009 +r14
 */
(function($) {
$.fn.jqm=function(o){
var p={
overlay: 50,
overlayClass: 'jqmOverlay',
closeClass: 'jqmClose',
trigger: '.jqModal',
ajax: F,
ajaxText: '',
target: F,
modal: F,
toTop: F,
onShow: F,
onHide: F,
onLoad: F
};
return this.each(function(){if(this._jqm)return H[this._jqm].c=$.extend({},H[this._jqm].c,o);s++;this._jqm=s;
H[s]={c:$.extend(p,$.jqm.params,o),a:F,w:$(this).addClass('jqmID'+s),s:s};
if(p.trigger)$(this).jqmAddTrigger(p.trigger);
});};

$.fn.jqmAddClose=function(e){return hs(this,e,'jqmHide');};
$.fn.jqmAddTrigger=function(e){return hs(this,e,'jqmShow');};
$.fn.jqmShow=function(t){return this.each(function(){t=t||window.event;$.jqm.open(this._jqm,t);});};
$.fn.jqmHide=function(t){return this.each(function(){t=t||window.event;$.jqm.close(this._jqm,t)});};

$.jqm = {
hash:{},
open:function(s,t){var h=H[s],c=h.c,cc='.'+c.closeClass,z=(parseInt(h.w.css('z-index'))),z=(z>0)?z:3000,o=$('<div></div>').css({height:'100%',width:'100%',position:'fixed',left:0,top:0,'z-index':z-1,opacity:c.overlay/100});if(h.a)return F;h.t=t;h.a=true;h.w.css('z-index',z);
 if(c.modal) {if(!A[0])L('bind');A.push(s);}
 else if(c.overlay > 0)h.w.jqmAddClose(o);
 else o=F;

 h.o=(o)?o.addClass(c.overlayClass).prependTo('body'):F;
 if(ie6){$('html,body').css({height:'100%',width:'100%'});if(o){o=o.css({position:'absolute'})[0];for(var y in {Top:1,Left:1})o.style.setExpression(y.toLowerCase(),"(_=(document.documentElement.scroll"+y+" || document.body.scroll"+y+"))+'px'");}}

 if(c.ajax) {var r=c.target||h.w,u=c.ajax,r=(typeof r == 'string')?$(r,h.w):$(r),u=(u.substr(0,1) == '@')?$(t).attr(u.substring(1)):u;
  r.html(c.ajaxText).load(u,function(){if(c.onLoad)c.onLoad.call(this,h);if(cc)h.w.jqmAddClose($(cc,h.w));e(h);});}
 else if(cc)h.w.jqmAddClose($(cc,h.w));

 if(c.toTop&&h.o)h.w.before('<span id="jqmP'+h.w[0]._jqm+'"></span>').insertAfter(h.o);	
 (c.onShow)?c.onShow(h):h.w.show();e(h);return F;
},
close:function(s){var h=H[s];if(!h.a)return F;h.a=F;
 if(A[0]){A.pop();if(!A[0])L('unbind');}
 if(h.c.toTop&&h.o)$('#jqmP'+h.w[0]._jqm).after(h.w).remove();
 if(h.c.onHide)h.c.onHide(h);else{h.w.hide();if(h.o)h.o.remove();} return F;
},
params:{}};
var s=0,H=$.jqm.hash,A=[],ie6=$.browser.msie&&($.browser.version == "6.0"),F=false,
i=$('<iframe src="javascript:false;document.write(\'\');" class="jqm"></iframe>').css({opacity:0}),
e=function(h){if(ie6)if(h.o)h.o.html('<p style="width:100%;height:100%"/>').prepend(i);else if(!$('iframe.jqm',h.w)[0])h.w.prepend(i); f(h);},
f=function(h){try{$(':input:visible',h.w)[0].focus();}catch(_){}},
L=function(t){$()[t]("keypress",m)[t]("keydown",m)[t]("mousedown",m);},
m=function(e){var h=H[A[A.length-1]],r=(!$(e.target).parents('.jqmID'+h.s)[0]);if(r)f(h);return !r;},
hs=function(w,t,c){return w.each(function(){var s=this._jqm;$(t).each(function() {
 if(!this[c]){this[c]=[];$(this).click(function(){for(var i in {jqmShow:1,jqmHide:1})for(var s in this[i])if(H[this[i][s]])H[this[i][s]].w[i](this);return F;});}this[c].push(s);});});};
})(jQuery);(function(window, document, undefined) {

/**
 * Copyright (c) 2011 Felix Gnass [fgnass at neteye dot de]
 * Licensed under the MIT license
 */

  var prefixes = ['webkit', 'Moz', 'ms', 'O']; /* Vendor prefixes */
  var animations = {}; /* Animation rules keyed by their name */
  var useCssAnimations;

  /**
   * Utility function to create elements. If no tag name is given,
   * a DIV is created. Optionally properties can be passed.
   */
  function createEl(tag, prop) {
    var el = document.createElement(tag || 'div');
    var n;

    for(n in prop) {
      el[n] = prop[n];
    }
    return el;
  }

  /**
   * Appends children and returns the parent.
   */
  function ins(parent /* child1, child2, ...*/) {
    for (var i=1, n=arguments.length; i<n; i++) {
      parent.appendChild(arguments[i]);
    }
    return parent;
  }

  /**
   * Insert a new stylesheet to hold the @keyframe or VML rules.
   */
  var sheet = function() {
    var el = createEl('style');
    ins(document.getElementsByTagName('head')[0], el);
    return el.sheet || el.styleSheet;
  }();

  /**
   * Creates an opacity keyframe animation rule and returns its name.
   * Since most mobile Webkits have timing issues with animation-delay,
   * we create separate rules for each line/segment.
   */
  function addAnimation(alpha, trail, i, lines) {
    var name = ['opacity', trail, ~~(alpha*100), i, lines].join('-');
    var start = 0.01 + i/lines*100;
    var z = Math.max(1-(1-alpha)/trail*(100-start) , alpha);
    var prefix = useCssAnimations.substring(0, useCssAnimations.indexOf('Animation')).toLowerCase();
    var pre = prefix && '-'+prefix+'-' || '';

    if (!animations[name]) {
      sheet.insertRule(
        '@' + pre + 'keyframes ' + name + '{' +
        '0%{opacity:'+z+'}' +
        start + '%{opacity:'+ alpha + '}' +
        (start+0.01) + '%{opacity:1}' +
        (start+trail)%100 + '%{opacity:'+ alpha + '}' +
        '100%{opacity:'+ z + '}' +
        '}', 0);
      animations[name] = 1;
    }
    return name;
  }

  /**
   * Tries various vendor prefixes and returns the first supported property.
   **/
  function vendor(el, prop) {
    var s = el.style;
    var pp;
    var i;

    if(s[prop] !== undefined) return prop;
    prop = prop.charAt(0).toUpperCase() + prop.slice(1);
    for(i=0; i<prefixes.length; i++) {
      pp = prefixes[i]+prop;
      if(s[pp] !== undefined) return pp;
    }
  }

  /**
   * Sets multiple style properties at once.
   */
  function css(el, prop) {
    for (var n in prop) {
      el.style[vendor(el, n)||n] = prop[n];
    }
    return el;
  }

  /**
   * Fills in default values.
   */
  function merge(obj) {
    for (var i=1; i < arguments.length; i++) {
      var def = arguments[i];
      for (var n in def) {
        if (obj[n] === undefined) obj[n] = def[n];
      }
    }
    return obj;
  }

  /**
   * Returns the absolute page-offset of the given element.
   */
  function pos(el) {
    var o = {x:el.offsetLeft, y:el.offsetTop};
    while((el = el.offsetParent)) {
      o.x+=el.offsetLeft;
      o.y+=el.offsetTop;
    }
    return o;
  }

  var defaults = {
    lines: 12,            // The number of lines to draw
    length: 7,            // The length of each line
    width: 5,             // The line thickness
    radius: 10,           // The radius of the inner circle
    rotate: 0,            // rotation offset
    color: '#000',        // #rgb or #rrggbb
    speed: 1,             // Rounds per second
    trail: 100,           // Afterglow percentage
    opacity: 1/4,         // Opacity of the lines
    fps: 20,              // Frames per second when using setTimeout()
    zIndex: 2e9,          // Use a high z-index by default
    className: 'spinner', // CSS class to assign to the element
    top: 'auto',          // center vertically
    left: 'auto'          // center horizontally
  };

  /** The constructor */
  var Spinner = function Spinner(o) {
    if (!this.spin) return new Spinner(o);
    this.opts = merge(o || {}, Spinner.defaults, defaults);
  };

  Spinner.defaults = {};
  merge(Spinner.prototype, {
    spin: function(target) {
      this.stop();
      var self = this;
      var o = self.opts;
      var el = self.el = css(createEl(0, {className: o.className}), {position: 'relative', zIndex: o.zIndex});
      var mid = o.radius+o.length+o.width;
      var ep; // element position
      var tp; // target position

      if (target) {
        target.insertBefore(el, target.firstChild||null);
        tp = pos(target);
        ep = pos(el);
        css(el, {
          left: (o.left == 'auto' ? tp.x-ep.x + (target.offsetWidth >> 1) : o.left+mid) + 'px',
          top: (o.top == 'auto' ? tp.y-ep.y + (target.offsetHeight >> 1) : o.top+mid)  + 'px'
        });
      }

      el.setAttribute('aria-role', 'progressbar');
      self.lines(el, self.opts);

      if (!useCssAnimations) {
        // No CSS animation support, use setTimeout() instead
        var i = 0;
        var fps = o.fps;
        var f = fps/o.speed;
        var ostep = (1-o.opacity)/(f*o.trail / 100);
        var astep = f/o.lines;

        !function anim() {
          i++;
          for (var s=o.lines; s; s--) {
            var alpha = Math.max(1-(i+s*astep)%f * ostep, o.opacity);
            self.opacity(el, o.lines-s, alpha, o);
          }
          self.timeout = self.el && setTimeout(anim, ~~(1000/fps));
        }();
      }
      return self;
    },
    stop: function() {
      var el = this.el;
      if (el) {
        clearTimeout(this.timeout);
        if (el.parentNode) el.parentNode.removeChild(el);
        this.el = undefined;
      }
      return this;
    },
    lines: function(el, o) {
      var i = 0;
      var seg;

      function fill(color, shadow) {
        return css(createEl(), {
          position: 'absolute',
          width: (o.length+o.width) + 'px',
          height: o.width + 'px',
          background: color,
          boxShadow: shadow,
          transformOrigin: 'left',
          transform: 'rotate(' + ~~(360/o.lines*i+o.rotate) + 'deg) translate(' + o.radius+'px' +',0)',
          borderRadius: (o.width>>1) + 'px'
        });
      }
      for (; i < o.lines; i++) {
        seg = css(createEl(), {
          position: 'absolute',
          top: 1+~(o.width/2) + 'px',
          transform: o.hwaccel ? 'translate3d(0,0,0)' : '',
          opacity: o.opacity,
          animation: useCssAnimations && addAnimation(o.opacity, o.trail, i, o.lines) + ' ' + 1/o.speed + 's linear infinite'
        });
        if (o.shadow) ins(seg, css(fill('#000', '0 0 4px ' + '#000'), {top: 2+'px'}));
        ins(el, ins(seg, fill(o.color, '0 0 1px rgba(0,0,0,.1)')));
      }
      return el;
    },
    opacity: function(el, i, val) {
      if (i < el.childNodes.length) el.childNodes[i].style.opacity = val;
    }
  });

  /////////////////////////////////////////////////////////////////////////
  // VML rendering for IE
  /////////////////////////////////////////////////////////////////////////

  /**
   * Check and init VML support
   */
  !function() {

    function vml(tag, attr) {
      return createEl('<' + tag + ' xmlns="urn:schemas-microsoft.com:vml" class="spin-vml">', attr);
    }

    var s = css(createEl('group'), {behavior: 'url(#default#VML)'});

    if (!vendor(s, 'transform') && s.adj) {

      // VML support detected. Insert CSS rule ...
      sheet.addRule('.spin-vml', 'behavior:url(#default#VML)');

      Spinner.prototype.lines = function(el, o) {
        var r = o.length+o.width;
        var s = 2*r;

        function grp() {
          return css(vml('group', {coordsize: s +' '+s, coordorigin: -r +' '+-r}), {width: s, height: s});
        }

        var margin = -(o.width+o.length)*2+'px';
        var g = css(grp(), {position: 'absolute', top: margin, left: margin});

        var i;

        function seg(i, dx, filter) {
          ins(g,
            ins(css(grp(), {rotation: 360 / o.lines * i + 'deg', left: ~~dx}),
              ins(css(vml('roundrect', {arcsize: 1}), {
                  width: r,
                  height: o.width,
                  left: o.radius,
                  top: -o.width>>1,
                  filter: filter
                }),
                vml('fill', {color: o.color, opacity: o.opacity}),
                vml('stroke', {opacity: 0}) // transparent stroke to fix color bleeding upon opacity change
              )
            )
          );
        }

        if (o.shadow) {
          for (i = 1; i <= o.lines; i++) {
            seg(i, -2, 'progid:DXImageTransform.Microsoft.Blur(pixelradius=2,makeshadow=1,shadowopacity=.3)');
          }
        }
        for (i = 1; i <= o.lines; i++) seg(i);
        return ins(el, g);
      };
      Spinner.prototype.opacity = function(el, i, val, o) {
        var c = el.firstChild;
        o = o.shadow && o.lines || 0;
        if (c && i+o < c.childNodes.length) {
          c = c.childNodes[i+o]; c = c && c.firstChild; c = c && c.firstChild;
          if (c) c.opacity = val;
        }
      };
    }
    else {
      useCssAnimations = vendor(s, 'animation');
    }
  }();

  if (typeof define == 'function' && define.amd) {
    define(function() {
      return Spinner;
    });
  }
  else {
    window.Spinner = Spinner;
  }

})(window, document);
(function(c, n) {
    var k = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
    c.fn.imagesLoaded = function(l) {
        function m() {
            var b = c(h), a = c(g);
            d && (g.length ? d.reject(e, b, a) : d.resolve(e));
            c.isFunction(l) && l.call(f, e, b, a)
        }
        function i(b, a) {
            b.src === k || -1 !== c.inArray(b, j) || (j.push(b), a ? g.push(b) : h.push(b), c.data(b, "imagesLoaded", {isBroken: a,src: b.src}), o && d.notifyWith(c(b), [a, e, c(h), c(g)]), e.length === j.length && (setTimeout(m), e.unbind(".imagesLoaded")))
        }
        var f = this, d = c.isFunction(c.Deferred) ? c.Deferred() : 
        0, o = c.isFunction(d.notify), e = f.find("img").add(f.filter("img")), j = [], h = [], g = [];
        e.length ? e.bind("load.imagesLoaded error.imagesLoaded", function(b) {
            i(b.target, "error" === b.type)
        }).each(function(b, a) {
            var e = a.src, d = c.data(a, "imagesLoaded");
            if (d && d.src === e)
                i(a, d.isBroken);
            else if (a.complete && a.naturalWidth !== n)
                i(a, 0 === a.naturalWidth || 0 === a.naturalHeight);
            else if (a.readyState || a.complete)
                a.src = k, a.src = e
        }) : m();
        return d ? d.promise(f) : f
    }
})(jQuery);
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
