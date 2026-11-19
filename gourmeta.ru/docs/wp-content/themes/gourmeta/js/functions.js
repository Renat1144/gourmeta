jQuery.noConflict();

jQuery(function ($) {


	/**
	* Parses querystring and returns it as an object with key/value pairs.
	* @returns Object
	*/
	parseQueryString = function () {

		var strQs = location.search;
		var objQs = {};

		$.each(strQs.replace('?', '').split('&'), function (i, el) {
			var name = el.split('=')[0];
			var value;

			if (el.split('=').length == 2) {
				value = el.split('=')[1];
			} else {
				value = name;
			}

			objQs[name] = value;
		});

		return objQs;

	}

	/*
	* equalizes height of multiple elements to the heighest element
	* @param string : css selector of elements to equalize
	* @param number? : optional number of columns to equalize elements by group instead of all elements
	*/
	equalizeHeight = function (strSelector, numColumns) {

		var $Elements = $(strSelector);
		numColumns = numColumns || $Elements.length;

		var doEqualize = function () {

			var numMaxheight = 0;
			var arrCurrentRow = [];

			$Elements.each(function (index, item) {
				$(item).data('overflow', $(item).css('overflow'));
				$(item).css('overflow', 'hidden');
				$(item).css('min-height', '0');

				var numHeight = $(item).innerHeight();
				if (numHeight > numMaxheight) {
					numMaxheight = $(item).innerHeight();
				}
				arrCurrentRow.push(item);

				if ((index + 1) % numColumns == 0 || index + 1 == $Elements.length) {
					$(arrCurrentRow).each(function (index, item) {

						var numNewHeight = numMaxheight;
						numNewHeight -= parseInt($(item).css('padding-top'));
						numNewHeight -= parseInt($(item).css('padding-bottom'));

						$(item).css('min-height', numNewHeight);
						$(item).css('overflow', $(item).data('overflow'));
					});

					numMaxheight = 0;
					arrCurrentRow = [];
				}
			});

		};

		doEqualize();

		// repeat onload for large images etc.
		$(window).load(function () {
			doEqualize();
		});

	}

	/*
	* init videoplayer, all videowrapper with class jw-wrapper
	*/
	initJwPlayer = function () {
		jQuery('.jw-wrapper').each(function () {

			var video = $(this).find('a').attr('href');
			var still = $(this).find('img').attr('src');

			var w = $(this).width();
			var h = $(this).height();

			if (video && still) {
				jwplayer(this.id).setup({
					flashplayer: '/framework/Websites/Decs/Web/js/jwplayer/player.swf',
					file: video,
					image: still,
					width: w,
					height: h
				});
			}
		});

	}

	/*
	* form settings
	*/
	setFormSettings = function () {

		// layout radiolists
		$('.form-item').find('fieldset > legend').each(function (index, legend) {
			var newdiv = $('<div />').insertAfter(legend).addClass('field-list');
			newdiv.append($(legend).parent('fieldset').find('*:not(legend,div,span)'));
		});

	};

	/*
	* remove empty wrappers
	*/
	removeEmptyWrappers = function (items) {
		$('.col-box, .call-to-action, .row, .border-curved').each(function (i, box) {
			if ($(box).children().length == 0) {
				$(box).remove();
			}
		});
	}

	/*
	* switch between tabs
	*/
	initTabs = function () {
		var $tabs = $('.tabs-holder').not($('.tabs-settings')).tabs();

		$('.tab-nav').each(function (i, tabnav) {
			$(tabnav).find('.readmore').click(function (e) {
				e.preventDefault();
				$tabs.tabs('select', i + 1);
				$(window).scrollTop($('.tabs-holder').offset().top - 25);
			});

			$(tabnav).find('.return').click(function (e) {
				e.preventDefault();
				$tabs.tabs('select', i - 1);
				$(window).scrollTop($('.tabs-holder').offset().top - 25);
			});
		});

	}

	/*
	* skip empty rows in machine-compare-view
	*/
	skipEmptyMachineRows = function () {

		var machines = [];

		$('.machine-details-holder').each(function (i, item) {
			if ($(item).find('ul.machine-details > li').length > 0) {
				machines.push($(item).find('ul.machine-details > li'));
			}
		});

		if (machines[0]) {

			var totalRows = machines[0].length;
			if (totalRows) {
				for (var j = 0; j < totalRows; j++) {

					var empty = 0;
					for (var i = 0; i < machines.length; i++) {
						if ($(machines[i][j]).data('value') == 'none') {
							empty++;
						}
					}

					if (empty == machines.length) {
						for (var i = 0; i < machines.length; i++) {
							$(machines[i][j]).remove();
						}
					}

				}
			}
		}

	}

	/*
	* basic carousel
	* @params: $elViewport - element containing the carousel
	* @params: $elList - element containing the carousel items 
	* @params: $arrItems - array of carousel items
	*/
	carousel = function ($elViewport, $elList, $arrItems) {

		var currentSlide = 0;
		var viewportWidth = $arrItems.outerWidth(true) * $arrItems.length;
		var slideX = $elViewport.outerWidth(true);
		var maxSlides = Math.ceil((viewportWidth / slideX)) - 1;

		var $prev = $('.carousel .prev');
		var $next = $('.carousel .next');

		if (maxSlides < 1) {
			$prev.remove();
			$next.remove();
			return false;
		}

		$elList.css('width', viewportWidth);

		function prevSlide() {
			currentSlide -= 1;

			if (currentSlide == 0) $prev.addClass('disabled');
			$next.removeClass('disabled');

			$elList.animate({
				'left': '+=' + slideX
			});
		}

		function nextSlide() {
			currentSlide += 1;

			if (currentSlide == maxSlides) $next.addClass('disabled');
			$prev.removeClass('disabled');

			$elList.animate({
				'left': '-=' + slideX
			});
		}

		$prev.on('click', function () {
			if (currentSlide != 0) {
				prevSlide();
				$next.removeClass('disabled');
			}
		});

		$next.on('click', function () {
			if (currentSlide != maxSlides) {
				nextSlide();
				$prev.removeClass('disabled');
			}
		});

		var maxH = 0;
		$arrItems.each(function (index, item) {
			if ($(item).outerHeight(true) > maxH) maxH = $(item).outerHeight(true);

			if ($(item).hasClass('selected')) {
				currentSlide = Math.floor($(this).offset().left / slideX);
				$elList.css('left', currentSlide * slideX * -1);

				if ($(item).find('.video-thumb').length > 0) {
					// video
					$('.carousel-images-videos').find('.media-wrapper img').hide();
					$('.carousel-images-videos').find('.media-wrapper .media-wrapper-video').show();
					$('.carousel-images-videos').find('.media-wrapper .media-wrapper-video').html('<div id="carousel-mediaplayer" class="video jw-wrapper">' + $(this).html().replace('<span></span>', '') + '</div>');
					initJwPlayer();
					$('.carousel-images-videos').find('.caption').text($(this).data('caption'));
				} else {
					// replace image
					$('.carousel-images-videos').find('.media-wrapper img').show();
					$('.carousel-images-videos').find('.media-wrapper .media-wrapper-video').hide();
					$('.carousel-images-videos').find('.media-wrapper img').attr('src', $(this).find('a').attr('href'));
					$('.carousel-images-videos').find('.caption').text($(this).data('caption'));
				}

				$arrItems.click(function () {
					$arrItems.removeClass('selected');
					$(this).addClass('selected');
				});
			}
		});

		if (currentSlide == 0) $prev.addClass('disabled');
		if (currentSlide == maxSlides) $next.addClass('disabled');

		if ($elViewport.parent().hasClass('carousel-compare')) {
			$elViewport.css('min-height', maxH + 30);
		} else {
			$elViewport.css('min-height', maxH);
		}

	}


	/*
	* add extra video options to carousel
	*/
	carouselImageVideos = function () {

		$('.carousel-images-videos').closest('html').css('overflow-y', 'hidden');

		$('.carousel-images-videos').find('.nav > li').each(function (i, item) {

			if (i == 0) {
				if ($(this).find('.video-thumb').length > 0) {
					$('.carousel-images-videos').find('.media-wrapper img').hide();
					$('.carousel-images-videos').find('.media-wrapper .media-wrapper-video').show();
				} else {
					$('.carousel-images-videos').find('.media-wrapper img').show();
					$('.carousel-images-videos').find('.media-wrapper .media-wrapper-video').hide();
				}
			}

			$(item).click(function (e) {
				e.preventDefault();

				if ($(this).find('.video-thumb').length > 0) {
					// video
					$('.carousel-images-videos').find('.media-wrapper img').hide();
					$('.carousel-images-videos').find('.media-wrapper .media-wrapper-video').show();
					$('.carousel-images-videos').find('.media-wrapper .media-wrapper-video').html('<div id="carousel-mediaplayer" class="video jw-wrapper">' + $(this).html().replace('<span></span>', '') + '</div>');
					initJwPlayer();
					$('.carousel-images-videos').find('.caption').text($(this).data('caption'));
				} else {
					// replace image
					$('.carousel-images-videos').find('.media-wrapper img').show();
					$('.carousel-images-videos').find('.media-wrapper .media-wrapper-video').hide();
					$('.carousel-images-videos').find('.media-wrapper img').attr('src', $(this).find('a').attr('href'));
					$('.carousel-images-videos').find('.caption').text($(this).data('caption'));
				}

			});
		});

	}


	/*
	* extend carousel to compare items
	*/
	checkboxCompare = function () {
		var objQs = parseQueryString();

		if (objQs.machines) {
			var machines = objQs.machines.split(','),
				i = 1;

			for (var machine in machines) {
				if (i > 3) break;

				$('.product input[data-decs-machineid]').each(function () {
					if ($(this).data('decs-machineid') == machines[machine]) $(this).prop("checked", true);
				});

				i++;
			}

			if ($('.carousel-compare').length) {
				if ($('.carousel-compare').siblings('h2').length) {
					var offset = $('.carousel-compare').siblings('h2').offset().top;
				} else {
					var offset = $('.carousel-compare').offset().top
				}

				$(window).load(function () {
					$('html, body').animate({
						scrollTop: offset
					}, 800);
				});
			}
		}

		var $arrCheckboxes = $('.carousel-compare input[type=checkbox]');
		totalChecked = $('.carousel-compare input[type=checkbox]:checked').length;

		$arrCheckboxes.on('click', function () {
			totalChecked = $('.carousel input[type=checkbox]:checked').length;
			if (totalChecked == 3) {
				$arrCheckboxes.parent().addClass('disabled');
				$arrCheckboxes.not($('.carousel input[type=checkbox]:checked')).attr('disabled', 'disabled');
			} else {
				$arrCheckboxes.parent().removeClass('disabled');
				$arrCheckboxes.removeAttr('disabled');
			}

			if ($.browser.msie && jQuery.browser.version.split('.')[0] == 8) {
				$(this).toggleClass('checked');
			}
		});


		var _href = $('.carousel-compare .button').attr('href');
		var strQuery = "";

		$('.carousel-compare .button').click(function (e) {
			e.preventDefault();

			$arrCheckboxes.each(function () {
				if ($(this).attr('checked') == 'checked') {
					strQuery += $(this).data('decs-machineid');
					strQuery += ',';
				}
			});

			window.location = _href + strQuery;
		});
	}


	/*
	* build array with necessary information for markers + infowindow
	*/
	buildMarkerArray = function () {

		var arrMarkers = [];

		if ($('.dealer-contacts > li').length) {

			$('.dealer-contacts > li').each(function (i, dealer) {

				var objDealer = {
					infowindow: $(dealer).html(),
					lat: $(dealer).data('map-lat'),
					long: $(dealer).data('map-long')
				}

				arrMarkers.push(objDealer);

			});
		}
		return arrMarkers;

	}


	/**
	* initializes searchbox in header
	*/
	initSearch = function () {

		var $Button = $('.search .search-submit'),
			$Input = $('.search input[type=text]');

		var fnSubmit = function () {
			if ($Input.val() == '') return false

			var url = $Button.attr('href') + '?q=';
			url += encodeURIComponent($Input.val());
			location.href = url;
		};

		$Button.click(function (e) {
			e.preventDefault();
			fnSubmit();
		});

		$Input.keypress(function (e) {
			if (e.which == '13' && $(this).val()) {
				e.preventDefault();
				fnSubmit();
			}
		});

	}

});