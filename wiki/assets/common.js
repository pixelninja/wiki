var base;

var actions = {
	save: function() {
		$.ajax({
			url:		base + '/ajax/save',
			type:		'POST',
			data:		{
				'file':		$('#document').attr('data-file'),
				'raw':		edit.widget.val()
			},
			success:	function() {
				save.nav.hide();
				edit.close();
				view.open();
			}
		});
	},
	
	preview: function() {
		$.ajax({
			url:		base + '/ajax/preview',
			type:		'POST',
			data:		{
				'raw':		edit.widget.val()
			},
			dataType:	'html',
			success:	function(data) {
				view.widget.html($(data).html());
			}
		});
	}
};

var save = {
	nav: null
};

// Viewer mode:
var view = {
	widget:	null,
	nav: null,
	
	open: function() {
		view.widget.show();
		view.nav.hide();
		
		close = view.close;
	},

	close: function() {
		view.widget.hide();
		view.nav.show();
	}
};

// Editor mode:
var edit = {
	widget: null,
	nav: null,
	loaded: false,
	
	open: function() {
		if (!edit.loaded) $.ajax({
			url:		base + '/ajax/open',
			type:		'POST',
			data:		{
				'file':		$('#document').attr('data-file')
			},
			dataType:	'html',
			success:	function(data) {
				edit.loaded = true;
				edit.widget
					.val($(data).text())
					.appendTo('#document')
					.trigger('change');
			}
		});
		
		edit.widget.show();
		edit.nav.hide();
		save.nav.show();
		
		close = edit.close;
	},
	
	close: function() {
		edit.widget.hide();
		edit.nav.show();
	}
};

$(document).bind('ready', function() {
	// Find references:
	base = $('base').attr('href');
	view.widget = $('#view');
	view.nav = $('nav .view').hide();
	edit.widget = $('#edit').hide();
	edit.nav = $('nav .edit');
	save.nav = $('nav .save').hide();
	
	// Update preview:
	edit.widget
		.live('preview', actions.preview)
		
		.live('change keyup', function() {
			$(this).trigger('preview');
		});
	
	// Navigation:
	$('#document nav .view')
		.live('click', function() {
			view.open();
			edit.close();
		});
	
	$('#document nav .edit')
		.live('click', function() {
			edit.open();
			view.close();
		});
	
	$('#document nav .save')
		.live('click', actions.save);
	
	// Autosize textareas:
	$('textarea')
		.live('change keypress keyup', function() {
			var lines = this.value.split("\n").length;
			
			$(this).css('height', ((lines * 18) + 650) + 'px');
		});
});