<!DOCTYPE html>
<html>
  <head> 
  <title> Woven Wind </title>

  <link rel="shortcut icon" href="http://css.snre.umich.edu/favicon.ico" type="image/vnd.microsoft.icon" />
  <link href="http://s3.amazonaws.com/codecademy-content/courses/ltp/css/shift.css" rel="stylesheet">
  <link rel="stylesheet" href="http://s3.amazonaws.com/codecademy-content/courses/ltp/css/bootstrap.css"> 
  <link type="text/css" rel="stylesheet" href= "css/WovenWind/stylesheet.css">  
  <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  <script src="amcharts/amcharts/amcharts.js" type="text/javascript"></script>
  <script src="amcharts/amcharts/serial.js" type="text/javascript"></script>
  <script src="amcharts/amcharts/themes/light.js" type="text/javascript"></script>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

        
  <script type="text/javascript">
  
    var chart;

    $.getJSON("http://northside2.aaps.k12.mi.us/windeng/fetchData.php", function(data) {

    AmCharts.makeChart("chartdiv",
        {
          "type": "serial",
          "pathToImages": "http://cdn.amcharts.com/lib/3/images/",
          "categoryField": "event",
          "dataDateFormat": "YYYY-MM-DD HH:NN:SS",
          "plotAreaBorderAlpha": 1,
          "theme": "light",
          "categoryAxis": {
            "minPeriod": "ss",
            "parseDates": true,
            "title": "Date and Time"
          },
          "chartCursor": {
            "categoryBalloonDateFormat": "JJ:NN:SS"
          },
          "chartScrollbar": {},
          "trendLines": [],
          "graphs": [
            {
              "bullet": "round",
              "id": "AmGraph-1",
              "title": "graph 1",
              "valueField": "windspeed"
            }
          ],
          "guides": [],
          "valueAxes": [
            {
              "id": "ValueAxis-1",
              "title": "Miles Per Hour (mph)"
            }
          ],
          "allLabels": [],
          "balloon": {},
          "legend": {
            "enabled": false,
            "useGraphSettings": true
          },
          "titles": [
            {
              "bold": true,
              "color": "#000000",
              "id": "Title-1",
              "size": 15,
              "text": "Wind Speed"
            }
          ],
          "dataProvider": data
        }
      );

    AmCharts.makeChart("chartdiv2",
        {
          "type": "serial",
          "pathToImages": "http://cdn.amcharts.com/lib/3/images/",
          "categoryField": "event",
          "dataDateFormat": "YYYY-MM-DD HH:NN:SS",
          "plotAreaBorderAlpha": 1,
          "theme": "light",
          "categoryAxis": {
            "minPeriod": "ss",
            "parseDates": true,
            "title": "Date and Time"
          },
          "chartCursor": {
            "categoryBalloonDateFormat": "JJ:NN:SS"
          },
          "chartScrollbar": {},
          "trendLines": [],
          "graphs": [
            {
              "bullet": "round",
              "id": "AmGraph-1",
              "title": "graph 1",
              "valueField": "temperature"
            }
          ],
          "guides": [],
          "valueAxes": [
            {
              "id": "ValueAxis-1",
              "title": "Temperature (Celsius)"
            }
          ],
          "allLabels": [],
          "balloon": {},
          "legend": {
            "enabled": false,
            "useGraphSettings": true
          },
          "titles": [
            {
              "bold": true,
              "color": "#000000",
              "id": "Title-1",
              "size": 15,
              "text": "Temperature"
            }
          ],
          "dataProvider": data
        }
      );

 AmCharts.makeChart("chartdiv3",
        {
          "type": "serial",
          "pathToImages": "http://cdn.amcharts.com/lib/3/images/",
          "categoryField": "event",
          "dataDateFormat": "YYYY-MM-DD HH:NN:SS",
          "plotAreaBorderAlpha": 1,
          "theme": "light",
          "categoryAxis": {
            "minPeriod": "ss",
            "parseDates": true,
            "title": "Date and Time"
          },
          "chartCursor": {
            "categoryBalloonDateFormat": "JJ:NN:SS"
          },
          "chartScrollbar": {},
          "trendLines": [],
          "graphs": [
            {
              "bullet": "round",
              "id": "AmGraph-1",
              "title": "graph 1",
              "valueField": "rpm"
            }
          ],
          "guides": [],
          "valueAxes": [
            {
              "id": "ValueAxis-1",
              "title": "Rotations Per Minute (RPM)"
            }
          ],
          "allLabels": [],
          "balloon": {},
          "legend": {
            "enabled": false,
            "useGraphSettings": true
          },
          "titles": [
            {
              "bold": true,
              "color": "#000000",
              "id": "Title-1",
              "size": 15,
              "text": "Blade Speed"
            }
          ],
          "dataProvider": data
        }
      );
  });

  
/*
    // create chart
    AmCharts.ready(function() {

    // SERIAL CHART    
    chart = new AmCharts.AmSerialChart();
    chart.pathToImages = "amcharts/amcharts/images/";
    chart.dataProvider = chartData;
    chart.categoryField = "event";
    chart.dataDateFormat = "YYYY-MM-DD JJ:NN:SS";

    // AXES
    // category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.parseDates = true;
    categoryAxis.minPeriod = "ss";
    categoryAxis.dashLength = 3;
    categoryAxis.minorGridEnabled = true;
    categoryAxis.minorGridAlpha = 0.1;


    var graph1 = new AmCharts.AmGraph();
    graph1.valueField = "temperature";
    graph1.bullet = "round";
    graph1.bulletBorderColor = "#FFFFFF";
    graph1.bulletBorderThickness = 2;
    graph1.lineThickness = 2;
    graph1.lineAlpha = 0.5;
    graph1.balloonText = "[[category]]: <b>[[value]]</b>";
    chart.addGraph(graph1);

    // WRITE
    chart.write("chartdiv");

    });
*/
    </script>
  </head>
    
  <body>

  <div id="chartdiv" style="width: 600px; height: 400px; margin-top:100px; float:left;"> </div>

  <div id="chartdiv2" style="width: 600px; height: 400px; margin-top:100px; float:right;"> </div>

  <div id="chartdiv3" style="width: 600px; height: 400px; margin-top:20px; margin-bottom:100px; float:left;"> </div>

<?php

  include("dbconnect.php");

  $row = array();
  $query = array();
  $result = array();

  $query = 'SELECT * FROM sensor_data ORDER BY event DESC LIMIT 1';

  $result = mysql_query( $query );

  $row = mysql_fetch_assoc( $result );
  $phpdate = strtotime( $row['event'] );
  $event = date("m/d/y g:i A", $phpdate);
  $windspeed = $row['windspeed'];
  $temperature = $row['temperature'];
  $rpm = $row['rpm'];

  mysql_close($dbh);

?>

  <table id="data" style="float:right; margin-right:100px; margin-top:50px;">
    <thead>
        <tr>
          <th>Most Recent Sensor Data</th>
        </tr>
        <tr>
            <th>Time and Date</th>
            <th>Wind Speed</th>
            <th>Temperature</th>
            <th>Blade Speed</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $event ?></td>
            <td><?php echo $windspeed ?> mph</td>
            <td><?php echo $temperature ?> Celsius</td>
            <td><?php echo $rpm ?> rpm</td>
        </tr>
    </tbody>
  </table>

  <div class="col-md-4" style="float:right; margin-right:100px; margin-top:10px;">
    <div class="thumbnail"> 
        <img src= "http://northside2.aaps.k12.mi.us/windeng/sheep.jpg" alt="">
    </div> 
  </div> 

  <?php include('header.php'); ?>
  <?php include('footer.php'); ?>
    
  </body>

</html>
