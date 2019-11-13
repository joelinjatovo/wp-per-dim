<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="chartdiv" style="width: 100%; height 400px;"></div>
        </div>
    </div>
</div>
<script>
jQuery(document).ready(function(){
// Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart);

// Add data
chart.data = <?php echo json_encode($datas); ?>;

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "period";

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.min = 0;

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.dataFields.valueY = "value";
series.dataFields.categoryX = "period";
series.name = "Period";
});
</script>