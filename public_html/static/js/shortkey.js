

/**
 * [bindShortkey description]
 * @return {[type]} [description]
 */
function bindShortkey()
{
  $(document).keydown(function(_e) { event_corridor.call(this, _e)});
  // $('ul li', explorer).click(function(e)    { event_corridor(e, e.currentTarget, 'click');    });
}


/**
 * [shortkeyCallFunc description]
 * @return {[type]} [description]
 */
function shortkeyCallFunc(_elShortkey, _e)
{
    var myFuncCall = _elShortkey.attr('data-shortkey-call');
    // this shortkey has called function
    if(myFuncCall !== undefined)
    {
      myFuncCall = 'shortkey_'+ myFuncCall;
      // if function exist
      if(callFunc(myFuncCall, null, true))
      {
        callFunc(myFuncCall, _e);
        return true;
      }
      else
      {
        console.log('shortkey func is not exist!');
      }
    }
    return false;
}



/**
 * corridor of all events on keyboard and mouse
 * @param  {[type]} e     the element that event doing on that
 * @param  {[type]} _self seperated element for doing jobs on it
 * @param  {[type]} _key  the key pressed or click or another events
 * @return {[type]}       void func not returning value! only doing job
 */
function event_corridor(_e, _self, _key)
{
  if(!_key)
  {
    _key = _e.which;
  }

  _self = $(_self);
  var ctrl   = _e.ctrlKey  ? 'ctrl'  : '';
  var shift  = _e.shiftKey ? 'shift' : '';
  var alt    = _e.altKey   ? 'alt'   : '';
  var mytxt  = String(_key) + ctrl + alt + shift;
  var keyp   = String.fromCharCode(_key);
  var myFunc = 'shortkey_'+ mytxt;

  console.log(mytxt);

  var elShortkey = $('[data-shortkey= '+ mytxt +']');
  if(elShortkey.length == 1)
  {
    // this shortkey has called function
    if(shortkeyCallFunc(elShortkey, _e))
    {
      // if yse prevent default changes
      _e.preventDefault();
    }
    else
    {
      // else do some default event like click or set focus
      if(elShortkey.is('a[href], a[href] *, button, input[type=submit]'))
      {
        elShortkey.trigger("click");
        return;
      }
      else if(elShortkey.is('input, select, textarea'))
      {
        elShortkey.focus();
      }
      _e.preventDefault();
    }

  }
  else if(shortkeyCallFunc(elShortkey, _e))
  {
    // if yse prevent default changes
    _e.preventDefault();
  }



  switch(mytxt)
  {
    // ---------------------------------------------------------- Enter
    case '13':              // Enter
      break;

    case '13ctrl':          // ctrl + Enter
      break;


    // ---------------------------------------------------------- Escape
    case '27':              //Escape
      break;


    // ---------------------------------------------------------- Space
    case '32':              // space
    case '32shift':         // space + shift
    case '32ctrl':          // space + ctrl
    case '32ctrlshift':     // space + ctrl + shift

      break;


    // ---------------------------------------------------------- Page Up
    case '33':              // PageUP
    // ---------------------------------------------------------- Up
    case '38':              // up

      console.log('up');
      break;


    // ---------------------------------------------------------- Page Down
    case '34':              // PageDown
    // ---------------------------------------------------------- Down
    case '40':              // down
      break;


    // ---------------------------------------------------------- End
    case '35':              // End
      break;


    // ---------------------------------------------------------- Home
    case '36':              // Home
      break;


    // ---------------------------------------------------------- Left
    case '37':              // left
      break;


    // ---------------------------------------------------------- Right
    case '39':              // right
      break;

    // ---------------------------------------------------------- BackSpace
    case '8':               // Back Space
      break;

    // ---------------------------------------------------------- Delete
    case '46':              // delete
      var aa = $('table.productList tbody tr').length;
      var lastRow = $('table.productList tbody tr:eq(0)');
      lastRow.remove();
      calcFooterValues();
      break;


    // ---------------------------------------------------------------------- shortcut
    case '65ctrl':          // a + ctrl
      break;

    case '68shift':         // d + shift
      break;

    case '70':              // f
      break;

    case '72shift':         // h + shift (Home page)
      break;

    case '56shift':         // * | shift + 8
    case '106':             // *
      var RowCountEl = getSelectedRow();
      if(RowCountEl)
      {
        _e.preventDefault();
        var RowCountEl = RowCountEl.find('input.count');
        RowCountEl.select();
      }
      break;

    case '107':             // plus +
    case '187shift':        // plus +
      if(check_factor())
      {
        $('input[type=search]').select();
      }
      break;

    case '109':             // minus -
    case '189shift':        // minus -
      var RowDiscountEl = getSelectedRow();
      if(RowDiscountEl)
      {
        _e.preventDefault();
        var RowDiscountEl = RowDiscountEl.find('input.discount');
        RowDiscountEl.select();
      }
      break;

    case '110':             // .
    case '190':             // .
      break;

    case '112':             // f1
      break;

    case '113':             // f2
        // prevent any other change
        _e.preventDefault();
        // set sell url
        var sellUrl = '/a/sell/add';
        if($('html').attr('lang') !== undefined)
        {
          sellUrl = $('html').attr('lang')+ sellUrl;
        }
        // navigate to add new sell page
        // Navigate({ url: sellUrl });
        window.open(sellUrl, '_blank');
      break;


    case '114':             // f3
    case '114ctrl':         // f3 + ctrl
    case '70ctrl':          // f3 + ctrl
      if($('input[type=search]').length === 1)
      {
        $('input[type=search]').focus();
        _e.preventDefault();
      }
      break;

    case '115':             // f4

      break;

    case '119':             // f8

      break;

   case '122shift':         // f11 + shift
      break;

   case '123':              // f12
      break;

    // ---------------------------------------------------------------------- mouse
    case 'click':           // click
      break;

    case 'rightclick':        // Double click
      break;

    default:                // exit this handler for other keys
      return;
  }
}


function getSelectedRow()
{
  if(check_factor())
  {
    var aa = $('table.productList tbody tr').length;
    var lastRow = null;
    if(aa > 0)
    {
      var selectedRowEl = $('table.productList tbody tr [data-selected]');
      if(selectedRowEl.length == 1)
      {
        // lastRow = ...
      }
      else
      {
        lastRow = $('table.productList tbody tr:eq(0)')
      }
      return lastRow;
    }
  }
  return null;
}

function check_factor()
{
  if($('body').attr('data-page') === 'sell_add')
  {
    return true;
  }

  return false;
}


