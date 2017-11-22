class AlertsClass
{
	Init(text, classSuffix, dismissTime)
	{
		if ( typeof classSuffix === "undefined" )
			classSuffix = 'info';

		var alert = $('<div></div>');
		var button = $('<button class="close"><span>&times;</span></button>');

		if ( text.length < 1 )
			text = 'Empty alert';

		if ( typeof dismissTime === "undefined" )
			dismissTime = 2000;

		alert.addClass('alert alert-' + classSuffix + ' globalAlert').text(text).prepend(button);
		alert.animateCss('fadeIn');

		button.click(function()
		{
			var selfBtn = $(this);

			alert.animateCss('fadeOut', function()
			{
				selfBtn.parent().remove();
			});
		});

		$('#mainAlert .modal-body').text('Server returned an unknown response.');
		$('#mainAlert .modal-body').text(text.message);
		$("#mainAlert").modal('toggle');

		setTimeout(function()
		{
			alert.animateCss('fadeOut', function()
			{
				alert.remove();
			});
		}, dismissTime + 500);
	}
}

var Alert = new AlertsClass;
