<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <title>Create a hover effect</title>
    <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.css' rel='stylesheet' />
    <style>
        body { margin:0; padding:0; }
        #map { position:absolute; top:0; bottom:0; width:100%; }
    </style>
</head>
<body>
  <style>
  .map-overlay {
      font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
      background-color: #fff;
      box-shadow: 0 1px 2px rgba(0,0,0,0.10);
      border-radius: 3px;
      position: absolute;
      width: 25%;
      top: 10px;
      left: 10px;
      padding: 10px;
      display: none;
  }
  </style>

<div id='map'></div>
<div id='map-overlay' class='map-overlay'></div>

<script type="text/javascript" src="{{asset('vendor/leaflet/test-states.js')}}"></script>

<script>
mapboxgl.accessToken = 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v9',
    center: [-240.001075, -1.680777],
    zoom: 4.1
});
var hoveredStateId =  null;

var overlay = document.getElementById('map-overlay');

// Create a popup, but don't add it to the map yet.
var popup = new mapboxgl.Popup({
    closeButton: false
});


$.each(statesData.features, function(index) {
  $.extend( this.properties , {id:index} );
  $.extend( this.properties , {name:this.properties.Propinsi} );
  $.extend( this.properties , {population:index} );
  delete this.properties.ID;
  delete this.properties.SUMBER;
  delete this.properties.Propinsi;
  delete this.properties.kode;
});

map.on('load', function () {
    map.addSource("states", {
        "type": "geojson",
        "data": statesData
    });

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

    // The feature-state dependent fill-opacity expression will render the hover effect
    // when a feature's hover state is set to true.
    map.addLayer({
        "id": "state-fills",
        "type": "fill",
        "source": "states",
        "layout": {},
        "paint": {
            "fill-color": ['match', ['get', 'id'], // get the property
                     0, 'yellow',              // if 'GP' then yellow
                     1, 'red',               // if 'XX' then black
                     2, 'green',               // if 'XX' then black
                     3, 'blue',               // if 'XX' then black
                     4, 'black',               // if 'XX' then black
                     'white'],
            "fill-opacity": ["case",
                ["boolean", ["feature-state", "hover"], false],
                1,
                0.5
            ]
        }
    });

    map.addLayer({
        "id": "state-borders",
        "type": "line",
        "source": "states",
        "layout": {},
        "paint": {
            "line-color": "#627BC1",
            "line-width": 2
        }
    });

    console.log(map.style);

    // When the user moves their mouse over the state-fill layer, we'll update the
    // feature state for the feature under the mouse.
    map.on("mousemove", "state-fills", function(e) {
      map.getCanvas().style.cursor = 'pointer';
      var feature = e.features[0];
      console.log(feature);
      // Render found features in an overlay.
      overlay.innerHTML = '';

      // Total the population of all features
      var populationSum = feature.properties.population;

      var title = document.createElement('strong');
      title.textContent = feature.properties.name;

      var population = document.createElement('div');
      population.textContent = 'Total population: ' + populationSum.toLocaleString();

      overlay.appendChild(title);
      overlay.appendChild(population);
      overlay.style.display = 'block';

      // Display a popup with the name of the county
      popup.setLngLat(e.lngLat)
          .setText(feature.properties.name)
          .addTo(map);
    });

    // When the mouse leaves the state-fill layer, update the feature state of the
    // previously hovered feature.
    map.on("mouseleave", "state-fills", function() {
      map.getCanvas().style.cursor = '';
      popup.remove();
      overlay.style.display = 'none';
    });
});
</script>

</body>
</html>
