var requestAsset =  angular.module('assetManager');

requestAsset.controller('RequestAssetController', ['$scope', '$modal', 'ngTableParams', '$filter','$timeout', function ($scope, $modal,ngTableParams, $filter,$timeout){
	
	/* When user choose one node then set this node for parent node want to create */
    $scope.getParentFolder = function () {
        /* Declare tree and get active node */ 
        var tree = $('#tree').fancytree('getTree');
        var activeNode = tree.getActiveNode();
        if (activeNode) {
            if(activeNode.folder==false || angular.isUndefined(activeNode.folder)){
                $scope.selectedItemName = activeNode.getParent().title;
                $scope.selectedItemId = activeNode.getParent().key;
            } else{
                if (activeNode.data.parent_id == '0') {
                    $scope.selectedItemName = '';
                    $scope.selectedItemId = '';
                } else {
                    $scope.selectedItemName = activeNode.title;
                    $scope.selectedItemId = activeNode.key;
                }
            }
        }
    }	


    var opened = false;
	$scope.getModalRequestNewAsset = function() {
        if (opened) return;
		nodeSelected = $('#tree').fancytree('getTree').getSelectedNodes();
		var folderId = '';

		if(nodeSelected.length > 0) {
			folderId = nodeSelected[0].key;
		}

		$scope.getParentFolder();

		var modalInstance = $modal.open ({
		    animation: $scope.animationsEnabled,
		    templateUrl: window.baseUrl + '/cms/asset-manager/create?' + 'selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime(),
		    controller: 'ModalRequestAssetController',
		    size: null,
		    resolve: {
		    	folder_id : function (){
		    		return folderId;
		    	}
		    }
		    
		});

        opened = true;
		modalInstance.result.then(function (result) {

			// Format data to show in tree
            var data = result.asset;
            data.title = data.name;
            data.key = data._id;

            opened = false;

            // Get parent node of node added 
            node = $('#tree').fancytree('getTree').getNodeByKey(data.folder_id);
            
            // Call function to add summary name for data
            data = $scope.addSummaryNameForNode(data);
            
			if (node != null) {
                // Add child for parent of node added
                node.addChildren(data);

                // Get node added and set active for node added
                nodeAdded = $('#tree').fancytree('getTree').getNodeByKey(data._id);
                nodeAdded.setActive();

                // Sort child of root node
                node.sortChildren(null, true);
            }

		},function () {
            console.info('Modal dismissed at: ' + new Date());
            opened = false;
        });
	}

	/**
     * Add summary name for node
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @param {Object} data Node added
     * 
     * @return {Object}     Node 
     */
    $scope.addSummaryNameForNode = function (data) {
        $data = data;
        // Split name of data
        if (angular.isUndefined($data.name)) {
            var arrayName = $data.title.split (' ');
        } else {
            var arrayName = $data.name.split (' ');
        }
        
        // If Name has more 2 character space
        if (arrayName.length >= 2) {
            $data['summaryName'] = arrayName[0] + ' ' + arrayName[1];
        } else {
            $data['summaryName'] = arrayName[0];
        }

        return $data;
    }

	/* poup modal Request Translation*/
    $scope.getModalRequestTranslationAsset = function(id){
        if (opened) return;
    	$scope.getParentFolder();
        var template = '/cms/asset-manager/request-translation/'+ id + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime();
        var modalInstance = $modal.open({
            templateUrl: window.baseUrl + template,
            controller: 'ModalRequestAssetController',
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
            for(i in data.asset) {

            	node = $('#tree').fancytree('getTree').getNodeByKey(data.asset[i].file_id);

            	node.data.subFiles.push(data.asset[i]);

            	if(node.data.language == 'n/a') {
            		node.data.language = 1;
            	} else {
            		node.data.language = parseInt(node.data.language) + 1;
            	}

            	if(node.data.due_date == 'n/a' || typeof(node.data.due_date) == 'undefined') {

            		node.data.due_date = data.asset[i].due_date;

            	} else if(node.data.due_date > data.asset[i].due_date) {

            		node.data.due_date = data.asset[i].due_date;
            	}

            	node.data.status = 'waiting-approve';
            	
            	$scope.tableParams.reload();
            }
        },function () {
            console.info('Modal dismissed at: ' + new Date());
            opened = false;
        });
    }

    /* poup modal Request Translation*/
    $scope.getModalRequestRegionAsset = function(id){
        if (opened) return;
    	$scope.getParentFolder();
        var template = '/cms/asset-manager/request-region/'+ id + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime();
        var modalInstance = $modal.open({
            templateUrl: window.baseUrl + template,
            controller: 'ModalRequestAssetController',
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
            for(i in data.assets) {
            	node = $('#tree').fancytree('getTree').getNodeByKey(data.assets[i].file_id);
            	node.data.region = data.countUniqueRegion;

            	node.data.subFiles.push(data.assets[i]);

            	if(node.data.due_date == 'n/a' || typeof(node.data.due_date) == 'undefined') {

            		node.data.due_date = data.assets[i].due_date;

            	} else if(node.data.due_date > data.assets[i].due_date) {

            		node.data.due_date = data.assets[i].due_date;
            	}

            	node.data.status = 'waiting-approve';

            	$scope.tableParams.reload();
            }  
        
        },function () {
            console.info('Modal dismissed at: ' + new Date());
            opened = false;
        });
    }


}]);

requestAsset.controller('ModalRequestAssetController', ['$scope', '$modal', '$filter', '$modalInstance', 'folder_id','RequestAssetService', function ($scope, $modal, $filter, $modalInstance, folder_id,RequestAssetService){
	$scope.languages_selected = {};
  	$scope.requiredLanguage=true;
  	$scope.requiredRegion=true;
  	$scope.regions_selected = {};

  	console.log($scope.foldersMulti,'$scope.foldersMulti');
	if(typeof $scope.asset == 'undefined') {
		$scope.asset = {};
		$scope.asset.folder_id = folder_id == 'root' ? '' : folder_id;
	}

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
  	// Init redactor
  	$scope.initRedactor = function() {
		$('#content').redactor({
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
		            /* Get content in redactor when change event */
			        $content = $('#content').redactor('code.get');
			        $scope.$apply(function(){
			        	/* If content is not null then not show error required content */
			        	// $checkEmpty = $('#content').redactor('utils.isEmpty',$('#content').redactor('core.editor')[0].innerHTML);
			          	if($content == '<div></div>' || $content == ''|| $content == '<br>' || $content == '<div><strong></strong></div>'|| $content == '<div><em></em><strong></strong></div>'|| $content == '<div><em><del></del></em></div>') {
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
        $scope.requiredDescription = false;
		$scope.submitted = true;
		$content = $('#content').redactor('code.get');

		if($content == '<div></div>' || $content == '' || $content == '<br>' || $content == '<div><strong></strong></div>'|| $content == '<div><em></em><strong></strong></div>'|| $content == '<div><em><del></del></em></div>'){
            $scope.requiredDescription = true;
        }

        if(validate || $scope.requiredDescription || !$scope.asset.folder_id) {
        	$(".ng-invalid:eq(1)").focus();
			return;
        }
        
        if($scope.asset.modal == 'request_translation'&& $scope.requiredLanguage) {
        	console.log('langa');
			$(".ng-invalid:eq(1)").focus();
			return;
		}
		if($scope.asset.modal == 'request_region'&& $scope.requiredRegion) {
			$(".ng-invalid:eq(1)").focus();
			return;
		}

        files_id = [];
        
        if(typeof $scope.filesUpload !== 'undefined'){
	    	files_id = $scope.filesUpload['ids'];
	    }
	    $scope.asset.files_id = files_id;

	    $('#btnSubmit').attr('disabled', 'true');
		$scope.asset.description = $content;
		$scope.asset.meta = $content;
		
		if($scope.asset._id && $scope.asset.modal == 'request_translation') {
			$scope.asset.languages = $scope.languages_selected;
		}

		if($scope.asset._id && $scope.asset.modal == 'request_region') {
			$scope.asset.regions = $scope.regions_selected;
		}
		$scope.asset.status = 'waiting-approve';

		RequestAssetService.requestAssetFile($scope.asset).then(function (data){
			if(data.status == 0){
				$('#btnSubmit').removeAttr('disabled');
				$scope.checkName=true;
				$(".name").focus();
			} else {
				$modalInstance.close(data);
			}
		});

	}

	$scope.cancel = function() {
		$modalInstance.dismiss('cancel');
	}

}]);