function chartDrawer()
{
  if($("#chartdiv").length == 1){myChart();}


}


//-------------------------------------------------------------------------------------------------------
function myChart()
{
	am4core.useTheme(am4themes_animated);

	var data = {{chartResult|raw}};

	// Create chart instance
	var chart = am4core.create("chartdiv", am4charts.XYChart);

	// Add data
	chart.data = data;

	// Create axes
	var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
	categoryAxis.dataFields.category = "payment";
	categoryAxis.renderer.grid.template.disabled = true;

	var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
	valueAxis.title.text = "Total payed";
	valueAxis.min = 0;
	valueAxis.renderer.baseGrid.disabled = true;
	valueAxis.renderer.grid.template.strokeOpacity = 0.07;

	// Create series
	var series = chart.series.push(new am4charts.ColumnSeries());
	series.dataFields.valueY = "sum";
	series.dataFields.categoryX = "payment";
	series.tooltip.pointerOrientation = "vertical";


	var columnTemplate = series.columns.template;
	// add tooltip on column, not template, so that slices could also have tooltip
	columnTemplate.column.tooltipText = "Payment: {categoryX}\nSum: {valueY}";
	columnTemplate.column.tooltipY = 0;
	columnTemplate.column.cornerRadiusTopLeft = 20;
	columnTemplate.column.cornerRadiusTopRight = 20;
	columnTemplate.strokeOpacity = 0;


	// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
	columnTemplate.adapter.add("fill", (fill, target) => {
		var color = chart.colors.getIndex(target.dataItem.index * 3);
		return color;
	});

	// create pie chart as a column child
	var pieChart = series.columns.template.createChild(am4charts.PieChart);
	pieChart.width = am4core.percent(80);
	pieChart.height = am4core.percent(80);
	pieChart.align = "center";
	pieChart.valign = "middle";
	pieChart.dataFields.data = "pie";

	var pieSeries = pieChart.series.push(new am4charts.PieSeries());
	pieSeries.dataFields.value = "value";
	pieSeries.dataFields.category = "title";
	pieSeries.labels.template.disabled = true;
	pieSeries.ticks.template.disabled = true;
	pieSeries.slices.template.stroke = am4core.color("#ffffff");
	pieSeries.slices.template.strokeWidth = 1;
	pieSeries.slices.template.strokeOpacity = 0;

	pieSeries.slices.template.adapter.add("fill", (fill, target)=>{
	  return am4core.color("#ffffff")
	});

	pieSeries.slices.template.adapter.add("fillOpacity", (fillOpacity, target)=>{
	  return (target.dataItem.index + 1) * 0.2;
	});

	pieSeries.hiddenState.properties.startAngle = -90;
	pieSeries.hiddenState.properties.endAngle = 270;
}
