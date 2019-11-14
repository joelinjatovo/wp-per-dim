<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div>
                <label>Indicateurs</label>
                <div class="indicators">
                    <select class="select-indicator">
                        <?php foreach($indicators as $indicator): ?>
                        <option value="<?php echo $indicator['id']; ?>"><?php echo $indicator['title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div>
                <label>Periods</label>
                <div class="period-buttons">
                    <?php foreach($indicators as $indicator): ?>
                        <?php foreach($indicator['periods'] as $period): ?>
                            <button class="btn-period" value="<?php echo $period['id']; ?>"><?php echo $period['title']; ?></button>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="chartdiv" style="width: 100%; height 400px;"></div>
        </div>
    </div>
</div>
<?php print_r($indicators); ?>
<script>
jQuery(document).ready(function(){
    var indicators_data = <?php echo json_encode($indicators); ?>;
        
    // Create chart instance
    var chart = am4core.create("chartdiv", am4charts.XYChart);
        // Add data
        chart.data = <?php echo json_encode($datas); ?>;

        // Create axes
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "tracker";

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.min = 0;

        // Create series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = "value";
        series.dataFields.categoryX = "tracker";
        series.name = "Suivis";
    
    jQuery('select').on('change', function() {
        var indicator_id = this.value;
        var indicator_data = indicators_data[indicator_id];
        var container = jQuery('.period-buttons');
        //alert(indicator_data.title);
        chart.data = indicator_data.periods[0]['datas'];
        console.log(indicator_data.periods[0]['datas']);
        
    });
});
</script>