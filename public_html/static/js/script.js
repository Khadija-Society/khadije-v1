

route('*', function()
{

}).once(function()
{
	bindFunctions();
});

$(function()
{

});


function bindFunctions()
{
	$('.donateProduct input[data-price]').on('input', function()
	{
		calcDonateProductTotalPrices();
	});
}



function calcDonateProductTotalPrices()
{
	var TotalPrice = 0;
	$('.donateProduct input[data-price]').each(function()
	{
		var thisProductPrice = $(this).attr('data-price');
    	if(isNaN(thisProductPrice))
    	{
    		thisProductPrice = 0;
    	}

		var thisProductTotal = $(this).val() * thisProductPrice;
    	if(isNaN(thisProductPrice))
    	{
    		thisProductTotal = 0;
    	}
    	// $(this).parents('.input').find('.addon').text(fitNumber(thisProductTotal));
    	TotalPrice += thisProductTotal;

	});

	$('#totalAmount').val(TotalPrice);
}