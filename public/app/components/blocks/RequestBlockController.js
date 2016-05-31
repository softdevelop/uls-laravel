var requestBlock =  angular.module('BlockApp');

requestBlock.controller('RequestBlockController', ['$scope', '$modal', 'ngTableParams', '$filter','$timeout', function ($scope, $modal,ngTableParams, $filter,$timeout){

	/* When user choose one node then set this node for parent node want to create */
    $scope.getParentFolder = function () {
        /* Declare tree and get active node */
        var tree = $('#tree').fancytree('getTree');
        var activeNode = tree.getActiveNode();
        if (activeNode) {
            if(activeNode.folder==false ||angular.isUndefined(activeNode.folder)){
                $scope.selectedItemName = activeNode.getParent().title;
                $scope.selectedItemId = activeNode.getParent().key;
            } else{
                $scope.selectedItemName = activeNode.title;
                $scope.selectedItemId = activeNode.key;
            }
        }
    }

    var opened = false;
	$scope.getModalRequestNewBlock = function() {
		if (opened) return;

		$scope.getParentFolder();
		/*var nodeSelected = $('#tree').fancytree('getTree').getActiveNode();*/

		var folderId = $scope.selectedItemId;
		var modalInstance = $modal.open ({
		    animation: $scope.animationsEnabled,
		    templateUrl: window.baseUrl + '/cms/block-manager/create' + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime(),
		    controller: 'ModalRequestBlockController',
		    size: null,
		    resolve: {
		    	folder_id : function (){
		    		return folderId;
		    	}
		    }

		});
		opened = true;
		modalInstance.result.then(function (data) {
			opened = false;
			data.block.title = data.block.name;
			data.block.key = data.block._id;
			node = $('#tree').fancytree('getTree').getNodeByKey(data.block.folder_id);
			node.addChildren(data.block);
			node.setActive(false);
			node.setActive();
			// Sort all child of root node
            node.sortChildren(null, true);
		},function () {
            console.info('Modal dismissed at: ' + new Date());
            opened = false;
        });
	}

	/* poup modal Request Translation*/
    $scope.getModalRequestTranslation = function(id){
    	if (opened) return;

    	$scope.getParentFolder();
        var template = '/cms/block-manager/request-translation/'+ id + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime();
        var modalInstance = $modal.open({
            templateUrl: window.baseUrl + template,
            controller: 'ModalRequestBlockController',
            size: undefined,
            resolve: {
            	folder_id : function (){
		    		return null;
		    	}
            }
        });
        opened = true;
        modalInstance.result.then(function (data) {
        	opened = false;
            for(i in data.blocks) {

            	node = $('#tree').fancytree('getTree').getNodeByKey(data.blocks[i].base_id);

            	node.data.subBlocks.push(data.blocks[i]);

            	if(node.data.language == 'n/a') {
            		node.data.language = 1;
            	} else {
            		node.data.language = parseInt(node.data.language) + 1;
            	}

            	if(node.data.due_date == 'n/a' || typeof(node.data.due_date) == 'undefined') {

            		node.data.due_date = data.blocks[i].due_date;

            	} else if(node.data.due_date > data.blocks[i].due_date) {

            		node.data.due_date = data.blocks[i].due_date;
            	}

            	node.data.status = 'draft';

            	$scope.tableParams.reload();
            }
        },function () {
            console.info('Modal dismissed at: ' + new Date());
            opened = false;
        });
    }

    /* poup modal Request Translation*/
    $scope.getModalRequestRegion = function(id){
    	if (opened) return;
    	$scope.getParentFolder();
        var template = '/cms/block-manager/request-region/'+ id + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime();
        var modalInstance = $modal.open({
            templateUrl: window.baseUrl + template,
            controller: 'ModalRequestBlockController',
            size: undefined,
            resolve: {
            	folder_id : function (){
		    		return null;
		    	}
            }
        });
        opened = true;
        modalInstance.result.then(function (data) {
        	opened = false;
            for(i in data.blocks) {
            	node = $('#tree').fancytree('getTree').getNodeByKey(data.blocks[i].base_id);

            	node.data.region = data.countUniqueRegion;

            	node.data.subBlocks.push(data.blocks[i]);

            	if(node.data.due_date == 'n/a' || typeof(node.data.due_date) == 'undefined') {

            		node.data.due_date = data.blocks[i].due_date;

            	} else if(node.data.due_date > data.blocks[i].due_date) {

            		node.data.due_date = data.blocks[i].due_date;
            	}

            	node.data.status = 'draft';

            	$scope.tableParams.reload();
            }

        },function () {
            console.info('Modal dismissed at: ' + new Date());
            opened = false;
        });
    }


}]);

requestBlock.controller('ModalRequestBlockController', ['$scope', '$modal', '$filter', '$modalInstance', 'folder_id','RequestBlockService','Upload','$timeout', function ($scope, $modal, $filter, $modalInstance, folder_id,RequestBlockService,Upload,$timeout){
	$scope.languages_selected = {};
  	$scope.requiredLanguage=true;
  	$scope.requiredRegion=true;
  	$scope.regions_selected = {};

    $timeout(function(){
        $scope.block = angular.copy(window.block);
        $scope.folders = window.folders;

        if(typeof $scope.block.modal == 'undefined') {
            $scope.block.folder_id = folder_id == 'root' ? '0' : folder_id;
        }
    },500);

	// if(typeof $scope.block == 'undefined') {
	// 	$scope.block = {};
	// 	$scope.block.folder_id = folder_id == 'root' ? '' : folder_id;
	// }

	// setup variable for date picker
	$scope.format = 'MM-dd-yyyy';
	$scope.minDate = new Date();
	/* Open calendar when create page*/
	$scope.open = function($event, type) {
    	$event.preventDefault();
    	$event.stopPropagation();
    	$scope.opened = {};
    	$scope.opened[type] = true;
  	};

  	$scope.removeThumbnail = function(index) {
  		if (!confirm('Do you want delete this image?')) return;
  		$scope.block.thumbnail.splice(index, 1);
  	}

  	// Init redactor
  	$scope.initRedactor = function() {
		$('#description').redactor({
			plugins: ['table', window.isAdvancedEditingFeatures == true ? 'source' : ''],
	        imageUpload: '/content/upload',
	        // buttonsHide: ['link','insertpage'],
	        callbacks: {
		        modalOpened: function(name, modal) {
		            if(name == 'link' && !this.observe.isCurrent('a')) {
		                $('#redactor-link-blank').attr("checked","true");
		                $('<label><input type="checkbox" checked id="redactor-link-no-follow"> No Follow</label>').insertAfter($('#redactor-link-blank').parent());
		            } else if(name == 'link') {
		                var rel = this.link.$node.attr('rel');
		                if(typeof rel == 'undefined') {
		                  $('<label><input type="checkbox" id="redactor-link-no-follow"> No Follow</label>').insertAfter($('#redactor-link-blank').parent());
		                } else {
		                  $('<label><input type="checkbox" checked id="redactor-link-no-follow"> No Follow</label>').insertAfter($('#redactor-link-blank').parent());
		                }
		            }
		        },
		        insertedLink: function(element) {
		            var href = $(element).attr('href');
		            if(href.substring(0, 4) != 'http' && href.substring(0,5) != 'https' && href.substring(0,3) != 'ftp') {
		              $(element).attr('href','http://' + href);
		            }
		            if($('#redactor-link-no-follow').prop('checked')) {
		              element.attr('rel', 'nofollow');
		            } else {
		              element.removeAttr('rel');
		            }
		        },
		        linkify: function(elements) {
		          elements.attr("target","_blank");
		        },
		        change: function() {
			        $description = $('#description').redactor('code.get');
			        console.log($('#description').redactor());

			        $scope.$apply(function(){
			        	/* If content is not null then not show error required content */
			        	// $checkEmpty = $('#content').redactor('utils.isEmpty',$('#content').redactor('core.editor')[0].innerHTML);
			          	if($description == '<div></div>' || $description == ''|| $description == '<br>' || $description == '<div><strong></strong></div>'|| $description == '<div><em></em><strong></strong></div>'|| $description == '<div><em><del></del></em></div>') {
			              	$scope.requiredDescription = true;
			          	} else {/* Show error required content */
			              	$scope.requiredDescription = false;
			          	}
			        });
		        }
		    },
		    linkSize: 1000,
		    minHeight: 200 // pixels
	    });
	}

  	//Click button submit
	$scope.submit = function(validate) {

		delete $scope.errors;

        $scope.requiredDescription = false;
		$scope.submitted = true;
		if(angular.isDefined($scope.folderType) && $scope.folderType[$scope.block.folder_id] == 'managed_block'){
			$scope.block.type = 'managed_block';
		}
		$description = $('#description').redactor('code.get');

		console.log($description);

        if($description == '<div></div>' || $description == '' || $description == '<br>' || $description == '<div><strong></strong></div>'|| $description == '<div><em></em><strong></strong></div>'|| $description == '<div><em><del></del></em></div>'){
            $scope.requiredDescription = true;
        }

        if(validate || $scope.requiredDescription) {
        	$(".ng-invalid:eq(1)").focus();
			return true;
        }
        if(typeof $scope.block.folder_id=='undefined' && $scope.block.modal != 'request_translation' && $scope.block.modal != 'request_region'){
            return true;
        }
        if($scope.block.modal == 'request_translation'&& $scope.requiredLanguage) {
			$(".ng-invalid:eq(1)").focus();
            return true;
		}
		if($scope.block.modal == 'request_region'&& $scope.requiredRegion) {
			$(".ng-invalid:eq(1)").focus();
            return true;
		}

        files_id = [];

        if(typeof $scope.filesUpload !== 'undefined'){
	    	files_id = $scope.filesUpload['ids'];
	    }
	    $scope.block.files_id = files_id;

	    $('#btnSubmit').attr('disabled', 'true');
		$scope.block.description = $description;

		if($scope.block._id && $scope.block.modal == 'request_translation') {
			$scope.block.languages = $scope.languages_selected;
		}

		if($scope.block._id && $scope.block.modal == 'request_region') {

			$scope.block.contentId = $scope.block._id;

			$scope.block._id = $scope.block.base_id;

			$scope.block.regions = $scope.regions_selected;
		}

		RequestBlockService.requestBlock($scope.block).then(function (data){

			if(data.status == 0){
				$('#btnSubmit').removeAttr('disabled');
				$scope.checkName=true;

				if (data['errors']) {
					$scope.errors = data['errors'];
				} else {
					$(".name").focus();
				}
			} else {
				if(typeof $scope.block.thumbnail != 'undefined') {
					var modal = 'propose_new';
					if(typeof $scope.block.modal != 'undefined') {
						modal = $scope.block.modal;
					}

					for (var i = 0; i < $scope.block.thumbnail.length; i++) {
						var file = $scope.block.thumbnail[i];
						Upload.upload({
							url: window.baseUrl + '/api/block-manager/change-thumbnail',
							fields: {
								modal: modal,
								data : data
							},
							file: file
						}).progress(function (evt) {

						}).success(function (data, status, headers, config) {
							if(!data['status']) {
								return;
							}
						});
					}
				}
				$modalInstance.close(data);

			}
		});

	}

	$scope.cancel = function() {
		$modalInstance.dismiss('cancel');
	}

}]);
