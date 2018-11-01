<!DOCTYPE html>
<html>
<head>

	<title>Choropleth Tutorial - Leaflet</title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- <link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" /> -->

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>
		<link href="{{asset('vendor/slider/nouislider.min.css')}}" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js" integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA==" crossorigin=""></script>


	<style>
		html, body {
			height: 100%;
			margin: 0;
		}
		#map {
			width: 600px;
			height: 400px;
		}
	</style>
	<div id="slider" style="top: 0px; right: 1px; margin: 10px 25px;"></div>
	<div style="margin-right: auto; margin-left: auto; width: 90%; margin-bottom: 10px; text-align: center;">
		<input type="number" min='1' max='35675999' id="input-number-min">
		<input type="number" min='2' max='35676000' id="input-number-max">
	</div>

	<style>#map { width: 100%; height: 100%; }
.info { padding: 6px 8px; font: 14px/16px Arial, Helvetica, sans-serif; background: white; background: rgba(255,255,255,0.8); box-shadow: 0 0 15px rgba(0,0,0,0.2); border-radius: 5px; } .info h4 { margin: 0 0 5px; color: #777; }
.legend { text-align: left; line-height: 18px; color: #555; } .legend i { width: 18px; height: 18px; float: left; margin-right: 8px; opacity: 0.7; }</style>
</head>
<body>

<div id='map'></div>

<script src="{{asset('vendor/slider/nouislider.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/leaflet/test-states.js')}}"></script>

<script type="text/javascript">
	//leaflet
	var map = L.map('map').setView([-2.001075, 117.680777], 4.5);

	L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox.light'
	}).addTo(map);


	// control that shows state info on hover
	var info = L.control();

	info.onAdd = function (map) {
		this._div = L.DomUtil.create('div', 'info');
		this.update();
		return this._div;
	};

	info.update = function (props) {
		this._div.innerHTML = '<h4>Indonesia Population Density</h4>' +  (props ?
			'<b>' + props.name + '</b><br />' + props.density + ' people / mi<sup>2</sup>'
			: 'Hover over a state');
	};

	info.addTo(map);


	// get color depending on population density value
	function getColor(d) {
		return d > 1000 ? '#800026' :
				d > 500  ? '#BD0026' :
				d > 200  ? '#E31A1C' :
				d > 100  ? '#FC4E2A' :
				d > 50   ? '#FD8D3C' :
				d > 20   ? '#FEB24C' :
				d > 10   ? '#FED976' :
							'#FFEDA0';
	}

	function style(feature) {
		return {
			weight: 2,
			opacity: 1,
			color: 'white',
			dashArray: '3',
			fillOpacity: 0.7,
			fillColor: getColor(feature.properties.density)
		};
	}

	function highlightFeature(e) {
		var layer = e.target;

		layer.setStyle({
			weight: 5,
			color: '#666',
			dashArray: '',
			fillOpacity: 0.7
		});

		if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
			layer.bringToFront();
		}

		info.update(layer.feature.properties);
	}

	var geojson;

	function resetHighlight(e) {
		geojson.resetStyle(e.target);
		info.update();
	}

	function zoomToFeature(e) {
		map.fitBounds(e.target.getBounds());
	}

	function onEachFeature(feature, layer) {
		layer.on({
			mouseover: highlightFeature,
			mouseout: resetHighlight,
			click: zoomToFeature
		});
	}

  $.each(statesData.features, function(index) {
    $.extend( this , {id:index} );
    $.extend( this.properties , {name:this.properties.Propinsi} );
    $.extend( this.properties , {density:index} );
    delete this.properties.ID;
    delete this.properties.SUMBER;
    delete this.properties.Propinsi;
    delete this.properties.kode;
  });

	geojson = L.geoJson(statesData, {
		style: style,
		onEachFeature: onEachFeature
	}).addTo(map);

	// var t5 = statesData.features.slice(0,5);
	// // console.log(t5);
	// $.each(t5, function(index) {
  //   ;
	// });
	console.log(statesData);

	map.attributionControl.addAttribution('Population data &copy; <a href="http://census.gov/">US Census Bureau</a>');


	var legend = L.control({position: 'bottomright'});

	legend.onAdd = function (map) {

		var div = L.DomUtil.create('div', 'info legend'),
			grades = [0, 10, 20, 50, 100, 200, 500, 1000],
			labels = [],
			from, to;

		for (var i = 0; i < grades.length; i++) {
			from = grades[i];
			to = grades[i + 1];

			labels.push(
				'<i style="background:' + getColor(from + 1) + '"></i> ' +
				from + (to ? '&ndash;' + to : '+'));
		}

		div.innerHTML = labels.join('<br>');
		return div;
	};

	legend.addTo(map);
	

	//noUiSlider

		var slidervar = document.getElementById('slider');
		noUiSlider.create(slider, {
			start: [1,35676000],
			connect: true,
			range: {
				min: [1],
				max: [35676000]
			}
		});

		document.getElementById('input-number-min').setAttribute("value", 1);
		document.getElementById('input-number-max').setAttribute("value", 35676000);

		var inputNumberMin = document.getElementById('input-number-min');
		var inputNumberMax = document.getElementById('input-number-max');
		inputNumberMin.addEventListener('change', function(){
		    slidervar.noUiSlider.set([this.value, null]);
		});
		inputNumberMax.addEventListener('change', function(){
		    slidervar.noUiSlider.set([null, this.value]);
		});

		slidervar.noUiSlider.on('update', function( values, handle ) {
	    //handle = 0 if min-slider is moved and handle = 1 if max slider is moved
	    if (handle==0){
		        document.getElementById('input-number-min').value = values[0];
		    } else {
		        document.getElementById('input-number-max').value =  values[1];
		    }
		//we will definitely do more here...wait
		});

		rangeMin = document.getElementById('input-number-min').value;
		rangeMax = document.getElementById('input-number-max').value;

		//first let's clear the layer:
		cluster_popplaces.clearLayers();
		//and repopulate it
		popplaces = new L.geoJson(exp_popplaces,{
		    onEachFeature: pop_popplaces,
		        filter:
		            function(feature, layer) {
		                 return (feature.properties.pop_max <= rangeMax) && (feature.properties.pop_max >= rangeMin);
		            },
		    pointToLayer: popplaces_marker
		})
		//and back again into the cluster group
		cluster_popplaces.addLayer(popplaces);

</script>



</body>
</html>
