(function($)
{
	$.Redactor.prototype.insertlink = function()
	{
		return {
			getTemplate: function()
	        {
	        },
			init: function() {
				setTimeout(function() {
					$('.re-link').first().css('display', 'none');
                    $('.re-insert-page').first().css('display', 'none');
                }, 200);
				//Dropdown
				var dropdown = {};
				dropdown.external_link = {
									title: 'External Link',
									func: this.link.show,
									observe: {
										element: 'a'
									}
								};

				dropdown.un_link = {
								title: 'Unlink',
								func: this.link.unlink,
								observe: {
										element: 'a',
										out: {
											attr: {
												'class': 'redactor-dropdown-link-inactive',
												'aria-disabled': true
											}
										}
									}
							};

				dropdown.internal_link = {
									title: 'Internal Link',
									func: this.insertpage.show
								};

				var button = this.button.addAfter('table','insert-link', 'Link');
           		this.button.addDropdown(button, dropdown);
	        }
		};
	};
})(jQuery);