/**
 * the eTip class
 * creates styleable tooltips from standard browser tooltips on title- and alt-attributes
 *
 * @author Klaas Dieleman
 * @author Ralph Meeuws
 * @version 1.3
 * @since feb 2012
 * @copyright eFocus
 *
 * @require jQuery 1.4.2, <http://www.jquery.com>
 *
 * @param Array jQuery object elements
 * @param Object options
 *
 */
function eTip(elements, options){
	
	this.elements = elements;
		
	var opt = options || {};
		
	this.options = {
		direction		: 'left',			// default direction of eTip, from element
		delay			: 500,			// delay for eTip to show
		offset			: {x:0, y:0},	// position offset in pixels on the y-axis
		className		: 'etip',		// class name of eTip container
		altClassName	: 'etip_alt',	// additional class name of eTip container which doesn't fit in browser window
		htmlStructure	: '<div><div class="top"></div><div class="bottom"></div></div>',	// html structure of eTip, inner text is always injected as <p>, in the top of the outermost <div>
		customContent	: false,
		onCreate		: null,
		onShow			: null,
		onHide			: null,
		hideOnTipHover	: true,
		setTitle		: false			// sets title in tooltip
	};
		
	for(i in this.options) {
		if(opt[i] != undefined) {
			this.options[i] = opt[i];
		}
	}
		
	this.initialize();
		
};

eTip.prototype = {
	/**
	* sets up eTip
	*/
	initialize: function () {

		if (this.options.delay < 50) this.options.delay = 50

		if (this.options.customContent != true) this.hijackTitles();
		this.createTip();
		this.addMouseEvents();

	},

	/**
	* stores title- or alt-attribute values in elements
	* and removes the attributes from the elements and its descendants
	* @param array - optional array of elements, defaults to Class argument 'elements'
	*/
	hijackTitles: function (elements) {

		var arrElements = elements || this.elements;
		
		if (elements === undefined) return;

		arrElements.each(jQuery.proxy(function (index, element) {
			if (jQuery(element).attr('title')) {
				jQuery(element).data('title', jQuery(element).attr('title'));
				jQuery(element).removeAttr('title');
				jQuery(element).removeAttr('alt');
				jQuery(element).children().removeAttr('title');
				jQuery(element).children().removeAttr('alt');
				this.elements = this.elements.not(jQuery(element).find('*[alt]'));
				this.elements = this.elements.not(jQuery(element).find('*[title]'));
				this.elements.push(element);
			} else if (jQuery(element).attr('alt')) {
				jQuery(element).data('title', jQuery(element).attr('alt'));
				jQuery(element).removeAttr('alt');
				this.elements.push(element);
			} else if (jQuery(element).data('tiptext')) {
				this.elements.push(element);
			} else {
				this.elements = this.elements.not(jQuery(element));
			}
		}, this));

		jQuery.unique(this.elements);

	},

	/**
	* creates and injects div-element with html structure for the eTip
	*/
	createTip: function () {

		this.tip = jQuery(this.options.htmlStructure);
		this.tip.prepend('<div class="tiptitle"></div><div class="tiptext"></div>');
		this.tip.addClass(this.options.className);

		jQuery(document.body).append(this.tip);

		this.tip.css({
			'position': 'absolute',
			'z-index': '9999',
			'visibility': 'hidden',
			'left': 0,
			'top': 0,
			'right': 'auto',
			'bottom': 'auto'
		});

		if (this.options.onCreate && typeof (this.options.onCreate == 'function')) this.options.onCreate(this);

	},

	/**
	* adds mouse-events on elements and eTip
	*/
	addMouseEvents: function () {

		this.elements.each(jQuery.proxy(function (index, element) {
			jQuery(element).mouseenter(jQuery.proxy(function () {
				clearTimeout(this.delay);
				this.delay = setTimeout(jQuery.proxy(function () {
					if (this.options.customContent != true) this.setTipText(element);
					this.showTip(element);
				}, this), this.options.delay);
			}, this));

			jQuery(element).mouseleave(jQuery.proxy(function () {
				clearTimeout(this.delay);
				this.delay = setTimeout(jQuery.proxy(function () {
					this.hideTip();
				}, this), 50);
			}, this));

			if (this.options.hideOnTipHover != true) {
				this.tip.mouseenter(jQuery.proxy(function () {
					clearTimeout(this.delay);
				}, this));

				this.tip.mouseleave(jQuery.proxy(function () {
					clearTimeout(this.delay);
					this.delay = setTimeout(jQuery.proxy(function () {
						this.hideTip();
					}, this), 50);
				}, this));
			}

		}, this));

	},

	/**
	* gets left, right, top and bottom coördinates of element
	* @param element
	* @return object
	*/
	getPosition: function (element) {

		var objPos = {};

		objPos.left = jQuery(element).offset().left;
		objPos.right = jQuery(element).offset().left + jQuery(element).outerWidth();
		objPos.top = jQuery(element).offset().top;
		objPos.bottom = jQuery(window).height() - objPos.top - jQuery(element).innerHeight();

		return objPos;
	},

	/**
	* puts title of element in eTip-text
	* @param element
	*/
	setTipText: function (element) {
		this.tip.find('div.tiptext').html(jQuery(element).data('tiptext'));
		this.tip.find('div.tiptitle').html(jQuery(element).data('tiptitle'));
	},

	/**
	* positions and shows eTip
	* @param element
	*/
	showTip: function (element) {

		var pos = this.getPosition(element);

		if (pos.left == 0 || pos.top == 0 || pos.bottom == 0 || pos.right == 0) {
			this.hideTip();
			return false;
		}

		if (this.options.onShow && typeof (this.options.onShow == 'function')) this.options.onShow(element);

		this.tip.removeClass(this.options.altClassName);

		if (this.options.direction == 'up') {
			this.tip.css({
				'bottom': pos.bottom + jQuery(element).innerHeight() + this.options.offset.y,
				'top': 'auto'
			});
		} else if (this.options.direction == 'down') {
			this.tip.css({
				'bottom': 'auto',
				'top': pos.top + jQuery(element).innerHeight() + this.options.offset.y
			});
		} else if (this.options.direction == 'left') {
			this.tip.css({
				'left': pos.left - this.tip.innerWidth() - this.options.offset.x,
				'right': 'auto'
			});
		} else if (this.options.direction == 'right') {
			this.tip.css({
				'left': pos.right + this.options.offset.x,
				'right': 'auto'
			});
		}


		if (!this.isTipInWindow()) {
			this.tip.addClass(this.options.altClassName);

			if (this.options.direction == 'up') {
				this.tip.css({
					'bottom': 'auto',
					'top': pos.top + jQuery(element).innerHeight() + this.options.offset.y
				});
			} else if (this.options.direction == 'down') {
				this.tip.css({
					'bottom': pos.bottom + jQuery(element).innerHeight() + this.options.offset.y,
					'top': 'auto'
				});
			} else if (this.options.direction == 'left') {
				this.tip.css({
					'left': pos.right + this.options.offset.x,
					'right': 'auto'
				});
			} else if (this.options.direction == 'right') {
				/*
					bug with setting left css property
					first reset, then set again
				*/
				this.tip.css({ 'left': 'auto', 'right': 'auto' });
				this.tip.css({
					'left': pos.left - this.tip.innerWidth() - this.options.offset.x,
					'right': 'auto'
				});
			}

		}

		//center horizontal or vertical depending on the direction

		if (this.options.direction == 'down' || this.options.direction == 'up') {
			this.tip.css({
				'left': pos.left - this.tip.innerWidth() / 2 + this.options.offset.x,
				'right': 'auto'
			});
		} else if (this.options.direction == 'left' || this.options.direction == 'right') {
			this.tip.css({
				'top': pos.top - this.tip.innerHeight() / 2 + this.options.offset.y,
				'bottom': 'auto'
			});
		}

		this.tip.css('visibility', 'visible');
		this.tip.addClass('fade-tip');
	},

	/**
	* hides eTip
	*/
	hideTip: function () {
		if (this.options.onHide && typeof (this.options.onHide == 'function')) this.options.onHide();		

		this.tip.removeClass('fade-tip');

		setTimeout(jQuery.proxy(function() {
			this.tip.css({
				'visibility': 'hidden',
				'left': 0,
				'top': 0,
				'right': 'auto',
				'bottom': 'auto'
			});
		}, this), 250);
	},

	/**
	* checks whether eTip will be completely visible within browser window (y-axis only)
	* @return boolean
	*/
	isTipInWindow: function () {

		var blnTipInWindow = true;

		if (this.options.direction == 'up') {
			if (this.tip.offset().top < jQuery(document).scrollTop()) blnTipInWindow = false;
		} else if (this.options.direction == 'down') {
			if (this.tip.offset().top + this.tip.innerHeight() > jQuery(document).scrollTop() + jQuery(window).height()) blnTipInWindow = false;
		} else if (this.options.direction == 'left') {
			if (this.tip.offset().left < jQuery(document).scrollLeft()) blnTipInWindow = false;
		} else if (this.options.direction == 'right') {
			if (this.tip.offset().left + this.tip.innerWidth() > jQuery(document).scrollLeft() + jQuery(window).width()) blnTipInWindow = false;
		}

		return blnTipInWindow;

	},

	/**
	* public method for binding eTip to new set of elements,
	* useful after AJAX-calls etc.
	* @param array
	*/
	updateElements: function (elements) {

		if (this.options.customContent == true) {
			jQuery.extend(this.elements, elements);
		} else {
			this.hijackTitles(elements);
		}

		this.addMouseEvents();

	}
}