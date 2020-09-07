function chartDrawer()
{

  if($("#chartdivcount").length == 1){chartdivcount();}
  if($("#chartdivprice").length == 1){chartdivprice();}

}







function chartdivcount()
{
  Highcharts.chart('chartdivcount',
  {
    chart: {
      zoomType: 'x',
      style: {
        fontFamily: 'IRANSans, Tahoma, sans-serif'
      },
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie'
    },
    title: {
      text: '{%trans "Count agent type"%}'
    },
    tooltip: {
      useHTML: true,
      borderWidth: 0,
      shared: true,
      pointFormat: '{point.y}<br><b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
          enabled: true,
          // format: '<b>{point.name}</b><br> {point.percentage:.1f} %',
          useHTML: true,
          style: {
            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
          }
        }
      }
    },
    exporting:
    {
      enabled: false
    },
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
    series:
    [
    {
      name: '{%trans "Type"%}',
      allowPointSelect: true,
      data: {{reportDetail.chart_count | raw}},
      tooltip: {
        valueSuffix: ' {%trans "Count"%}'
      },
      showInLegend: true
    }]
  }, function(_chart)
  {
    _chart.renderer.image('{{service.logo}}', 10, 5, 30, 30).attr({class: 'chartServiceLogo'}).add();
  });
}








function chartdivprice()
{
  Highcharts.chart('chartdivprice',
  {
    chart: {
      zoomType: 'x',
      style: {
        fontFamily: 'IRANSans, Tahoma, sans-serif'
      },
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie'
    },
    title: {
      text: '{%trans "Total price agent type"%}'
    },
    tooltip: {
      useHTML: true,
      borderWidth: 0,
      shared: true,
      pointFormat: '{point.y}<br><b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
          enabled: true,
          // format: '<b>{point.name}</b><br> {point.percentage:.1f} %',
          useHTML: true,
          style: {
            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
          }
        }
      }
    },
    exporting:
    {
      enabled: false
    },
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
    series:
    [
    {
      name: '{%trans "Type"%}',
      allowPointSelect: true,
      data: {{reportDetail.chart_price | raw}},
      tooltip: {
        valueSuffix: ' {%trans "Count"%}'
      },
      showInLegend: true
    }]
  }, function(_chart)
  {
    _chart.renderer.image('{{service.logo}}', 10, 5, 30, 30).attr({class: 'chartServiceLogo'}).add();
  });
}
