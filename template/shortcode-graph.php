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
    
    var indicator_data;
    jQuery('select.select-indicator').on('change', function() {
        var indicator_id = this.value;
        selectIndicator(indicator_id);
    });
    
    function selectIndicator(indicator_id){
        // get selected data
        indicator_data = indicators_data[indicator_id];
        
        // draw period buttons
        var container = jQuery('.period-buttons');
        var html = '';
        jQuery.each(indicator_data.periods, function(index, period) {
            html += '<button class="btn-period" value="'+ period.id +'">'+ period.title + " : " + period.value +'</button>&nbsp;';
        });
        container.html(html);
        
        // draw chart
        jQuery('#chartdiv').html('');
        var chart;
        
        if( (indicator_data.graph == 'pie') || (indicator_data.graph == 'donut')){
            chart = am4core.create("chartdiv", am4charts.PieChart);
                if(indicator_data.graph == 'donut'){
                    chart.innerRadius = am4core.percent(40);
                }
                chart.data = indicator_data.periods;
            
                // Add and configure Series
                var pieSeries = chart.series.push(new am4charts.PieSeries());
                pieSeries.dataFields.value = "value";
                pieSeries.dataFields.category = "period";
        }else{
            chart = am4core.create("chartdiv", am4charts.XYChart);
                chart.data = indicator_data.periods;

                // Create axes
                var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                categoryAxis.dataFields.category = "period";

                var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis.min = 0;
            
            if(indicator_data.graph == 'line'){
                var series = chart.series.push(new am4charts.LineSeries());
                    series.name = "Suivis";
                    series.stroke = am4core.color("#CDA2AB");
                    series.strokeWidth = 3;
                    series.dataFields.valueY = "value";
                    series.dataFields.categoryX = "period";
                    series.tooltipText = "{name}: [bold]{valueY}[/]";
            }else{
                // Create series
                var series = chart.series.push(new am4charts.ColumnSeries());
                series.dataFields.valueY = "value";
                series.dataFields.categoryX = "period";
                series.name = "Suivis";
            }
        }
        chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.menu.items = [
          {
            "label": "...",
            "menu": [
              /*{
                "label": "Image",
                "menu": [
                  { "type": "png", "label": "PNG" },
                  { "type": "jpg", "label": "JPG" },
                  { "type": "svg", "label": "SVG" },
                  { "type": "pdf", "label": "PDF" }
                ]
              }, {
                "label": "Data",
                "menu": [
                  { "type": "json", "label": "JSON" },
                  { "type": "csv", "label": "CSV" },
                  { "type": "xlsx", "label": "XLSX" },
                  { "type": "html", "label": "HTML" },
                  { "type": "pdfdata", "label": "PDF" }
                ]
              }, 
              */{
                "label": "Image", "type": "png"
              },{
                "label": "Print", "type": "print"
              }
            ]
          }
        ];
    }
    
    var indicator_id = jQuery('select.select-indicator').children("option:selected").val();
    selectIndicator(indicator_id);
});
</script>