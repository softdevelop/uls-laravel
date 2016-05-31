(function($)
{
	$.Redactor.prototype.linkPageTopic = function()
	{
		return {
			getTemplate: function()
	        {
				$template = '';
				var strOption = this.linkPageTopic.getHtmlSelectOption(window.folders);
	        	$template = $template
				            + '<div class="modal-section" id="redactor-modal-advanced">'
				            + '<span id="insert-asset-error" class="hidden error" style="float: left;">The asset exists</span>'
				            + '<label>Select Page or Topic</label>'
				            + '<select name="page-or-topic" id="page-or-topic">'
				            + strOption
				            + '</select>'
				            + '</div>';

	            return $template;
	        },
	        getHtmlSelectOption: function(folders) {
	        	var result = '';
	        	for(i in folders) {
	        		result += '<option value='+folders[i]._id+'>'+folders[i].title+'</option>';
	        		if(folders[i].children.length > 0) {
	        			for(j in folders[i].children) {
	        				result += '<option value='+folders[i].children[j]._id+'>&nbsp;&nbsp;&nbsp;&nbsp;' +folders[i].children[j].title + '</option>';
	        			}
	        		}
	        	}
	        	return result;
	        },
			init: function() {
				var button = this.button.add('linkPageOrTopic', 'Link Page Or Topic');
            	this.button.addCallback(button, this.linkPageTopic.show);
	        },
	        show: function() {
	        	this.modal.addTemplate('linkPageTopic', this.linkPageTopic.getTemplate());
	 			this.modal.load('linkPageTopic', 'Link Page or Topic', 600);
	 			this.modal.createCancelButton();
	 			var btnEdit = this.modal.createActionButton('Insert');
	            btnEdit.on('click', this.linkPageTopic.insert);
	 			this.modal.show();

	 			//go to server to get pages
	            $.ajax({
					url: window.baseUrl+'/api/help-editor/get-folder-help',
					type: 'POST',
				})
				.success($.proxy(function(data) {
					window.folderMaps = data.helpMaps;
				},this))
				.error(function(e) {
					console.log(e,'error');
				});
	        },
	        insert : function() {
	        	this.buffer.set();
	        	var helpId = $('#page-or-topic').val();
	        	var helpName = window.folderMaps[helpId];

	        	var $html = $('<a href="#'+helpId+'" onclick="goTo(\''+helpId+'\')">').text(helpName);

	        	$a = $(this.insert.node($html));
				this.caret.after($html);

	        	this.modal.close();
	        }
		};
	};

})(jQuery);