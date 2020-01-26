function chartDrawer()
{
  if($("#servantType").length == 1){servantType();}
  if($("#placeSend").length == 1){placeSend();}


  if($("#xxx").length == 1){myChartProductPrice();}

}






function servantType()
{
  Highcharts.chart('servantType',
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
      text: 'تعداد خادمین به تفکیک نقش'
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
      name: 'نقش',
      allowPointSelect: true,
      data: {{myChart.servantType | raw}},
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





function placeSend()
{
  Highcharts.chart('placeSend',
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
      text: 'تعداد اعزام به تفکیک زائرسرا'
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
      name: 'نقش',
      allowPointSelect: true,
      data: {{myChart.placeSend | raw}},
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


//-------------------------------------------------------------------------------------------------------
function myChartProductPrice()
{

  Highcharts.chart('xxx',
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
      text: 'تعداد اعزام خادمین در یک سال گذشته'
    },
     xAxis:
    [{
        categories : {{myChart.lastYear.categories | raw}},
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
    name: '{%trans "Count"%}',
    data: {{myChart.lastYear.receive | raw}}
  }],


  }, function(_chart)
  {
    _chart.renderer.image('{{service.logo}}', 10, 5, 30, 30).attr({class: 'chartServiceLogo'}).add();
  });
}
