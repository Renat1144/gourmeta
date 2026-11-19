/**
* googlemaps plugin
* @author Mirjam
* @since aug 2012
* @copyright eFocus
*/

;
(function ($) {
	$.fn.googlemaps = function (options) {
		
		// SETUP private variabls;
		var map;

		// setup options
		var defOptions = {
			mapCanvas: $('#map-canvas'),
			zoomLevel: 5,
			mapCenterLat: '52.059246', 
			mapCenterLng: '5.239563', 
			mapMarkers: [],
			customIcon: null
		}

		// globals
		var _options = $.extend(defOptions, options);
		var _allMarkers = [];
		var _infoWindow;

		// init
		initMap();

		// methods
		function initMap() {
			
			var latLng = new google.maps.LatLng(_options.mapCenterLat, _options.mapCenterLng);

			var basicMapOptions = {
				zoom: _options.zoomLevel,
				center: latLng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}

			map = new google.maps.Map(_options.mapCanvas, basicMapOptions);

			if (_options.mapMarkers.length > 0) {
				addMarkers();
				zoomToFit();
			}

		}

		function addMarkers() {
			
			$(_options.mapMarkers).each(function (i, data) {
				
				var latLng = new google.maps.LatLng(data.lat, data.long);
				
				var marker = new google.maps.Marker({
					position: latLng,
					map: map
				});

				if (_options.customIcon) {
					marker.setIcon(_options.customIcon);
				}

				google.maps.event.addListener(marker, 'click', function() {
					addInfoWindow(data, marker);
				});
				
				_allMarkers.push(marker);
			
			});

		}

		function addInfoWindow (data, marker) {
		
			if (_infoWindow) {
				_infoWindow.close();
			}

			var myOptions = {
				content: data.infowindow,
				zIndex: null,
				boxClass: 'map-info',
				closeBoxMargin: '-24px',
				alignBottom: true,
				pixelOffset: new google.maps.Size(-185, -80),
				infoBoxClearance: new google.maps.Size(100, 100)
			};
			
			_infoWindow = new InfoBox(myOptions);
			_infoWindow.open(map, marker);
		
		}

		function zoomToFit () {

			var bound = new google.maps.LatLngBounds();
			
			$(_allMarkers).each(function (i, marker) {
				bound.extend(marker.getPosition());
			});

			map.fitBounds(bound);
		
		}

		return this;
	}
})(jQuery);