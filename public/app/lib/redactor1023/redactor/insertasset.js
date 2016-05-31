(function($)
{
	$.Redactor.prototype.insertasset = function()
	{
		return {
			getTemplate: function(assets)
	        {
				$template = '';

	        	$strOption = '';
	        	for(i in assets) {
	        		$strOption += '<option value="'+assets[i]._id+'">'+ assets[i].name +'</option>';
	        	}

	        	$template = $template
				            + '<div class="modal-section" id="redactor-modal-advanced">'
				            + '<span id="insert-asset-error" class="hidden error" style="float: left;">The asset exists</span>'
				            + '<label>Select asset</label>'
				            + '<select name="assets" id="assets">'
				            + $strOption
				            + '</select>'
				            + '</div>';

	            return $template;
	        },
			init: function() {
				
				//Dropdown
				var dropdown = {};
				dropdown.insert_asset = {
					title: 'Insert asset',
					func: this.insertasset.show,
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

				//button delete asset
				dropdown.delete_asset = {
					title: 'Delete asset',
					func: this.insertasset.delete,
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

	            var button = this.button.addBefore('format','insert-asset', 'Asset');
           		this.button.addDropdown(button, dropdown);
           		// window.insertAssets = [];

           		//Show or hide sub menu action
	        	button.on('click touchstart', $.proxy(function(e) {
	        		this.buffer.set();
	        		//get current cursor
	        		var currentCursor = this.selection.current();
	        		//get attribute data
	        		var attr = $(currentCursor).attr('data');
	        		attr = typeof attr != 'undefined' ? attr : '';

	        		//pattern to check it is a asset
	        		patt = /inject\(\'asset/gi;
	        		check = patt.test(attr);

	        		if(check == true) {
	        			//show button delete asset
	        			$('.redactor-dropdown-delete_asset').removeClass('redactor-dropdown-link-inactive');
	        		} else {
	        			//hide button delete asset
	        			$('.redactor-dropdown-delete_asset').addClass('redactor-dropdown-link-inactive');
	        		}

	        	},this));
	        },
	        //get modal to view
	        viewModal: function(assets) {
	        	this.modal.addTemplate('insertasset', this.insertasset.getTemplate(assets));
        		this.modal.load('insertasset', 'Edit Asset', 600);
        		//create button cancel
				this.modal.createCancelButton();	 				
				//create button insert asset
 				var button = this.modal.createActionButton('Insert');
            	button.on('click', this.insertasset.insert);
				this.modal.show();
	        },
	        show: function($edit) {
	        	//ajax to get list asset
	            $.ajax({
					url: window.baseUrl+'/api/get-asset',
					type: 'POST',
					data: { language : page.language, region: page.region },
				})
				.success($.proxy(function(data) {
	            		this.insertasset.viewModal(data.assets);
	            		// window.insertAssets = data.assets;
				},this))
				.error(function(e) {
					console.log(e,'error');
				});
	        },
	        //action insert asset
	        insert: function() {
				this.placeholder.remove();
				this.buffer.set();
				//get asset's id
				var assetId = $('#assets').val();
				//close modal
				this.modal.close();

				//check if in view mode
				if(window.sourceMode == 'view') {
					this.air.collapsed();
					$.ajax({
						url: '/api/asset-manager/get-content-asset/' + assetId,
						type: 'GET'
					})
					.done($.proxy(function(data) {
						//insert content to redactor
						this.insert.html(data.content);
						this.selection.restore();
					},this));
					
				} else if (window.sourceMode == 'html') {
					//check if in html mode
					var txtInject = "{{inject('asset','" + assetId + "')}}";
					//get textarea
                    var ele = this.source.$textarea;
                    //get current of cursor
                    var cursorPosition = ele[0].selectionStart;
                    var text = this.source.$textarea.val();
                    //insert content to cursor
                    this.source.$textarea.val(text.substring(0, cursorPosition) + txtInject + text.substring(cursorPosition));
				}
			},
	        delete: function() {
	        	this.buffer.set();
	        	//get current element
	        	var currentCursor = this.selection.current();
	        	//get attribute data
	        	var attr = $(currentCursor).attr('data');

        		attr = typeof attr != 'undefined' ? attr : '';

        		//pattern to check it is a asset
        		patt = /inject\(\'asset/gi;
        		check = patt.test(attr);
        		//check if is asset
        		if (check == true) {
        			//remove element
        			$(currentCursor).remove();
        		}
	        }
		};
	};

})(jQuery);