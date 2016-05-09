/*! Burnthouse Theme - v0.0.1
 * https://taylorlovett.com
 * Copyright (c) 2016; * Licensed GPLv2+ */
( function( $, window, undefined ) {
	'use strict';

	var $content = $( '.content' );
	var $menu = $( '.main-menu' );
	var $body = $( 'body' );
	var autoStart = true;

	function linkClick(event) {
		event.preventDefault();
		event.stopPropagation();

		var newPage = event.currentTarget.getAttribute('href');

		switchToPage(newPage);
		history.pushState(null, null, newPage);
		return false;
	}

	$menu.on( 'click', 'a', linkClick );
	$body.on( 'click', '.ajax-link', linkClick );
	$body.on( 'click', '#toggleAutoPlayBtn', function() {
		if(autoStart) {
			$(this).html('Play Slideshow');
		} else {
			$(this).html('Pause Slideshow');
		}
		autoStart = !autoStart;

		$('.royalSlider').royalSlider('toggleAutoPlay');
	});

	function switchToPage(path) {
		path = path || window.location.pathname;

		$content.addClass( 'loading' );
		$content.html('');

		$.ajax({
			url: bh.ajaxurl,
			method: 'post',
			data: {
				action: 'bh_switch_to_page',
				path: path
			}
		}).done(function(response) {
			$content.html(response);
			$('.royalSlider').royalSlider({
				template:'default',
				image_generation:{
					lazyLoading:!0,
					imageWidth:'',
					imageHeight:'',
					thumbImageWidth:96,
					thumbImageHeight:72
				},
				thumbs:{
					paddingBottom:4,
					thumbWidth:96,
					thumbHeight:72,
					appendSpan:!0
				},
				autoPlay:{
					enabled:1,
					stopAtAction: 0,
					pauseOnHover:0
				},
				fullscreen:{enabled:0,nativeFS:0},
				video:{forceMaxVideoCoverResolution:'standard'},
				width:'100%',
				height:500,
				autoScaleSlider:!0,
				autoScaleSliderWidth:960,
				autoScaleSliderHeight:850,
				controlNavigation:'thumbnails',
				arrowsNavHideOnTouch:!0,
				globalCaptionInside:!0,
				keyboardNavEnabled:!0,
				fadeinLoadedSlide:!1
			});

			wp.ccf.setupDOM();
			
			$content.removeClass( 'loading' );
		});
	}

	switchToPage();

	window.initMap = function() {
		var map = new google.maps.Map(document.getElementById('map'), {
			center: { lat: 37.679473, lng: -34.628906 },
			zoom: 3
		});

		var star = {
			path: 'M 125,5 155,90 245,90 175,145 200,230 125,180 50,230 75,145 5,90 95,90 z',
			fillColor: '#F75C50',
			fillOpacity: 1,
			scale: 0.1,
			strokeColor: 'red',
			strokeWeight: 1
		};

		var bermuda = new google.maps.Marker({
			position: { lat: 32.307800, lng: -64.750500 },
			map: map,
			icon: star,
			title: 'Bermuda'
		});

		var miami = new google.maps.Marker({
			position: { lat: 25.761680, lng: -80.191790 },
			map: map,
			title: 'Miami'
		});

		var toronto = new google.maps.Marker({
			position: { lat: 43.653226, lng: -79.383184 },
			map: map,
			title: 'Toronto'
		});

		var milan = new google.maps.Marker({
			position: { lat: 45.465422, lng: 9.185924 },
			map: map,
			title: 'Milan'
		});

		var london = new google.maps.Marker({
			position: { lat: 51.507351, lng: -0.127758 },
			map: map,
			title: 'London'
		});

		var munich = new google.maps.Marker({
			position: { lat: 48.135125, lng: 11.581981 },
			map: map,
			title: 'Munich'
		});

		var dc = new google.maps.Marker({
			position: { lat: 38.907192, lng: -77.036871 },
			map: map,
			title: 'Washington DC'
		});

		var nyc = new google.maps.Marker({
			position: { lat: 40.712784, lng: -74.005941 },
			map: map,
			title: 'New York City'
		});

		var chicago = new google.maps.Marker({
			position: { lat: 41.878114, lng: -87.629798 },
			map: map,
			title: 'Chicago'
		});

		bermuda.addListener('click', function() {
			var infowindow = new google.maps.InfoWindow({
				content: 'Bermuda'
			});

			infowindow.open(map, bermuda);
		});

		miami.addListener('click', function() {
			var infowindow = new google.maps.InfoWindow({
				content: 'Miami: 3 hour flight. 1033 miles | 1633 Km'
			});

			infowindow.open(map, miami);
		});

		toronto.addListener('click', function() {
			var infowindow = new google.maps.InfoWindow({
				content: 'Toronto: 2.75 hour flight. 1130 miles | 1795 Km'
			});

			infowindow.open(map, toronto);
		});

		milan.addListener('click', function() {
			var infowindow = new google.maps.InfoWindow({
				content: 'Milan: 10.5 hour flight. 3930 miles | 6320 Km'
			});

			infowindow.open(map, milan);
		});

		london.addListener('click', function() {
			var infowindow = new google.maps.InfoWindow({
				content: 'London: 7 hour flight. 3451 miles | 5555 Km'
			});

			infowindow.open(map, london);
		});

		munich.addListener('click', function() {
			var infowindow = new google.maps.InfoWindow({
				content: 'Munich: 8.5 hour flight. 4001 miles | 6438 Km'
			});

			infowindow.open(map, munich);
		});

		nyc.addListener('click', function() {
			var infowindow = new google.maps.InfoWindow({
				content: 'New York City: 2 hour flight. 770 miles | 1238 Km'
			});

			infowindow.open(map, nyc);
		});

		dc.addListener('click', function() {
			var infowindow = new google.maps.InfoWindow({
				content: 'Washington DC: 2 hour flight. 824 miles | 1326 Km'
			});

			infowindow.open(map, dc);
		});

		chicago.addListener('click', function() {
			var infowindow = new google.maps.InfoWindow({
				content: 'Chicago: 3.5 hour flight. 1418 miles | 2281 Km'
			});

			infowindow.open(map, chicago);
		});
	};
} )( jQuery, this );
