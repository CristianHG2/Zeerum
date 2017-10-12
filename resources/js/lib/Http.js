class HttpClass
{
	Request(url, body, successCb, failureCb, type, alwaysCb)
	{
		if ( typeof failureCb != 'function' )
				failureCb = Http.FailureCallback;

		if ( typeof type === "undefined" )
			type = 'POST';

		if ( typeof alwaysCb === "undefined" )
			alwaysCb = function(){};

		$.ajax({
			url             : url,
			method          : type,
			data            : body,
			contentType 	: false,
			processData 	: false,
			success         : successCb,
			error	        : failureCb,
			complete		: alwaysCb
		});
	}

	FailureCallback(data)
	{
		Alert.Init('Network error: ' + data.responseText);
	}
}

var Http = new HttpClass;