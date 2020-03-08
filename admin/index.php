<?php
include "header.php";
?>
  <body>
    <div id="piechart_3d" style="width: 900px; height: 500px;"></div>
  </body>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script>
  google.charts.load("current", {
      packages: ["corechart"]
  });
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
      {
          $.post("data.php",
              function(response) {

                  console.log(typeof(response.solved));
                  var data = google.visualization.arrayToDataTable([
                      ['Questions', ''],
                      ['solved', parseInt(response.solved)],
                      ['notsolved', parseInt(response.solved)]
                  ]);
                  var options = {
                      title: 'Questions',
                      is3D: true,
                  };

                  var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                  chart.draw(data, options);

              });
      }
  }
  </script>

