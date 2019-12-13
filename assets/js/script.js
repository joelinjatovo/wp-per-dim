jQuery(document).ready(function(){
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
            "menu": [{
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