<html>
  <head>
    <script type="text/javascript" src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.css')}}"></link>
    <link rel="stylesheet" href="{{asset('vendor/tipsy/css/jquery.tipsy.css')}}"></link>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="{{asset('vendor/tipsy/js/jquery.tipsy.js')}}"></script>
    <script type="text/javascript">
    //geochart
      google.charts.load('current', {'packages':['geochart'],'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'});

      google.charts.setOnLoadCallback(drawRegionsMap);
      function drawRegionsMap() {

        var data = google.visualization.arrayToDataTable([
          ['City',   'Population'],
          [{v:'ID-AC', f:'Aceh'}, 4993385],
          [{v:'ID-BA', f:'Bali'}, 4148588],
          [{v:'ID-BB', f:'Bangka Belitung Islands'}, 1370331],
          [{v:'ID-BT', f:'Banten'}, 11934373],
          [{v:'ID-BE', f:'Bengkulu'}, 1872136],
          [{v:'ID-JT', f:'Jawa Tengah'}, 33753023],
          [{v:'ID-KT', f:'Kalimantan Tengah'}, 2490178],
          [{v:'ID-ST', f:'Sulawesi Tengah'}, 2872857],
          [{v:'ID-JI', f:'Jawa Timur'}, 38828061],
          [{v:'ID-KI', f:'Kalimantan Timur'}, 3422676],
          [{v:'ID-NT', f:'Nusa Tenggara Timur'}, 5112760],
          [{v:'ID-GO', f:'Gorontalo'}, 1131670],
          [{v:'ID-JK', f:'Daerah Khusus Ibukota Jakarta'}, 10154134],
          [{v:'ID-JA', f:'Jambi'}, 3397164],
          [{v:'ID-LA', f:'Lampung'}, 8109601],
          [{v:'ID-MA', f:'Maluku'}, 1683856],
          [{v:'ID-KU', f:'Kalimantan Utara'}, 639639],
          [{v:'ID-MU', f:'Maluku Utara'}, 1160275],
          [{v:'ID-SA', f:'Sulawesi Utara'}, 2409921],
          [{v:'ID-SU', f:'Sumatra Utara'}, 13923262],
          [{v:'ID-PA', f:'Daerah Khusus Papua'}, 3143088],
          [{v:'ID-RI', f:'Riau'}, 6330941],
          [{v:'ID-KR', f:'Kepulauan Riau'}, 1968313],
          [{v:'ID-SG', f:'Sulawesi Tenggara'}, 2495248],
          [{v:'ID-KS', f:'Kalimantan Selatan'}, 3984315],
          [{v:'ID-SN', f:'Sulawesi Selatan'}, 8512608],
          [{v:'ID-SS', f:'Sumatra Selatan'}, 8043042],
          [{v:'ID-JB', f:'Jawa Barat'}, 46668214],
          [{v:'ID-KB', f:'Kalimantan Barat'}, 4783209],
          [{v:'ID-NB', f:'Nusa Tenggara Barat'}, 4830118],
          [{v:'ID-PB', f:'Daerah Khusus Papua Barat'}, 868819],
          [{v:'ID-SR', f:'Sulawesi Barat'}, 1279994],
          [{v:'ID-SB', f:'Sumatra Barat'}, 5190577],
          [{v:'ID-YO', f:'Daerah Istimewa Yogyakarta'}, 3675768],
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1]);

        for (var i = 0; i < data.getNumberOfRows(); i++) {
          var countryValue = data.getValue(i, 1);
          data.setValue(i, 1, i);
          data.setFormattedValue(i, 1, countryValue);
        }

        var options = {
          region: 'ID',
          resolution:'provinces',
          colorAxis: {colors: [
                                '#0000FF',
                                '#000080',
                                '#00FFFF',
                                '#964B00',
                                '#FFD700',
                                '#00FF00',
                                '#FFFF00',
                                '#FF0000',
                                '#800000',
                                '#FFC0CB',
                                '#6F00FF',
                                '#FF7F00',
                                '#BF00FF',
                                '#8F00FF',
                                '#808000',
                                '#BDB76B',
                                '#00FF00',
                              ]
                      }
        };

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        google.visualization.events.addListener(chart, 'select', function () {
          var selection = chart.getSelection();
          var message = '';


          for (var i = 0; i < selection.length; i++) {
            var item = selection[i];
            if (item.row != null) {
              message += '{row:' + item.row + '}';
            } else if (item.column != null) {
              message += '{column:' + item.column + '}';
            }
            calculate(chart.Vl.Fn.Kf);
          }
          if (message == '') {
            message = 'nothing';
            alert('You selected ' + message);
          }
        });

        chart.draw(data, options);
      }
    </script>
    <style>
      .legend{
        display: flex;
        margin-bottom: 20px;
        margin-top: 5px;
        margin-right: 0px;
        margin-left: 40px;
      }

      .legend_one{
        display: flex;
        padding: 3px;
        font-size: 11px;
        margin-right: 8px;
      }

      .legend_icon{
        border-radius: 100%;
        height: 15px;
        width: 15px;
        margin-right:4px;
      }

      .blue{
        background: blue;
      }

      .yellow{
        background: yellow;
      }

      .red{
        background: red;
      }

      .green{
        background: green;
      }

      .bar_title {
          width: 30%;
          margin: 3%;
          text-align: center;
      }

      .legend_bar{
        display: flex;
      }

      .bar-line {
          width: 100%;
          height: 1px;
          background: #0000001f;
          margin-bottom: 56px;
      }

      .bar_abs{
        display: flex;
        position: relative;
        top: -35px;
      }

      .bar_place {
          width: 30%;
          margin: 3%;
          display: flex;
          margin-bottom: 0px;
          margin-top: 0px;
      }

      .bar {
        width: 5%;
        /* height: 156px; */
        margin: 3%;
        /* height: 10px; */
        position: absolute;
        bottom: 10px;
      }

      .first{
        margin-left: 36px;
      }

      .second{
        margin-left: 60px;
      }

      .third{
        margin-left: 84px;
      }

      .collaps-forward{
        position: absolute;
        right: 395px;
        z-index: 1;
        top: 40%;
        background: white;
        border: 1px solid #0000001c;
      }

      .collaps-backward{
        position: absolute;
        right: 0;
        z-index: 1;
        top: 40%;
        background: white;
        border: 1px solid #0000001c;
      }
    </style>
  </head>
  <body>
    <div class="">
      <div class="mapsgeo" style="display:flex">
        <div class="maps-geochart" id="maps-geochart" style="width: 70%; height: 100%;">
          <div id="regions_div" style="width: 100%; height: 100%;"></div>
        </div>
        <button class="btn collaps-forward" id="collaps-forward" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
          <i class="btn-col fas fa-forward"></i>
        </button>
        <button class="btn collaps-backward" style="display:none" id="collaps-backward" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
          <i class="btn-col fas fa-backward"></i>
        </button>
        <div class="collaps collapse show" id="collapseExample" style="width:30%; height: 100%;">
          <div class="card" style="height:100%">
            <div class="card-body">
              <div id="bar_statistic" style="width: 100%; height: 275px;">
                <div class="label-en" style="text-align:center">
                  <h4>INDONESIA</h4>
                </div>
                <div class="bar_canvas" style="height: 170px;">
                  <div class="bar-line"></div>
                  <div class="bar-line"></div>
                  <div class="bar-line"></div>
                  <div class="bar-line"></div>
                  <div class="bar_abs">
                    <div class="bar_place" id="reach">
                      <div class="bar blue jk"></div>
                      <div class="bar first yellow ma"></div>
                      <div class="bar second red pb"></div>
                      <div class="bar third green ss"></div>
                    </div>
                    <div class="bar_place" id="mention">
                      <div class="bar blue"></div>
                      <div class="bar yellow"></div>
                      <div class="bar red"></div>
                      <div class="bar green"></div>
                    </div>
                    <div class="bar_place" id="engagement">
                      <div class="bar blue"></div>
                      <div class="bar yellow"></div>
                      <div class="bar red"></div>
                      <div class="bar green"></div>
                    </div>
                  </div>
                </div>
                <div class="legend_bar" style="display:flex">
                  <div class="bar_title">
                    Reach
                  </div>
                  <div class="bar_title">
                    Mention
                  </div>
                  <div class="bar_title">
                    Engagement
                  </div>
                </div>
                <div class="legend">
                  <div class="legend_one">
                    <div class="legend_icon blue"></div>
                    <span>Jokowi</span>
                  </div>
                  <div class="legend_one">
                    <div class="legend_icon yellow"></div>
                    <span>Ma'ruf Amin</span>
                  </div>
                  <div class="legend_one">
                    <div class="legend_icon red"></div>
                    <span>Prabowo</span>
                  </div>
                  <div class="legend_one">
                    <div class="legend_icon green"></div>
                    <span>Sandiaga S Undo</span>
                  </div>
                </div>
              </div>
              <br>
              <div class="engagement">
                <div class="label-en" style="text-align:center">
                  <h4>ENGAGEMENT BY MEDIA</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

  function forward(){
    $("#maps-geochart").attr("style","width:100%;height:100%");
    google.charts.setOnLoadCallback(drawRegionsMap);
    $("#collaps-backward").removeAttr("style");
    $("#collaps-forward").attr("style","display:none");
    $("#collapseExample").attr("style","display:none");
  }

  function backward(){
    $("#maps-geochart").attr("style","width:70%;height:100%");
    google.charts.setOnLoadCallback(drawRegionsMap);
    $("#collaps-forward").removeAttr("style");
    $("#collaps-backward").attr("style","display:none");
    $("#collapseExample").removeAttr("style");
  }

  $("#collaps-forward").click(function(){
    forward();
  });

  $("#collaps-backward").click(function(){
    backward();
  })

  function calculate(provinces_id){
    backward();
    $("#collapseExample").addClass("collapse show");

    var json = 	jQuery.ajax({
       url: "{{ url('test/') }}/"+provinces_id,
       method: 'get',
       dataType: "json",
       async: false
       }).responseText;

    var data = JSON.parse(json);

    $("#bar_statistic .label-en h4").text(data.name);
    calculateReach(data.reach)
  }

  function calculateReach(data){
    var array = [data.jk,data.ma,data.pb,data.ss];
    var hight = Math.max.apply(Math,array); // 3;

    var valueJk = (data.jk/hight)*170;
    var valueMa = (data.ma/hight)*170;
    var valuePb = (data.pb/hight)*170;
    var valueSs = (data.ss/hight)*170;
    //jk
      $("#reach .jk").attr("style", "height:"+parseInt(valueJk));
      $("#reach .jk").attr("title", ""+data.jk);
    //ma
      $("#reach .ma").attr("style", "height:"+parseInt(valueMa));
      $("#reach .ma").attr("title", ""+data.ma);
    //pb
      $("#reach .pb").attr("style", "height:"+parseInt(valuePb));
      $("#reach .pb").attr("title", ""+data.pb);
    //ss
      $("#reach .ss").attr("style", "height:"+parseInt(valueSs));
      $("#reach .ss").attr("title", ""+data.ss);

    console.log(hight);
  }

  $('.bar').tipsy({

  // arrow width
  arrowWidth: 10, //arrow css border-width * 2, default is 5 * 2

  // default attributes for tipsy
  // data-tipsy-position | data-tipsy-offset | data-tipsy-disabled
  attr: 'data-tipsy',

  // custom class
  cls: null,

  // fadeIn, fadeOut animation duration
  duration: 150,

  // offset from element
  offset: 7,

  // top-left | top-center | top-right | bottom-left
  // bottom-center | bottom-right | left | right
  position: 'top-center',

  // hover | focus | click | manual
  trigger: 'hover',

  // events
  onShow: null,
  onHide: null

  })
  </script>
</html>
