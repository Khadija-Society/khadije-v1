  function pushStateFinal()
  {
    showLastMessageWithEffect()
  }

  function showLastMessageWithEffect()
  {
    var lastOne = $('.messages .msg.lastOne');
    if(lastOne.length > 0)
    {
      $('.messages .msg.lastOne').transition('zoom');
    }
  }

  function checkLoves(_this)
  {
    var myCurrentStatus = $(_this).is(':checked');
    var myEl            = $(_this).parents('.msg').find('.meta label span');
    var myLoves         = parseInt(myEl.attr('data-val'));
    if(myCurrentStatus)
    {
      myLoves +=1;
    }
    else
    {
      myLoves -=1;
    }
    if(myLoves < 0)
    {
      myLoves = 0;
    }
    myEl.attr('data-val', myLoves);
    myEl.text(fitNumber(myLoves));
  }


