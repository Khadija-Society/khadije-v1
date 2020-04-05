function chartDrawer()
{
  if($("#chartdiv").length == 1){myChartProductPrice();}

}


//-------------------------------------------------------------------------------------------------------
function myChartProductPrice()
{

  Highcharts.chart('chartdiv',
  {
    chart:
    {
      zoomType: 'x',
      style:
      {
        fontFamily: 'IRANSans, Tahoma, sans-serif'
      }
    },
    title:
    {
      text: '{%trans "Count Send and Receive sms per day"%}'
    },
     xAxis:
    [{
        categories : {{myChart.master.categories | raw}},
        crosshair: true
    }],
    credits:
    {
        text: '{{service.title}}',
        href: '{{service.url}}',
        position:
        {
            x: -35,
            y: -7
        },
        style: {
            fontWeight: 'bold'
        }
    },
    yAxis: [{ // Primary yAxis
      labels: {
        format: '{value}',
        style: {
          color: Highcharts.getOptions().colors[0]
        }
      },
      title: {
        text: '{%trans "Count"%}',
        useHTML: Highcharts.hasBidiBug,
        style: {
          color: Highcharts.getOptions().colors[0]
        }
      }
    }],
    tooltip: {
      useHTML: true,
      borderWidth: 0,
      shared: true
    },
    legend: {
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle',
      backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || 'rgba(255,255,255,0.25)'
    },
    exporting:
    {
      buttons:
      {
        contextButton:
        {
          menuItems:
          [
           'printChart',
           'separator',
           'downloadPNG',
           'downloadJPEG',
           'downloadSVG'
          ]
        }
      }
    },
    series: [{
    name: '{%trans "Send by panel"%}',
    data: {{myChart.master.sendpanel | raw}}
  },{
    name: '{%trans "Send"%}',
    data: {{myChart.master.send | raw}}
  }, {
    name: '{%trans "Receive"%}',
    data: {{myChart.master.receive | raw}}
  }],


  }, function(_chart)
  {
    _chart.renderer.image('{{service.logo}}', 10, 5, 30, 30).attr({class: 'chartServiceLogo'}).add();
  });
}
