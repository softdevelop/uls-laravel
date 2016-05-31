(function($)
{
	$.Redactor.prototype.insertpage = function()
	{
		return {
			getTemplate: function()
	        {
				$template = '';

	        	$template = $template
				            + '<div class="modal-section" id="redactor-modal-advanced">'
				            + '<div id="insert-page-error" class="hidden error" style="float: left;">Cannot insert page</div><br>'
				            + '<label>Select Page:</label>'
				            + '<input type="text" id="page-id-selected" hidden>'
				            + '<div name="pages" id="pages">'
				            // + $option
				            + '</div>'
				            // + $dropdown
				            + '<label>Link Text:</label>'
				            + '<input type="text" id="redactor-link-url-text" aria-label="Text" />'
				            + '</div>';

	            return $template;
	        },
			init: function() {
	            var button = this.button.add('insert-page', 'Insert page');
           		this.button.addCallback(button, this.insertpage.show);
           		
           		//Init event when click in redactor
           		this.core.editor().on('click.redactor', $.proxy(function(e)
				{
					$searchClass = e.target.className;

					//check if element when click is insert-page
					if($searchClass == 'insert-page') {
						//remove tooltip of redactor
						$('.redactor-link-tooltip').remove();
						// Set data in view
						var el = $(e.target);
						//get page's id
						var pageId = el.attr('content-id');

						//get page's name
						var pageName = el.text();
						//get modal show
						this.insertpage.show('edit',el);

           				setTimeout(function(){
							//set link text
							$('#redactor-link-url-text').val(pageName);

							//set id content in input hiddent
							$('#page-id-selected').val(pageId);
           				}, 1000);
					}

				}, this));

	        },
	        appendOption: function (data) {	        	
	        	$('.modal-section').last().find('#pages').html(data);
	        },
	        show: function($edit,$el) {
	        	//load modal
	            this.modal.addTemplate('insertpage', this.insertpage.getTemplate());
	 			this.modal.load('insertpage', 'Internal Link', 600);
	 			this.modal.createCancelButton();

	 			//Set buttons for modal insert pages
	 			if($edit == 'edit') {
	 				//button delete
	            	var btnDelete = this.modal.createDeleteButton('Delete');
	            	btnDelete.on('click', this.insertpage.delete);

	            	//button edit
	 				var btnEdit = this.modal.createActionButton('Edit');
	            	btnEdit.on('click', this.insertpage.edit);
	 			} else {
	 				//button insert
	 				var btnInsert = this.modal.createActionButton('Insert');
	            	btnInsert.on('click', this.insertpage.insert);
	 			}

	 			//Ajax to get list pages in dropdown and content maps
	 			if(page.length == 0) {
	 				page.language = 'en';
	 				page.region = null;
	 			}
	 			if(typeof page.region != 'undefined') {
	 				page.region = page.region == null ? 'us' : page.region;	 				
	 			}
	 			//go to server to get pages
	            $.ajax({
					url: window.baseUrl+'/api/pages/get-page',
					type: 'POST',
					data: { language : page.language, region: page.region },
				})
				.success($.proxy(function(data) {
					this.modal.show();
					
					//Append data to view
					// $('#pages').empty().append(data.options);
					this.insertpage.appendOption(data.options);

					var parent_element = $('.show-parent').first();

					//When click choose page
					$('.content-selected').on('click', function(event){
						//get page's id and page's name
						var text = $(event.target).text();
						var contentId = $(event.target).parent().attr('content-id');

						//Set text choose page
						parent_element.text(text);

						//set link text
						$('#redactor-link-url-text').val(text);

						//set id content in input hiddent
						$('#page-id-selected').val(contentId);
						//close menu when we choose page
						parent_element.trigger('click');
					});

					$('.open-child').on('click', function(event){
						//change icon open/close children
						if($(event.target).hasClass('fa-angle-right')) {
							$(event.target).attr('class', 'fa fa-angle-down open-child');
						} else if ($(event.target).hasClass('fa-angle-down')) {
							$(event.target).attr('class', 'fa fa-angle-right open-child');
						}
					});
				},this))
				.error(function(e) {
					console.log(e,'error');
				});
	        },
	        insert: function() {
				this.buffer.set();
	        	this.selection.restore();

	        	// check if page's id is available
				if($('#page-id-selected').val() != '') {
					var contentId = $('#page-id-selected').val();
		        	var pageName = $('#redactor-link-url-text').val();

		        	//go to server to get content of page
		        	$.ajax({
		        		url: '/api/pages/get-content-page',
		        		type: 'POST',
		        		data: {id: contentId},
		        	})
		        	.success($.proxy(function(data) {

		        		//check if in view mode
		        		if(typeof window.sourceMode == 'undefined' || window.sourceMode == 'view') {
		        			this.placeholder.remove();
		        			var link = '<a target="_self" class="insert-page" content-id="'+ contentId +'" href="'+data.content+'">'+pageName+'</a>'
		        			this.insert.html(link);
		        		} else if (window.sourceMode == 'html') {
		        			//if in html mode
		        			var txtInject = "{{inject('link','" + contentId + "','"+ pageName +"')}}";

		        			//get element textarea
		                    var ele = this.source.$textarea;
		                    //get start position of cursor
		                    var cursorPosition = ele[0].selectionStart;
		                    //get value of textarea before insert
		                    var text = this.source.$textarea.val();

		                    //insert to textarea
		                    this.source.$textarea.val(text.substring(0, cursorPosition) + txtInject + text.substring(cursorPosition));
		        		}
		        	},this))
		        	.error(function(e){
		        		console.log(e,'error');
		        	});
					
					this.modal.close();
				} else {
					$('#insert-page-error').removeClass('hidden');
				}
	        },
	        edit: function() {
				this.buffer.set();
				//get current element
				var elementToEdit = this.selection.current();
				//get page's name and page's id
				var contentId = $('#page-id-selected').val();
				var pageName = $('#redactor-link-url-text').val();

				$.ajax({
	        		url: '/api/pages/get-content-page',
	        		type: 'POST',
	        		data: {id: contentId},
	        	})
	        	.done($.proxy(function(data) {

	        		if(window.sourceMode == 'view' || typeof window.sourceMode == 'undefined') {
	        			//edit element
	        			var href = data.content;

	        			$(elementToEdit).text(pageName);
						$(elementToEdit).attr('href', href);
						$(elementToEdit).attr('content-id', contentId);

	        		} else if (window.sourceMode == 'html') {
	        		}
	        	},this));

				//Change value
				this.modal.close();
	        },
	        delete: function() {
				this.buffer.set();
				//get current element
				element = this.selection.current();
				//remove element
				$(element).remove();
				//close modal
				this.modal.close();
	        }
		};
	};
})(jQuery);