class FormsClass
{
	constructor()
	{
		var FC = this;

		FC.RelativePath = '';

		$("form.zeeforms").each(function()
		{
			var Dom = $(this);

			var Id = Dom.attr('id');
			var Action = Dom.attr('action');
			var Method = Dom.attr('method');

			if ( typeof Id === 'undefined' )
				throw Error('All ZeeForms must have an ID');

			if ( typeof Action === 'undefined' )
				throw Error('All ZeeForms must have an action attribute');

			if ( typeof Method === 'undefined' )
				throw Error('All ZeeForms must have a method attribute');

			FC[Id] =
			{
				OnSubmit 		: function(e)
				{
					e.preventDefault();

					FC[Id].Data = new FormData(Dom[0]);

					Http.Request(FC.RelativePath + Action, FC[Id].Data, FC[Id].OnSuccess, FC[Id].OnFail, Method, FC[Id].OnOutput);
				},
				OnSuccess 		: function(data)
				{
					Alert.Init(data);
				},
				OnFail 			: function(data)
				{
					Alert.Init('Error ' + data.status + ': ' + data.statusText, 'danger');
				},
				OnOutput		: function(data) { },
				Submit 			: function()
				{
					Dom.submit();
				},
				DocumentElement : Dom
			};

			var SF = FC[Id];

			$(this).on('submit', SF.OnSubmit);
		});
	}
}

var Forms;

$(document).ready(function()
{
	Forms = new FormsClass;
});