/* Main Script */

$(document).ready(function()
{
	/* Forms */

	Forms.RelativePath = 'http://cherrera.me/budget/actions/';

	Forms.Login.OnSuccess = function(data)
	{	
		var suffix;

		if ( !data.success )
			suffix = 'danger';
        else
        {
            suffix = 'success';
        
            setTimeout(function()
            {
                document.location.reload();
            }, 1000);
        }

		Alert.Init(data.message, suffix);
	};
});