GENTICS.Aloha.settings = {
	logLevels: {'error': true, 'warn': true, 'info': true, 'debug': false},
	errorhandling : false,
	ribbon: false,	
	"i18n": {
		"acceptLanguage": 'en-AU'
	},
	"plugins": {
	 	"com.gentics.aloha.plugins.Link": {
		  	// all links that match the targetregex will get set the target
 			// e.g. ^(?!.*aloha-editor.com).* matches all href except aloha-editor.com
		  	targetregex:	'^(?!.*aloha-editor.com).*',
		  	// this target is set when either targetregex matches or not set
		    // e.g. _blank opens all links in new window
		  	target:			'',
		  	// the same for css class as for target
		  	cssclassregex:	'^(?!.*aloha-editor.com).*',
		  	cssclass:		'external'
		},
	 	"com.gentics.aloha.plugins.Table": {
			config:			[],
			editables:		{
				'#content':		['table']
			}
		}
  	}
};

$(document).ready(function() {
	$('#cover').aloha();
	$('#content').aloha();
}); 
