function chartDrawer()
{
  if($("#chartdiv").length == 1){mapChartIran();}
  if($("#chartdiv2").length == 1){highChart();}
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

  // Prepare demo data
// Data is joined to map using value of 'hc-key' property by default.
// See API docs for 'joinBy' for more info on linking data and map.
// var data = [
//     // ['ir-5428', 10000000000],
//     ['ir-hg', 0], // hormozgan
//     ['ir-bs', 0], // booshehr
//     ['ir-kb', 0], // kohgiloe and boyer ahmad
//     ['ir-fa', 0], // fars
//     ['ir-es', 0], // esfahan
//     ['ir-sm', 0], // semnan
//     ['ir-go', 0], // golestan
//     ['ir-mn', 0], // mazandaran
//     ['ir-th', 0], // tehran
//     ['ir-mk', 0], // markazi
//     ['ir-ya', 0], // yazd
//     ['ir-cm', 0], // charmahal and bakhtiyary
//     ['ir-kz', 0], // khozestan
//     ['ir-lo', 0], // lorestan
//     ['ir-il', 0], // ilam
//     ['ir-ar', 0], // ardebil
//     ['ir-qm', 0], // qom
//     ['ir-hd', 0], // hamedan
//     ['ir-za', 0], // zanjan
//     ['ir-qz', 0], // qazvin
//     ['ir-wa', 0], // west azarbayean
//     ['ir-ea', 0], // est azarbayean
//     ['ir-bk', 0], // kermanshah
//     ['ir-gi', 0], // gilan
//     ['ir-kd', 0], // kurdestan
//     ['ir-kj', 0], // khurasan jonobi
//     ['ir-kv', 0], // khurasan razavi
//     ['ir-ks', 0], // khurasan shomali
//     ['ir-sb', 0], // sistan and balochestan
//     ['ir-ke', 0], // keramn
//     ['ir-al', 0] // albors
// ];
var data = {{chartProvinceData |raw}};

// Create the chart
Highcharts.mapChart('chartdiv', {
    chart: {
        map: 'countries/ir/ir-all'
    },
    zoomType: 'x',
    style: {
      fontFamily: 'IRANSans, Tahoma, sans-serif'
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