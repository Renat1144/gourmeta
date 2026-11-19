/**
* collection of functions used in product templates
* The function found here are very specific for dutch DECS websits and 
* parts of the code may not work with other CMS's/backends (for example the querystring)
* 
*
* @author Mirjam
* @author Lowen
* @since july 2012
* @copyright eFocus
*/


jQuery.noConflict();

jQuery(function ($) {

	/* 
	* select up to 3 checkboxes, show a toolbox with a button that redirects 
	* to the comparison tool page with a querystring
	*/
	initProductOverview = function () {
		//Parses querystring and returns it as an object with key/value pairs.
		var objQs = parseQueryString();

		if (objQs.dispensers) {
			var dispensers = objQs.dispensers.split(','),
				i = 1;

			for (var machine in dispensers) {
				if (i > 3) break;

				$('.product input[data-decs-machineid]').each(function () {
					if ($(this).data('decs-machineid') == dispensers[machine]) $(this).prop("checked", true);
				});

				i++;
			}

			//unbind print functionality to replace with url for comparison tool
			if ($('.print-link').length) {
				$('.print-btn').unbind('click');
				$('.print-btn').attr('href', $('.print-link').attr('href'))
			}
		}

		// toggle filter on/off
		$('.product-filter').find('h2').click(function (e) {
			e.preventDefault();
			$(this).closest('.product-filter').toggleClass('open');
		});

		// compare checkboxes: check or uncheck
		$('.product-list').find('input:checkbox').click(function () {
			checkProducts();
			if ($(this).is(':checked') == true) {
				showProductToolbox($(this));
				bindProductToolbox($(this));
			} else {
				unbindProductToolbox($(this));
			}
		});

		// bind inputs
		$('.product-list').find('input:checkbox:checked').each(function (i, el) {
			bindProductToolbox($(this));
		});

		checkProducts();
		unbindProductToolbox($('.product-list').find('input:checkbox').not('input:checkbox:checked'));

		var _href = $('.product-toolbox .button').attr('href');

		$('.product-toolbox').click(function (e) {
			e.preventDefault();
			
			var ids = [];
			$('.product-list').find('input:checkbox:checked').each(function () {
				ids.push($(this).data('decs-machineid'));
			});
			
			//go to location+querystring
			window.location = _href + "?dispensers=" + ids.join(',');
		});
	};

	/*
	* check if not more then 3 products are checked
	*/
	checkProducts = function () {
		if ($('.product-toolbox').length == 0) return;

		if ($('.product-list').find('input:checkbox:checked').length == 3) {
			$('.product-list').find('input:checkbox:not(:checked)').attr('disabled', true);
			$('.product-list').find('input:checkbox:not(:checked)').addClass('disabled');
		} else if ($('.product-list').find('input:checkbox:checked').length < 3) {
			$('.product-list').find('input:checkbox').removeAttr('disabled');
			$('.product-list').find('input:checkbox:not(:checked)').removeClass('disabled');
		}
	};

	//binds the checkboxes to show the producttoolbox
	bindProductToolbox = function (el) {
		$(el).parents('.product').mouseenter(function () {
			showProductToolbox(el);
		});

		$(el).closest('div.product').mouseleave(function () {
			$('.product-toolbox').css('left', -30);
			$('.product-toolbox').hide();
		});
	};

	//unbinds the producttoolbox when unchecked
	unbindProductToolbox = function (el) {
		$(el).parents('.product').unbind('mouseenter');
	};

	//shows producttoolbox and sets position
	showProductToolbox = function (el) {
		$('.product-toolbox').appendTo($(el).closest('div.product'));
		$('.product-toolbox').show();

		$('.product-toolbox').find('ul').empty();
		$('.product-list').find('input:checkbox:checked').each(function (i, el) {
			$('<li>' + $(el).closest('div.product').find('h3').text() + '</li>').appendTo($('.product-toolbox').find('ul'));
		});

		$('.product-toolbox').css('top', el.parent().position().top - $('.product-toolbox').outerHeight() - 10);
		$('.product-toolbox').css('left', -12);
	};

});