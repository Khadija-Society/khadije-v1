function chartDrawer()
{
  if($("#chartdiv").length == 1){myChart();}


}


//-------------------------------------------------------------------------------------------------------
function myChart()
{
	// Set theme
	am4core.useTheme(am4themes_animated);

	// Create chart instance
	var chart = am4core.create("chartdiv", am4charts.PieChart3D);

	// Let's cut a hole in our Pie chart the size of 40% the radius
	chart.innerRadius = am4core.percent(40);

	// Add data
	chart.data = {{chartResult|raw}};

	// Add and configure Series
	var pieSeries = chart.series.push(new am4charts.PieSeries3D());
	pieSeries.dataFields.value = "sum";
	pieSeries.dataFields.category = "hazinekard";
	pieSeries.slices.template.stroke = am4core.color("#fff");
	pieSeries.slices.template.strokeWidth = 2;
	pieSeries.slices.template.strokeOpacity = 1;

	// Disabling labels and ticks on inner circle
	pieSeries.labels.template.disabled = true;
	pieSeries.ticks.template.disabled = true;

	// Disable sliding out of slices
	pieSeries.slices.template.states.getKey("hover").properties.shiftRadius = 0;
	pieSeries.slices.template.states.getKey("hover").properties.scale = 1.1;
}