
	$(function() {
//		$('#autocomplete').autocomplete({
//			source: function(request, response) {
//				$.ajax({url: 'http://dev.ulsinc.com/materials_library/javascript/search_by_application',
//						data: {term: $('#autocomplete').val()},
//						dataType: 'json',
//						type: 'POST',
//						success: function(data) {
//							response($.map(data, function(item) {
//            					return {
//               					 	navigation: 'http://dev.ulsinc.com/materials-library/applications/' + item.navigation,
//               					 	application: item.application
//            					}
//          					}))
//						}
//				});
//			},
//			select: function(event, ui) {
//				 window.location.href = ui.item.navigation;
//			},
//			minLength: 2
//			})
//			.data('autocomplete')._renderItem = function(ul, item) {
//				return $('<li></li>')
//					.data('item.autocomplete', item)
//					.append('<a id="test" href="http://dev.ulsinc.com/materials-library/applications/' + item.navigation + '">' + item.application + '</a>')
//					.appendTo(ul);
//		};
//		
//		$('#autocomplete').on('focus', function() {
//			$('#autocomplete').val('');
//		});
//		
		
		$('#materials').autocomplete({
			source: function(request, response) {
				$.ajax({url: 'http://www.ulsinc.com/materials-library/javascript/search-by-material',
						data: {material: $('#materials').val()},
						dataType: 'json',
						type: 'POST',
						success: function(data) {
							console.log(data);
							response($.map(data, function(item) {
            					return {
               					 	navigation: 'http://www.ulsinc.com/materials-library/' + item.navigation,
               					 	material: item.material,
               					 	breadcrumbs: item.breadcrumbs
            					}
          					}))
						}
				});
			},
			select: function(event, ui) {
				window.location.href = ui.item.navigation;
			},
			minLength: 2
			})
			.data('autocomplete')._renderItem = function(ul, item) {
				return $('<li></li>')
					.data('item.autocomplete', item)
					.append('<a href="' + item.navigation + '/"><strong>' + item.material + '</strong>: ' +  item.breadcrumbs + '</a>')
					.appendTo(ul);
		};
		
		$('#materials').on('focus', function() {
			//$('#materials').val('');
		});
	});

