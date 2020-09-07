function chartDrawer()
{
  if($("#chartdiv").length == 1){mapChartIran();}

}




function mapChartIran()
{

// persian translation
if($('html').attr('lang') === 'fa')
{
  Highcharts.setOptions(
  {
    lang:
    {
      contextButtonTitle: "منوی نمودار",
      decimalPoint: ",",
      downloadCSV: "دانلود سی‌اس‌وی",
      downloadJPEG: "دانولد تصویر جی‌پی‌جی",
      downloadPDF: "دانلود پی‌دی‌اف",
      downloadPNG: "دانلود تصویر پی‌ان‌جی",
      downloadSVG: "دانلود اس‌وی‌جی",
      downloadXLS: "دانلود اکسل",
      drillUpText: "بازکشت به  {series.name}",
      invalidDate: "تعریف نشده",
      loading: "در حال  بارگذاری",
      months: ["ژانویه", "فوریه", "مارچ", "آپریل", "می", "جون", "جولای", "آگوست", "سپتامبر", "اکتبر", "نوامبر", "دسامبر"],
      noData: "داده‌ای برای رسم نمودار وجود ندارد",
      printChart: "پرینت نمودار",
      resetZoom: "ریست ‌کردن بزرگنمایی",
      resetZoomTitle: "ریست سطح  بزرگنمایی به ۱:۱",
      thousandsSep: ",",
      viewData: "مشاهده جدول اطلاعات",
    }

  });
}

var data = {{reportDetail.chart_price |raw}};

// Create the chart
Highcharts.mapChart('chartdiv', {
    chart: {
        map: 'countries/ir/ir-all',
        zoomType: 'x',
        style: {
          fontFamily: 'IRANSans, Tahoma, sans-serif'
        }
    },
    title: {
        useHTML: Highcharts.hasBidiBug,
        text: '{%trans ""%}'
    },

    tooltip: {
      useHTML: true,
      borderWidth: 0,
      shared: true
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

    mapNavigation: {
        enabled: true,
        buttonOptions: {
            verticalAlign: 'bottom'
        }
    },

    colorAxis: {
        min: 0
    },

    series: [{
        data: data,
        name: '{%trans "Registered"%}',
        states: {
            hover: {
                color: '#BADA55'
            }
        },
        dataLabels: {
            style:
            {
               textOutline: false
            },
            useHTML : true,
            shadow : false,
            enabled: true,
            useHTML: Highcharts.hasBidiBug,
            format: '{point.name}'
        }
    }]
},function(_chart)
  {
    _chart.renderer.image('{{service.logo}}', 10, 5, 30, 30).attr({class: 'chartServiceLogo'}).add();
  });


}