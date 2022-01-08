function chartDrawer()
{
  if($("#chartdiv").length == 1){myChanrtReportG();}
  if($("#chartdate").length == 1){myChanrtReportF();}

}

function myChanrtReportG()
{
  Highcharts.chart('chartdiv', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: ''
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  accessibility: {
    point: {
      valueSuffix: '%'
    }
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: {
        enabled: true,
        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
      }
    }
  },
  series: [{
    name: 'هزینه کرد',
    colorByPoint: true,
    data: $.parseJSON($('#hcartdata').html()),
  }]
}, function(_chart)
  {
    _chart.renderer.image('{{service.logo}}', 10, 5, 30, 30).attr({class: 'chartServiceLogo'}).add();
  });
}


function myChanrtReportF()
{
  Highcharts.chart('chartdate', {
  chart: {
    type: 'column'
  },
  title: {
    text: 'نمودار پرداخت به تفکیک روز'
  },




  xAxis: {
    categories: $.parseJSON($('#chartdatecategory').html()) ,
    crosshair: true
  },
  yAxis: {
    min: 0,
    title: {
      text: 'تومان'
    }
  },
  tooltip: {
    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
      '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
    footerFormat: '</table>',
    shared: true,
    useHTML: true
  },
  plotOptions: {
    column: {
      pointPadding: 0.2,
      borderWidth: 0
    }
  },
  series: [{
    name: 'تومان',
    data: $.parseJSON($('#chartdatedata').html())

  }]
});

  Highcharts.chart('chartdiv', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: ''
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  accessibility: {
    point: {
      valueSuffix: '%'
    }
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: {
        enabled: true,
        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
      }
    }
  },
  series: [{
    name: 'هزینه کرد',
    colorByPoint: true,
    data: $.parseJSON($('#hcartdata').html()),
  }]
}, function(_chart)
  {
    _chart.renderer.image('{{service.logo}}', 10, 5, 30, 30).attr({class: 'chartServiceLogo'}).add();
  });
}