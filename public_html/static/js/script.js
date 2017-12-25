

route('*', function()
{

}).once(function()
{
  runRunner();
  calcFooterValues();
  recalcPricePercents();
  simplePrint();
});

$(function()
{
  // run once on ready
  bindBtnOnFactor();
  // bind shortkey on each page
  callFunc('bindShortkey')
});





function recalcPricePercents()
{
  if((window.location.pathname).indexOf('/a/product') < 0 || $('#price').length === 0)
  {
    return;
  }

  // declare variables
  var elFinalPriceBox = $('#finalprice').parent().parent();
  var buy             = parseInt($('#buyprice').val().toEnglish());
  var sell            = parseInt($('#price').val().toEnglish());
  var discount        = parseInt($('#discount').val().toEnglish());
  var finalPrice      = 0;

  var impureIntrestRate = 0;
  var pureIntrestRate   = 0;
  var discountRate      = 0;
  // check and set NAN value
  if(isNaN(buy))
  {
    buy = 0;
  }
  if(isNaN(sell))
  {
    sell = 0;
  }
  if(isNaN(discount))
  {
    discount = 0;
  }

  // impureIntrestRate
  if(buy && sell)
  {
    impureIntrestRate = ((sell * 100 / buy) - 100).toFixed(2);
    pureIntrestRate   = (((sell - discount) * 100 / buy) - 100).toFixed(2);
  }
  $('#price').parent().find('.addon').text(fitNumber(impureIntrestRate) + '%');

  // Discount Rate
  if(discount && sell)
  {
    discountRate = (discount * 100 / sell).toFixed(2);
  }
  $('#discount').parent().find('.addon').text(fitNumber(discountRate) + '%');

  // final price
  finalPrice = sell - discount;
  $('#finalprice').val(finalPrice);
  elFinalPriceBox.find('.addon').text(fitNumber(pureIntrestRate) + '%');
  if(sell)
  {
    elFinalPriceBox.slideDown().removeClass('hide');
  }
  else
  {
    // elFinalPriceBox.slideUp();
  }

  // conditional check
  var elPrice      = $('#price').parents('.input');
  var elDiscount   = $('#discount').parents('.input');
  var elFinalPrice = $('#finalprice').parents('.input');

  // all check for price
  // if price is not normal and under buy price, impure under zero
  if(impureIntrestRate < 0)
  {
    elPrice.addClass('warning');
  }
  else
  {
    elPrice.removeClass('warning');
  }
  // if discount is more than 100% of sell price
  if(discount === 0)
  {
    elDiscount.removeClass('error');
    elDiscount.removeClass('warning');
  }
  else if(discountRate > 100)
  {
    elDiscount.addClass('error');
    elDiscount.removeClass('warning');
  }
  else if(sell - discount < buy)
  {
    elDiscount.removeClass('error');
    elDiscount.addClass('warning');
  }
  else
  {
    elDiscount.removeClass('error');
    elDiscount.removeClass('warning');
  }

  // all check for final price
  if(finalPrice === 0)
  {
    elFinalPrice.removeClass('error');
    elFinalPrice.removeClass('warning');
    elFinalPrice.removeClass('ok');
  }
  else if(finalPrice < 0)
  {
    elFinalPrice.addClass('error');
    elFinalPrice.removeClass('warning');
    elFinalPrice.removeClass('ok');
  }
  else if(finalPrice < buy)
  {
    elFinalPrice.removeClass('error');
    elFinalPrice.addClass('warning');
    elFinalPrice.removeClass('ok');
  }
  else
  {
    elFinalPrice.removeClass('error');
    elFinalPrice.removeClass('warning');
    elFinalPrice.addClass('ok');
  }
}


function runRunner()
{
  $('[data-run-input]').each(function()
  {
    $(this).off('input');
    $(this).on('input', function(_e)
    {
      callFunc($(this).attr('data-run-input'), $(this));
    });
  });

  $('[data-run-change]').each(function()
  {

    $(this).off('change');
    $(this).on('change', function(_e)
    {
      callFunc($(this).attr('data-run-change'), $(this));
    });
  });
}


function recalcProductListPrices(_this)
{
  calcFooterValues();
}


function calcFooterValues(_table)
{
  if(!_table)
  {
    _table = $('.productList');
    if(_table.length < 1)
    {
      return null;
    }
  }
  var calcDtCountRow    = 0;
  var calcDtSumCount    = 0;
  var calcDtSumPrice    = 0;
  var calcDtSumDiscount = 0;
  var calcDtSumTotal    = 0;
  // calc total of column
  _table.find('tbody tr').each(function()
  {
    // variables
    var tmpCount           = parseFloat($(this).find('.count').val().toEnglish());
    var tmpPrice           = parseInt($(this).find('td:eq(3)').attr('data-val'));
    var tmpDiscount        = parseInt($(this).find('.discount').val().toEnglish());
    var tmpDiscountPercent = 0;
    // check NaN values
    if(isNaN(tmpCount))
    {
      tmpCount = 0;
    }
    if(isNaN(tmpPrice))
    {
      tmpPrice = 0;
    }
    if(isNaN(tmpDiscount))
    {
      tmpDiscount = 0;
    }

    var tmpPriceCol    = tmpCount * tmpPrice;
    var tmpDiscountCol = tmpCount * tmpDiscount;
    var tmpFinalCol    = tmpCount * (tmpPrice - tmpDiscount);

    // count of row
    calcDtCountRow    += 1;
    // sum of counts
    calcDtSumCount    += tmpCount;
    calcDtSumPrice    += tmpPriceCol;
    calcDtSumDiscount += tmpDiscountCol;
    calcDtSumTotal    += tmpFinalCol;

    // set discount percent
    tmpDiscountPercent = (tmpDiscount * 100 / tmpPrice).toFixed(2);
    if($.isNumeric(tmpDiscountPercent) && tmpDiscountPercent>0 )
    {
      $(this).find('td:eq(4) .addon').text(fitNumber(tmpDiscountPercent) + '%');
    }
    else
    {
      $(this).find('td:eq(4) .addon').text('');
    }

    // set final price
    if(tmpFinalCol === 0 && !tmpPrice)
    {
      $(this).find('td:eq(5)').text('');
    }
    else
    {
      $(this).find('td:eq(5)').text(fitNumber(tmpFinalCol));
    }

    // some conditional formating
    if(tmpPrice < tmpDiscount)
    {
      $(this).find('.discount').addClass('negative');
      $(this).find('td:eq(4)').addClass('negative');
      $(this).find('td:eq(5)').addClass('negative');
    }
    else
    {
      $(this).find('.discount').removeClass('negative');
      $(this).find('td:eq(4)').removeClass('negative');
      $(this).find('td:eq(5)').removeClass('negative');
    }

  });
  // _table.find('tfoot tr th:eq(0)').text(fitNumber(calcDtCountRow));
  _table.find('tfoot tr th:eq(2)').text(fitNumber(calcDtSumCount));
  _table.find('tfoot tr th:eq(3)').text(fitNumber(calcDtSumPrice)).attr('data-val', calcDtSumPrice);
  _table.find('tfoot tr th:eq(4)').text(fitNumber(calcDtSumDiscount));
  _table.find('tfoot tr th:eq(5)').text(fitNumber(calcDtSumTotal)).attr('data-val', calcDtSumTotal);

  if(calcDtSumTotal > 0 )
  {
    _table.find('tfoot').removeClass('hide');
    $('#finalPriceString').fadeIn().removeClass('hide');
    $('#finalPriceString b').text(wordifyTomans(calcDtSumTotal))
  }
  else
  {
    $('#finalPriceString').fadeOut();
  }
}







function bindBtnOnFactor()
{
  $('body').on('barcode:detect', function(_e, _barcode)
  {
    if($('#productSearch').length < 1)
    {
      return null;
    }
    $('#productSearch').val('');
    productBarcodeFinded(_barcode)
  })

  $(document).on('input', '.count', function()
  {
    recalcProductListPrices();
  });

  $(document).on('input', '.discount', function()
  {
    recalcProductListPrices();
  });

  $(document).on('awesomplete-select', "#productSearch", function(_e)
  {
    var datalist        = $(this).data('datalist');
    var choosen         = $(this).attr('aria-activedescendant');
    var selectedProduct = [];
    choosen             = parseInt(choosen.substr(choosen.lastIndexOf("item") + 5));
    // get choosen barcode detail
    if(datalist && datalist.length > 0)
    {
      selectedProduct = datalist[choosen];
    }

    addFindedProduct(selectedProduct);
  });
  $(document).on('awesomplete-selectcomplete', "#productSearch", function(_e)
  {
    // clear product search value
    $(this).val('');
  });
}




function checkProductExist(_key, _value)
{
  // try to find this product with barcode
  switch(_key)
  {
    case 'barcode':
      var productInList = $('table tbody [data-barcode='+ _value +']');
      // if not finded in barcode, search in barcode2
      if(!productInList.length)
      {
        productInList = $('table tbody [data-barcode2='+ _value +']');
      }
      // if finded try to increase number of this product
      if(productInList.length)
      {
        return productInList;
      }
      break;

    case 'id':
      var productInList = $('table tbody [data-id='+ _value +']');
      // if finded try to increase number of this product
      if(productInList.length)
      {
        return productInList;
      }
      break;
  }
  // not finded
  return false;
}


/**
 * check conditions after finding barcode
 * @param  {[type]} _barcode [description]
 * @return {[type]}          [description]
 */
function productBarcodeFinded(_barcode)
{
  var existRecord = checkProductExist('barcode', _barcode);
  if(existRecord)
  {
    updateRecord_ProductList(existRecord, 'count');
  }
  else
  {
    searchForProduct('barcode', _barcode);
  }
}


/**
 * try to search on server
 * @param  {[type]} _key   [description]
 * @param  {[type]} _value [description]
 * @return {[type]}        [description]
 */
function searchForProduct(_key, _value)
{
  // if is not barcode and not finde02902749
  // d, search and if find, add or update
  var pSearchURL = "/a/sell/add?json=true&list=product&" + _key + "=" + _value;
  $.get(pSearchURL, function(_productData)
  {
    pData = clearJson(_productData);
    if(_productData && _productData.title)
    {
      addFindedProduct(pData, _productData.title);
    }
    else
    {
      addFindedProduct(pData);
    }
  });
}



/**
 * final function to add record of product
 * @param {[type]} _product [description]
 */
function addFindedProduct(_product, _msg)
{
  if(_product)
  {
    if(_product.id)
    {
      var existRecord = checkProductExist('id', _product.id);
      if(existRecord)
      {
        updateRecord_ProductList(existRecord, 'count');
      }
      else
      {
        addNewRecord_ProductList(null, _product);
      }
    }
    else
    {
      var msg = 'error in products.';
      notif('warn', msg);
    }
  }
  else
  {
    if(_msg)
    {
      notif('info', _msg);

    }
  }
}


/**
 * update record and increase number of exist record
 * @param  {[type]} _row   [description]
 * @param  {[type]} _key   [description]
 * @param  {[type]} _value [description]
 * @return {[type]}        [description]
 */
function updateRecord_ProductList(_row, _key, _value)
{
  switch (_key)
  {
    case 'count':
      var currentCounter = _row.find('.count');
      currentCounter.val(parseFloat(currentCounter.val())+1);
      break;
  }

  $('#productSearch').val('');
  calcFooterValues();
}


/**
 * add record to table of products
 * @param {[type]} _table   [description]
 * @param {[type]} _product [description]
 * @param {[type]} _append  [description]
 */
function addNewRecord_ProductList(_table, _product, _append)
{
  if(!_table)
  {
    _table = $('.productList');
    if(_table.length < 1)
    {
      return null;
    }
  }
  _table.parents('.cbox').fadeIn();
  _table.parents('.cbox').removeClass('hide');

  var trEmpty   = '<tr>';
  trEmpty       += '<td></td>';
  trEmpty       += '<td></td>';
  trEmpty       += '<td></td>';
  trEmpty       += '<td></td>';
  trEmpty       += '<td></td>';
  trEmpty       += '<td></td>';
  trEmpty       += '</tr>';
  var newRecord = $(trEmpty);
  var cuRow     = _table.find('tr').length - 1;
  // set row number
  newRecord.find('td:eq(0)').text(fitNumber(cuRow));
  if(_product)
  {
    var htmlPName     = _product.title + '<input type="hidden" name="products[]" class="hidden" value="' + _product.id + '">';
    var htmlPCount    = '<input class="input count" type="number" name="count[]" min=0 max=10000000000 step="any" value=1>';
    var htmlPDiscount = '<div class="input">';
    htmlPDiscount    += '<input class="discount" type="number" name="discount[]" min=0 max=10000000000';
    if(_product.discount)
    {
      htmlPDiscount += ' value="' + _product.discount + '"';
    }
    htmlPDiscount    += '>';
    htmlPDiscount    += '<span class="addon small">0%</span>'+ '</div>';

    // fill with product details
    // console.log(_product);
    newRecord.attr('data-id', _product.id);
    newRecord.attr('data-barcode', _product.barcode);
    newRecord.attr('data-barcode2', _product.barcode2);
    newRecord.find('td:eq(1)').html(htmlPName);
    newRecord.find('td:eq(2)').html(htmlPCount);
    newRecord.find('td:eq(3)').text(fitNumber(_product.price)).attr('data-val', _product.price);
    newRecord.find('td:eq(4)').html(htmlPDiscount);
    newRecord.find('td:eq(5)').text(fitNumber(_product.finalprice)).attr('data-val', _product.finalprice);
  }
  else
  {
    // empty all inputs
    newRecord.find("input").val('');
    newRecord.find('td:eq(3)').text('');
    newRecord.find('td:eq(5)').text('');
  }

  if(_append)
  {
    // appent to end of table
    newRecord.appendTo('.productList tbody');
  }
  else
  {
    // prepent to start of table
    newRecord.prependTo('.productList tbody');
  }

  calcFooterValues(_table);
}



function shortkey_print(_el)
{
  if($("#sell_clicked_btn").length)
  {
    $("#sell_clicked_btn").attr('value', 'save_print');
    $("#sell_clicked_btn").parents('form').submit();
  }
  console.log('printing...');
}


function simplePrint()
{
  if (window.location.href.indexOf("print=auto") > -1)
  {
    window.print();
    console.log('open print...');
  }
}


// Persian Wordifier
// Version: 1.0
// Author: Salman Arab Ameri
// Publish: 2014-03-11
// with use of ideas in http://www.dotnettips.info/post/626/%D8%AA%D8%A8%D8%AF%DB%8C%D9%84-%D8%B9%D8%AF%D8%AF-%D8%A8%D9%87-%D8%AD%D8%B1%D9%88%D9%81

var wordifyfa = function (num, level)
{
  'use strict';
    if (num === null) {
        return "";
  }
  // convert negative number to positive and get wordify value
  if (num<0) {
    num = num * -1;
    return "منفی " + wordifyfa(num, level);
  }
    if (num === 0) {
        if (level === 0) {
            return "صفر";
    } else {
            return "";
    }
  }
  var result = "",
    yekan = [" یک ", " دو ", " سه ", " چهار ", " پنج ", " شش ", " هفت ", " هشت ", " نه "],
    dahgan = [" بیست ", " سی ", " چهل ", " پنجاه ", " شصت ", " هفتاد ", " هشتاد ", " نود "],
    sadgan = [" یکصد ", " دویست ", " سیصد ", " چهارصد ", " پانصد ", " ششصد ", " هفتصد ", " هشتصد ", " نهصد "],
    dah = [" ده ", " یازده ", " دوازده ", " سیزده ", " چهارده ", " پانزده ", " شانزده ", " هفده ", " هیجده ", " نوزده "];
    if (level > 0) {
        result += " و ";
        level -= 1;
    }

    if (num < 10) {
        result += yekan[num - 1];
    } else if (num < 20) {
        result += dah[num - 10];
    } else if (num < 100) {
        result += dahgan[parseInt(num / 10, 10) - 2] +  wordifyfa(num % 10, level + 1);
    } else if (num < 1000) {
        result += sadgan[parseInt(num / 100, 10) - 1] + wordifyfa(num % 100, level + 1);
    } else if (num < 1000000) {
        result += wordifyfa(parseInt(num / 1000, 10), level) + " هزار " + wordifyfa(num % 1000, level + 1);
    } else if (num < 1000000000) {
        result += wordifyfa(parseInt(num / 1000000, 10), level) + " میلیون " + wordifyfa(num % 1000000, level + 1);
    } else if (num < 1000000000000) {
        result += wordifyfa(parseInt(num / 1000000000, 10), level) + " میلیارد " + wordifyfa(num % 1000000000, level + 1);
    } else if (num < 1000000000000000) {
        result += wordifyfa(parseInt(num / 1000000000000, 10), level) + " تریلیارد " + wordifyfa(num % 1000000000000, level + 1);
    }
  return result;

};

var wordifyRials = function (num)
{
  'use strict';
    return wordifyfa(num, 0) + " ریال";
};

var wordifyTomans = function (num)
{
  'use strict';
    return wordifyfa(num, 0) + " تومان";
};

var wordifyRialsInTomans = function (num)
{
  'use strict';
    if (num >= 10) {
        num = parseInt(num / 10, 10);
    } else if (num<=-10) {
        num = parseInt(num/10,10);
    } else {
    num=0;
  }

    return wordifyfa(num, 0) + " تومان";
};

if (typeof module !== 'undefined' && module.exports) {
  module.exports.wordifyfa = wordifyfa;
  module.exports.wordifyRials = wordifyRials;
  module.exports.wordifyRialsInTomans = wordifyRialsInTomans;
}


