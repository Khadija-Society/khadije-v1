function chartDrawer()
{
  if($("#chartdiv").length == 1){myChartProductPrice();}
  if($("#sendstatuschart").length == 1){sendstatuschart();}
  if($("#receivestatuschart").length == 1){receivestatuschart();}

  if($("#recommendchart").length == 1){recommendchart();}
  if($("#groupchart").length == 1){groupchart();}

    fetch('{{url.this}}?mydata=ansertime').then(function(response) {return response.json()}).then(function(data){$("#myAnsertTimeHour").text(fitNumber(data.hour)); $("#myAnsertTimeMin").text(fitNumber(data.min));});

}


function ajaxreport()
{
  // Chart
var options = {
  chart: {
    type: 'spline',
    events: {
      load: getData
    }
  },
  title: {
    text: 'Live Bitcoin Price'
  },
  xAxis: {
    type: 'datetime',
  },
  yAxis: {
    title: {
      text: 'Price (USD)'
    }
  },
  legend: {
    enabled: false
  },
  exporting: {
    enabled: false
  },
  series: [{
    name: 'Live Bitcoint Price [USD]',
    data: []
  }]
};
var chart = Highcharts.chart('container', options)


}



function sendstatuschart()
{
  SsmsappReportSendStatusChart = Highcharts.chart('sendstatuschart',
  {
    chart: {
      zoomType: 'x',
      style: {
        fontFamily: 'IRANSans, Tahoma, sans-serif'
      },
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie',
      events: {
       load: getData_statusChart
      }
    },
    title: {
      text: '{%trans "Send status chart"%}'
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
      name: '{%trans "Send status"%}',
      allowPointSelect: true,
      // data: {{myChart.send | raw}},
      data: [],
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



// Data
function getData_statusChart() {

  fetch('{{url.this}}?getchart=sendstatus').then(function(response) {
    return response.json()
  }).then(function(data) {
    SsmsappReportSendStatusChart.addSeries({
        name: '{%trans "Send status"%}',
        allowPointSelect: true,
        data: data,
        tooltip: {
        valueSuffix: ' {%trans "Count"%}'
        },
      showInLegend: true
      })
    });
}


function receivestatuschart()
{
  ReceiveStatusChartData = Highcharts.chart('receivestatuschart',
  {
    chart: {
      zoomType: 'x',
      style: {
        fontFamily: 'IRANSans, Tahoma, sans-serif'
      },
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie',
       events: {
       load: getData_receiveStatus
      }
    },
    title: {
      text: '{%trans "Receive status chart"%}'
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
      name: '{%trans "Receive status"%}',
      allowPointSelect: true,
      // data: {{myChart.receive | raw}},
      data : [],
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



// Data
function getData_receiveStatus() {

  fetch('{{url.this}}?getchart=receivestatus').then(function(response) {
    return response.json()
  }).then(function(data) {
    ReceiveStatusChartData.addSeries(

       {
      name: '{%trans "Receive status"%}',
      allowPointSelect: true,
      // data: {{myChart.receive | raw}},
        data: data,
      tooltip: {
        valueSuffix: ' {%trans "Count"%}'
      },
      showInLegend: true
    })
    });
}




function recommendchart()
{
  Chartrecommendchart = Highcharts.chart('recommendchart',
  {
    chart: {
      zoomType: 'x',
      style: {
        fontFamily: 'IRANSans, Tahoma, sans-serif'
      },
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie',
      events: {
       load: getData_recommand
      }
    },
    title: {
      text: '{%trans "Sms count group by recommend title"%}'
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
      name: '{%trans "Recommended"%}',
      allowPointSelect: true,
      data: [],
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


// Data
function getData_recommand() {

  fetch('{{url.this}}?getchart=recommend').then(function(response) {
    return response.json()
  }).then(function(data) {
    Chartrecommendchart.addSeries(

      {
      name: '{%trans "Recommended"%}',
      allowPointSelect: true,
      data: data,
      tooltip: {
        valueSuffix: ' {%trans "Count"%}'
      },
      showInLegend: true
    })
    });
}


function groupchart()
{
  GroupChartData = Highcharts.chart('groupchart',
  {
    chart: {
      zoomType: 'x',
      style: {
        fontFamily: 'IRANSans, Tahoma, sans-serif'
      },
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie',
       events: {
       load: getData_group
      }
    },
    title: {
      text: '{%trans "Sms count group by group title"%}'
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
      name: '{%trans "Group chart"%}',
      allowPointSelect: true,
      data: [],
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


// Data
function getData_group() {

  fetch('{{url.this}}?getchart=group').then(function(response) {
    return response.json()
  }).then(function(data) {
    GroupChartData.addSeries(
{
      name: '{%trans "Group chart"%}',
      allowPointSelect: true,
      data: data,
      tooltip: {
        valueSuffix: ' {%trans "Count"%}'
      },
      showInLegend: true
    })
    });
}



//-------------------------------------------------------------------------------------------------------
function myChartProductPrice()
{

  MyChartCountYear =  Highcharts.chart('chartdiv',
  {
    chart:
    {
      zoomType: 'x',
      style:
      {
        fontFamily: 'IRANSans, Tahoma, sans-serif'
      },
       events: {
       load: getData_count
      }
    },
    title:
    {
      text: '{%trans "Count Send and Receive sms per day"%}'
    },
     xAxis:
    [{
        categories : [],
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
    data: []
  },{
    name: '{%trans "Send"%}',
    data: []
  }, {
    name: '{%trans "Receive"%}',
    data: []
  }],


  }, function(_chart)
  {
    _chart.renderer.image('{{service.logo}}', 10, 5, 30, 30).attr({class: 'chartServiceLogo'}).add();
  });
}




// Data
function getData_count() {

  fetch('{{url.this}}?getchart=count').then(function(response) {
    return response.json()
  }).then(function(data) {
    MyChartCountYear.addSeries({name: '{%trans "Send by panel"%}',data: data['sendpanel']});
    MyChartCountYear.addSeries({name: '{%trans "Send"%}',data: data['send']});
    MyChartCountYear.addSeries({name: '{%trans "Receive"%}',data: data['receive']});
    MyChartCountYear.xAxis.push({categories : data.categories, crosshair: true});

    });
}

