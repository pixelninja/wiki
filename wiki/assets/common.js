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
		edit.widget
			.removeClass('loading')
			.show();
		edit.nav.hide();
		save.nav.show();
	},
	
	close: function() {
		if (edit.widget) {
			edit.widget.hide();
		}
		
		edit.nav.show();
	}
};

var actions = {
	change: function() {
		var data = {};
		
		$.each(window.location.hash.substring(1).split('&'), function() {
			var properties = this.split('=', 2);
			var name, value = null;
			
			if (properties[0]) name = properties[0].replace(/\+/g, ' ');
			if (properties[1]) value = properties[1].replace(/\+/g, ' ');
			if (name == undefined) return;
			
			data[name] = value;
		});
		
		// Remove section highlights:
		$('h2.highlight, h3.highlight')
			.removeClass('highlight');
		
		// Scroll and highlight a section:
		if (data.view) {
			var section = $('#section-' + data.view.replace(/[.]/g, '-'))
				.parent()
				.addClass('highlight');
			
			$.scrollTo(section, {
				offset: {left: 0, top: -120}
			});
		}
		
		// Show editor:
		if (data.edit !== undefined) {
			actions.edit();
		}
		
		// Show viewer:
		else {
			actions.preview();
		}
	},
	
	edit: function() {
		view.widget
			.addClass('loading');
		
		if (!edit.widget) {
			$.ajax({
				url:		base_url + '/ajax/open',
				type:		'POST',
				data:		{
					'document-url':		$('#document').attr('data-document-url')
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
							disableSpellcheck: false,
							
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
		}
		
		else {
			view.close();
			edit.open();
		}
	},
	
	preview: function() {
		if (edit.widget) {
			edit.widget
				.addClass('loading');
			
			$.ajax({
				url:		base_url + '/ajax/preview',
				type:		'POST',
				data:		{
					'document-url':		$('#document').attr('data-document-url'),
					'document-content':	edit.codemirror.getCode()
				},
				dataType:	'html',
				success:	function(data) {
					$('title')
						.text($(data).attr('title'));
					view.widget
						.html($(data).html());
					
					edit.close();
					view.open();
				}
			});
		}
		
		else {
			edit.close();
			view.open();
		}
	},
	
	save: function() {
		edit.widget
			.addClass('loading');
		
		$.ajax({
			url:		base_url + '/ajax/save',
			type:		'POST',
			data:		{
				'document-url':		$('#document').attr('data-document-url'),
				'document-content':	edit.codemirror.getCode()
			},
			success:	function() {
				save.nav.hide();
				window.location.hash = 'view';
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
	
	// Wait for hash changes:
	$(window)
		.bind('hashchange', actions.change)
		.trigger('hashchange');
	
	// External links in new windows:
	$('a[rel = external]')
		.live('click', function() {
			window.open($(this).attr('href'));
			
			return false;
		});
	
	// Navigation:
	$('#document nav .save a')
		.live('click', function() {
			actions.save();
			
			return false;
		});
});