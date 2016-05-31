requestBlock.directive('codeMirror', function (){
	return {
		restrict: 'A',
		link: function($scope, elem, $attr){

			var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
		      lineNumbers: true,
		      theme: "night",
		      extraKeys: {
		        "F11": function(cm) {
		          cm.setOption("fullScreen", !cm.getOption("fullScreen"));
		        },
		        "Esc": function(cm) {
		          if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
		        }
		      }
		    });

			// console.log(elem);
			// var editor = CodeMirror.fromTextArea(document.getElementById("content"), {
			//     lineNumbers: true
			//   });
		}
	};

});
