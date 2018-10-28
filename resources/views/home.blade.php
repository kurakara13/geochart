<html>
  <head>
    <script type="text/javascript" src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {
        'packages':['geochart'],
        // Note: you will need to get a mapsApiKey for your project.
        // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
        'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
      });

      google.charts.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
        // $.ajaxSetup({
  			// 		headers: {
  			//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  			//     }
        //   });
  			// var json = 	jQuery.ajax({
  			// 	 url: "{{ url('test') }}",
  			// 	 method: 'get',
        //    dataType: "json",
        //    async: false
        //    }).responseText;
        //
        //  console.log(json);

        var data = new google.visualization.DataTable();
        // Add columns
        data.addColumn('string', 'id');
        data.addColumn('string', 'Capres');
        data.addColumn('number', 'Popularity');
        // data.addRows([
        //   [{v:'ID-AC', f:''}], // Example of specifying actual and formatted values.
        //   [{v:'ID-BA', f:''}],
        // ]);
        data.addRows(2);
        // // data.addColumn('string', 'Province');
        // // data.addColumn('number', 'Popularity');
        data.setCell(0, 0, 'ID-AC', '');
        data.setCell(0, 1, 'Jokowi Dodo');
        data.setCell(0, 2, 200);
        data.setCell(1, 0, 'ID-AC', '');
        data.setCell(1, 1, 'Prabowo');
        data.setCell(1, 2, 200);
        // // var data = google.visualization.arrayToDataTable([
        //   ['Provinces', 'Popularity'],
        //   [{v:'ID-AC', f:'Aceh'}, 500],
        //   [{v:'ID-BA', f:'Bali'}, 700],
        // ]);

        var options = {
          region: 'ID',
          resolution:'provinces',
        };

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="regions_div" style="width: 900px; height: 500px;"></div>
  </body>
</html>
