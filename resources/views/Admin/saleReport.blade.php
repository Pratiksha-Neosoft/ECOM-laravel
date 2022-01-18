@section('page_title','Sales Report')
@extends('admin.master')
@section('content')
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['Asset Type', 'Active', 'Deactive'],
          <?php echo $chartDt;?>
        ]);

        var options = {
          width: 800,
          chart: {
            title: ' Bar Chart',
            subtitle: ' Number of active assets & inactive assets'
          },
          bars: 'vertical', // Required for Material Bar Charts.
          axes: {
            x: {
              active: {label: 'Active'}, // Bottom x-axis.
              deactive: {side: 'top', label: 'Deactive'} // Top x-axis.
            }
          }
        };

      var chart = new google.charts.Bar(document.getElementById('dual_x_div'));
      chart.draw(data, options);
    };
    </script>
  </head>
  <body>
    <div class="content-wrapper">
      <div class="container-fluid ">
        <div id="dual_x_div" style="width: 900px; height: 500px;" class="my-3"></div>
      </div>
    </div>
  </body>
</html>
@endsection