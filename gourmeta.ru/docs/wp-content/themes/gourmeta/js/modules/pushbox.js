/**
* pushbox plugin
* @author Rocco Janse, <rocco@efocus.nl>
* @author Klaas Dieleman
* @author Mirjam
* @since may 2011
* @copyright eFocus
*/

;
(function ($) {
	$.fn.pushbox = function (options) {

		if (this.length > 1) {
			this.each(function () {
				$(this).pushbox(options)
			});
			return this;
		}

		// SETUP private variabls;
		var pushbox = this;
		var _slides = [];
		var _navitems = [];
		var ts = null;

		// setup options
		var defOptions = {
			viewport: $('div.pushbox div.viewport'),
			slidescontainer: 'div.pushbox ul.slides',
			slides: 'div.pushbox ul.slides li',
			navitems: $('.pushbox-nav li'),
			prevbutton: null,
			nextbutton: null,
			prefixid: 'slide',
			duration: 1000,
			fadeduration: 500,
			autoplay: true
		}

		// globals
		var _init = false;
		var _options = $.extend(defOptions, options);
		var _currentIndex = 0;
		var _isPlaying = false;
		var _videoPlayer = null;
		var pauseAnimation = false;
		var animateDirection = 'next';

		// init
		init(this);

		// methods
		function init(pb) {

			// pushbox specific vars 
			initSlides();

			// init prev/next buttons
			if (_options.prevbutton && _options.nextbutton) {
				initPrevNext();
			}

			// init navigation
			if (_options.navitems.length > 0) {
				initNavigation();
			}

			// pause animation
			if (_options.autoplay == true) {

				$.merge($(pushbox), _options.viewport).mouseenter(function () {
					pauseAnimation = true;
					clearTimeout(ts);
				});
				
				$(pushbox).mouseleave(function () {
					pauseAnimation = false;
					ts = setTimeout(function () {
						showSlide(getNextSlide());
					}, $(_options.duration)[0]);
				});
			}

			_init = true;

		}

		/**
		* initiates prev/next
		* @return void  
		*/
		function initPrevNext() {

			animateDirection = 'next';

			$(_options.prevbutton).unbind('click');
			$(_options.prevbutton).click(function (e) {
				clearTimeout(ts);
				pauseAnimation = false;
				animateDirection = 'prev';
				showSlide(getPrevSlide());
			});

			$(_options.nextbutton).unbind('click');
			$(_options.nextbutton).click(function (e) {
				clearTimeout(ts);
				pauseAnimation = false;
				animateDirection = 'next';
				showSlide(getNextSlide());
			});

		}

		/**
		* initiates slides and builds slide parameters array
		* @param {array} slide objects
		* @return {array} containing objects of each slides with parameters
		*/
		function initSlides() {
			
			_slides = $(_options.slides);
			_slides.each(function (index, slide) {
				$(slide).hide();
			});

			showSlide(0);

			ts = setTimeout(function () {
				showSlide(getNextSlide());
			}, $(_options.duration)[0]);
			
		}

		/**
		* initiates navigation
		* @return void
		*/
		function initNavigation() {

			_options.navitems.each(function (i, item) {
				$(item).click(function (e) {
					e.stopPropagation();
					if (_currentIndex != i) {
						clearTimeout(ts);
						pauseAnimation = false;
						showSlide($(item).index());
					}
				});
			});
		}

		/**
		* shows requested slide and starts/stops video
		* @param {integer} requested slide index
		* @return void
		*/
		function showSlide(index) {

			$(_options.prevbutton).unbind('click');
			$(_options.nextbutton).unbind('click');

			if (_isPlaying == true || pauseAnimation == true) {
				return false;
			}
			
			// navigation
			if (_options.navitems.length > 0) {
				_options.navitems.removeClass('active');
				$(_options.navitems[index]).addClass('active');
            }

			// video	
			if ($(_slides[index]).find('.video').length > 0 && $(_slides[index]).find('.button-video').length > 0) {
				
				$(_slides[index]).find('.mediaplayer-wrapper a').click(function (e) {
					e.preventDefault();
				});

				$(_slides[index]).find('.button-video').unbind('click');
				$(_slides[index]).find('.button-video').click(function (e) {
					e.preventDefault();
					
					// init video
					var video = $(_slides[index]).find('.video').find('a').attr('href');
					var still = $(_slides[index]).find('.video').find('img').attr('src');

					var w = 828;
					var h = 466;

					if (video && still) {
						_videoPlayer = jwplayer($(_slides[index]).find('.video').attr('id')).setup({
							flashplayer: '/framework/Websites/Decs/Web/js/jwplayer/player.swf',
							file: video,
							image: still,
							width: w,
							height: h,
							autostart: true
						});
							
						$(_slides[index]).find('.mediaplayer-wrapper').addClass('playing');
						_options.viewport.height(515);
						$('.breadcrumb-wrapper').css('visibility', 'hidden');
												
						jwplayer().onComplete(function() { 
							_isPlaying = false;
							setTimeout(function () { showSlide(getNextSlide()); }, 1000);							
						});

					}

					// stop pushbox
					clearTimeout(ts);
					_isPlaying = true;

					// hide content
					$(_slides[index]).find('.text-box').hide();
					$('.pushbox-nav').hide();
					$('.pushbox-teasers').hide();
					$(_options.prevbutton).hide();
					$(_options.nextbutton).hide();

				});
			}

			$(_slides[index]).show();
			
			if (index != _currentIndex) {

				// current teasersbox
				if (animateDirection == 'prev') {
					$('.pushbox-teasers').find('[data-decs-slideindex=' + index + ']').insertAfter($('.pushbox-teasers').find('[data-decs-slideindex=' + _currentIndex + ']'));
					
					// animeer teasers
					$($('.pushbox-teasers').find('.pushbox-teasers-box')).animate({
							marginLeft: '-900px'
						}, _options.fadeduration, function() {
							$($(this).find('.slide-teasers')[0]).appendTo($('.pushbox-teasers').find('.pushbox-teasers-box'));
							$('.pushbox-teasers').find('.pushbox-teasers-box').css('margin-left', 0);
						});
					
				} else {
					
					$('.pushbox-teasers').find('[data-decs-slideindex=' + index + ']').insertBefore($('.pushbox-teasers').find('[data-decs-slideindex=' + _currentIndex + ']'));
					$($('.pushbox-teasers').find('.pushbox-teasers-box')).css('margin-left', '-900px');

					$($('.pushbox-teasers').find('.pushbox-teasers-box')).animate({
							marginLeft: '0'
						}, _options.fadeduration);

				}
				

				// resetvideo
				resetVideo();

				// stop current
				clearTimeout(ts);

				// animeer slides
				$(_slides[_currentIndex]).css('z-index', 998);
				$(_slides[_currentIndex]).fadeOut(_options.fadeduration, function() {

					// z-index aanpassen	
					$(this).css('z-index', 1);

					// show new slide
					_currentIndex = index;

					// prev/next knoppen weer aan
					initPrevNext();

					// autoplay
					if (_options.autoplay == true) {
						var duration = $(_options.duration)[0];
						ts = setTimeout(function() {
							showSlide(getNextSlide());
						}, duration);
					}
				});

			}
		}

		/**
		* 
		*/

		function resetVideo() {
			if (_videoPlayer && jwplayer()) {
				jwplayer().stop();
				jwplayer().remove();
			}
			
			$('.breadcrumb-wrapper').css('visibility', 'visible');
			$(_slides).find('.mediaplayer-wrapper').removeClass('playing');
			_options.viewport.height(475);

			$(_slides).find('.text-box').show();
			$('.pushbox-teasers').show();
			$('.pushbox-nav').show();

			$(_options.prevbutton).show();
			$(_options.nextbutton).show();

		}

		/**
		* @return number
		*/
		function getNextSlide() {
			if (_currentIndex + 1 > _slides.length - 1) {
				var req = 0;
			} else {
				var req = _currentIndex + 1;
			}
			return req;
		}

		/**
		* @return number
		*/
		function getPrevSlide() {
			if (_currentIndex - 1 < 0) {
				var req = _slides.length - 1;
			} else {
				var req = _currentIndex - 1;
			}
			return req;
		}

		var options = $.extend({}, defOptions, options);

		// PUBLIC functions

		/**
		* enables pause/resume on mouseover
		*/
		this.initPauseProgress = function () {
			clearTimeout(ts);
		}

		return this;
	}
})(jQuery);