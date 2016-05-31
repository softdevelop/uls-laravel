// angular.module('uls').run(['$modal', '$timeout', function($modal, $timeout) {
(function($)
{
	$.Redactor.prototype.insertblock = function()
	{
		return {
			getTemplate: function(blocks)
	        {
				$template = '';

	        	$strOption = '';
	        	for(i in blocks) {
	        		$strOption += '<option value="'+blocks[i]._id+'">'+ blocks[i].name +'</option>';
	        	}

	        	$template = $template
				            + '<div data-ng-controller="test" class="modal-section" id="redactor-modal-advanced">'
				            + '<span id="insert-block-error" class="hidden error" style="float: left;">The block exists</span>'
				            + '<label>Select block</label>'
				            + '<select name="blocks" id="blocks">'
				            + $strOption
				            + '</select>'
				            + '</div>';
	            return $template;
	        },
			init: function() {
				
				//Dropdown
				var dropdown = {};
				dropdown.insert_block = {
					title: 'Insert Block',
					func: this.insertblock.show,
					observe: {
						element: 'table',
						out: {
							attr: {
								// 'class': 'redactor-dropdown-link-inactive',
								'aria-disabled': true,
							}
						}
					}
				};

				dropdown.delete_block = {
					title: 'Delete Block',
					func: this.insertblock.delete,
					observe: {
						element: 'table',
						out: {
							attr: {
								'class': 'redactor-dropdown-link-inactive',
								'aria-disabled': true,
							}
						}
					}
				};

	            var button = this.button.addBefore('format','insert-block', 'Block');
           		this.button.addDropdown(button, dropdown);

           		//Show or hide sub menu action
	        	button.on('click touchstart', $.proxy(function(e) {
	        		this.buffer.set();
	        		//get current cursor
	        		var currentCursor = this.selection.current();
	        		//get attribute data
	        		var attr = $(currentCursor).attr('data');
	        		attr = typeof attr != 'undefined' ? attr : '';

	        		//pattern to check it is a asset
	        		patt = /inject\(\'block/gi;
	        		check = patt.test(attr);

	        		if(check == true) {
	        			//show button delete asset
	        			$('.redactor-dropdown-delete_block').removeClass('redactor-dropdown-link-inactive');
	        		} else {
	        			//hide button delete asset
	        			$('.redactor-dropdown-delete_block').addClass('redactor-dropdown-link-inactive');
	        		}

	        	},this));
	        },
	        viewModal: function(blocks) {
	        	this.modal.addTemplate('insertBlock', this.insertblock.getTemplate(blocks));
        		this.modal.load('insertBlock', 'Insert Block', 600);
				this.modal.createCancelButton();	 				
 				var button = this.modal.createActionButton('Insert');
            	button.on('click', this.insertblock.insert);
				this.modal.show();
	        },
	        show: function($edit) {
	            $.ajax({
					url: window.baseUrl+'/api/get-block',
					type: 'POST',
					data: { language : page.language, region: page.region },
				})
				.success($.proxy(function(data) {
            		this.insertblock.viewModal(data.blocks);						
				},this));
	        },
	        insert: function() {
	        	this.buffer.set();

	        	var blockId = $('#blocks').val();

	        	var elem = angular.element(document.querySelector('[ng-controller="EditDraftController"]'));

	        	//get the injector.
			    var injector = elem.injector();

			    //get the service.
			    var curScope = elem.scope();

			    curScope.getContentBlockFollowId($.proxy(function(result){
			    	
				    if(window.sourceMode == 'view') {
				    	//go to server to get content of block
			        	$.ajax({
			        		url: '/api/block-manager/get-content-block',
			        		type: 'POST',
			        		data: {content: result, language: page.language, region: page.region},
			        	})
			        	.success($.proxy(function(data) {
			        		//restore position cursor
			        		this.selection.restore();
				    		this.air.collapsed();
				    		//insert cotnent to redactor
			        		this.insert.html(data.content);
			        	},this));

					} else if (window.sourceMode == 'html') {
						//check if in html mode
	                    var ele = this.source.$textarea;
	                    //get currsor position
	                    var cursorPosition = ele[0].selectionStart;
	                    var text = this.source.$textarea.val();
	                    //set text to textarea
	                    this.source.$textarea.val(text.substring(0, cursorPosition) + result + text.substring(cursorPosition));
					}
			    	
			    }, this), blockId, this);
				
			},
	        delete: function() {
	        	this.buffer.set();
	        	//get current element
	        	var currentCursor = this.selection.current();
	        	//get attribute data 
	        	var attr = $(currentCursor).attr('data');

        		attr = typeof attr != 'undefined' ? attr : '';

        		//pattern to check it is a asset
        		patt = /inject\(\'block/gi;
        		check = patt.test(attr);
        		//check if is block
        		if (check == true) {
        			//remove element
        			$(currentCursor).remove();
        		}
	        }
		};
	};

})(jQuery);
// }]);