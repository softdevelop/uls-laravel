(function($)
{
	$.Redactor.prototype.parsercontent = function()
	{
		return {			
			init: function() {
				//init view mode
				window.sourceMode = 'view';

				//event when change mode view or html
	        	this.core.element().on('sourceMode.callback.redactor', function(mode,content) {
	        		//set mode
	        		window.sourceMode = content[0];

	        		//if is html mode
				    if(window.sourceMode == 'html') {
				    	//show asset, block, link button
				    	this.button.get('insert-block').removeClass('redactor-button-disabled');
				    	this.button.get('insert-asset').removeClass('redactor-button-disabled');
				    	this.button.get('insert-link').removeClass('redactor-button-disabled');

				    	// var element = '<div>'+content[1]+'</div>';
				    	var element = content[1];

				    	//get content and convert content to html
				    	this.parsercontent.parserContentToHtml(element);
				    } else if (window.sourceMode == 'view') {
				    	//get content and convert content to view mode
				    	this.parsercontent.parserContentToView(content[1]);
				    }
				});
	        },
	        //replace inject syntax to html
	        replaceContentToHtml: function(el,content) {
	        	content = content.replace('=""','');
	        	var strSearch = ($(el)[0].outerHTML).replace('=""','');

	        	var inject = "{{" + $(el).attr('data') + "}}";
	        	

	        	content = content.replace(' >','>');
	        	//replace string
	        	content = content.replace(strSearch, inject);
	        	console.log(content, 'dsa');
	        	return content;
	        },
	        //parse content of page to html mode
	        parserContentToHtml: function(content) {
	        	console.log(content,'dsfdsf');
	        	//get all element have attribute data begin is inject
	        	var element = $(content).find("[data^=inject]");

	        	//for element to parser content
	        	$.when(element.each($.proxy(function(index, el){
	        		//replace content
	        		content = this.parsercontent.replaceContentToHtml(el,content);
	        	},this)))
	        	.then($.proxy(function(){
	        		//set value to texarea
	        		this.source.$textarea.val(content);
	        	},this));
	        },
	        //parse content html to view mode
	        parserContentToView: function(content) {
	        	//set start data to empty
	        	htmlContent = content;
	        	this.code.set('');
	        	//go to server to get content
	        	$.ajax({
	        		url: '/api/block-manager/get-content-block',
	        		type: 'POST',
	        		data: {content: content, language: page.language, region: page.region},
	        	})
	        	.success($.proxy(function(data) {
	        		console.log(data,'data');
	        		//set content to view
	        		this.code.set(data.content);
	        	},this))
	        	.error($.proxy(function(){
	        		this.code.set(htmlContent);
	        	},this));        	
	        	
	        }
		};
	};

})(jQuery);