var base_url, asset_url;

var save = {
	nav: null
};

// Viewer mode:
var view = {
	widget:	null,
	nav: null,
	
	open: function() {
		view.widget
			.removeClass('loading')
			.show();
		view.nav.hide();
	},
	
	close: function() {
		view.widget.hide();
		view.nav.show();
	}
};

// Editor mode:
var edit = {
	codemirror: null,
	widget: null,
	nav: null,
	loaded: false,
	
	open: function() {
		edit.widget.show();
		edit.nav.hide();
		save.nav.show();
	},
	
	close: function() {
		edit.nav.show();
		edit.widget.remove();
		edit.codemirror = null;
	}
};

var actions = {
	edit: function() {
		view.widget
			.addClass('loading');
		
		$.ajax({
			url:		base_url + '/ajax/open',
			type:		'POST',
			data:		{
				'file':		$('#document').attr('data-file')
			},
			dataType:	'html',
			success:	function(data) {
				edit.codemirror = new CodeMirror(
					function(widget) {
						edit.widget = $(widget)
							.hide()
							.attr('id', 'edit')
							.appendTo('#document');
					},
					{
						content: $(data).text(),
						height: 'dynamic',
						minHeight: view.widget.innerHeight(),
						
						// Switch to editor:
						onLoad: function() {
							view.close();
							edit.open();
						},
						
						// Pretty:
						autoMatchParens: true,
						continuousScanning: true,
						
						// Indenting:
						indentUnit: 4,
						reindentOnLoad: true,
						tabMode: 'shift',
						
						// Load resources:
						parserfile: [
							"parsexml.js",
							"parsecss.js",
							"tokenizejavascript.js",
							"parsejavascript.js",
							"parsehtmlmixed.js"
						],
						stylesheet: [
							asset_url + "/codemirror/css/xmlcolors.css",
							asset_url + "/codemirror/css/jscolors.css",
							asset_url + "/codemirror/css/csscolors.css"
						],
						path: asset_url + "/codemirror/js/"
					}
				);
			}
		});
	},
	
	preview: function() {
		edit.widget
			.addClass('loading');
		
		$.ajax({
			url:		base_url + '/ajax/preview',
			type:		'POST',
			data:		{
				'raw':		edit.codemirror.getCode()
			},
			dataType:	'html',
			success:	function(data) {
				view.widget
					.html($(data).html());
				
				edit.close();
				view.open();
			}
		});
	},
	
	save: function() {
		edit.widget
			.addClass('loading');
		
		$.ajax({
			url:		base_url + '/ajax/save',
			type:		'POST',
			data:		{
				'file':		$('#document').attr('data-file'),
				'raw':		edit.codemirror.getCode()
			},
			success:	function() {
				actions.preview();
			}
		});
	}
};

$(document).bind('ready', function() {
	asset_url = $('#document').attr('data-asset-url');
	base_url = $('#document').attr('data-base-url');
	
	// Find references:
	view.widget = $('#view');
	view.nav = $('nav .view').hide();
	edit.nav = $('nav .edit');
	save.nav = $('nav .save').hide();
	
	// Navigation:
	$('#document nav .view')
		.live('click', actions.preview);
	
	$('#document nav .edit')
		.live('click', actions.edit);
	
	$('#document nav .save')
		.live('click', actions.save);
});