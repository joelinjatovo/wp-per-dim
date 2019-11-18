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
                            <button class="btn-period" value="<?php echo $period['id']; ?>"><?php echo $period['title']; ?> / <?php echo $period['value']; ?></button>
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
<script>
jQuery(document).ready(function(){
    var indicators_data = <?php echo json_encode($indicators); ?>;
        
    // Create chart instance
    var chart = am4core.create("chartdiv", am4charts.XYChart);
        // Add data
        /*chart.data = <?php echo json_encode($datas); ?>;*/

        // Create axes
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "period";

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.min = 0;

        // Create series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = "value";
        series.dataFields.categoryX = "period";
        series.name = "Suivis";
    
    var indicator_data;
    jQuery('select.select-indicator').on('change', function() {
        var indicator_id = this.value;
        selectIndicator(indicator_id);
    });
    
    function selectIndicator(indicator_id){
        indicator_data = indicators_data[indicator_id];
        chart.data = indicator_data.periods;
        var container = jQuery('.period-buttons');
        var html = '';
        jQuery.each(indicator_data.periods, function(index, period) {
            html += '<button class="btn-period" value="'+ period.id +'">'+ period.title + " / " + period.value +'</button>&nbsp;';
        });
        container.html(html);
    }
    
    var indicator_id = jQuery('select.select-indicator').children("option:selected").val();
    selectIndicator(indicator_id);
});
</script>