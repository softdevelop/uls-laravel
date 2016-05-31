var fileModule = angular.module('file');

fileModule.directive("files",['FileService','$timeout','$filter','ngTableParams', function(FileService,$timeout,$filter,ngTableParams){
	return {
		restrict: 'EA',
		scope:{
			items: '=items',
			listNameUser: '=listNameUser',
			users: '=',
			isAdmin:'=',
			isDocumentRowboat:'=',
			openPicture:'&',
			showFolderId:'&',
			visibleFolder:'&',
			deleteFolder:'&',
			deleteFile: '&',
			editFile:'&'
		},
		replace: true,
		transclude: true,
		templateUrl: baseUrl+'/app/components/file/views/index.html?v=1',
		link: function( $scope, element, attrs, ctrl, transcludeFn){
			// console.log(element);
			FileService.setFilesCurrentFolder(angular.copy($scope.items));
			$scope.baseUrl = baseUrl;
			$scope.fileName = {};
			$scope.folderName = {};
			// $scope.sortFileAble = 'sortAsc';
			$scope.$watch('items',function(newValue, oldValue){
				if(newValue != oldValue){
					FileService.setFilesCurrentFolder(angular.copy(newValue));
					$scope.tableParams.reload();
				}
			
			});
				$scope.tableParams = new ngTableParams({
	                page: 1, // show first page
	                count: 50, // count per page
	                sorting: {
	                    'group': 'desc', // initial sorting
	                    // 'file_name': 'asc'
	                },
	            }, {
	            	 groupBy: 'group',
	                total: $scope.items.length, // length of data
	                getData: function($defer, params) {
	                    var orderedData = params.sorting() ? $filter('orderBy')($scope.items, params.orderBy()) : $scope.items;
	                    orderedData = params.filter() ? $filter('filter')(orderedData, params.filter()) : orderedData;
	                    params.total(orderedData.length);
	                    if (params.total() <= params.count()) {
			                params.page(1);
			            } else {
			                if (params.total() % params.count() == 0  && params.total() / params.count() < params.page() && params.page() != 1) {
			                    params.page(params.page()-1);
			                }
			            };
	                    $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));


	                }
	            });

		 	$scope.checkFile = function(type){
                return FileService.checkFile(type);
            }

    		$scope.editFileName = function(id, group){
    			if(group == 'folder'){
    				if(!$scope.folderName[id]){
    					return;
    				}
    				var edit = 'edit-folder-'+id;
    				var file = 'folder-'+id;
    				var contenSelectLength = $scope.folderName[id].length;
    			}
    			else{
    				if(!$scope.fileName[id]){
    					return;
    				}
    				var edit = 'edit-file-'+id;
	    			var file = 'file-'+id;
	    			var contenSelectLength = ($scope.fileName[id].length - $scope.fileName[id].split('.').pop().length) - 1;
    			}
	            angular.element('.'+edit).removeClass("hidden");
	          	angular.element('.'+file).addClass("hidden");
	          	var input = document.getElementById(file);
	          	input.setSelectionRange(0, contenSelectLength);
	          	
	        }
		}
	}
}])
.directive('editFileName', ['FileService', 'shareDataFactory', function(FileService, shareDataFactory){
	return {
		restrict: 'A',
		link: function($scope, element, attrs, ctrl){
				var id = attrs.id.split('-')[1];
				var edit = 'edit-file-'+id;
    			var file = 'file-'+id;
				if(attrs.id.split('-')[0] == 'folder'){
					edit = 'edit-folder-'+id;
    				file = 'folder-'+id;
				} 
				function editFileName(){
					if ($scope.form.editFolderFile.$error.required){return;}
					var file_name = attrs.fileNameEdited;
					FileService.editFileName({ id:id, fileName: file_name, group: attrs.id.split('-')[0] }).then(function(data){
						if(!data.status){
							if(data.error){
				                alert(data.error + ' Refresh this page.');
				                window.location.href = window.baseUrl +'/document-manager' ; 
				            }
				
						}
						angular.element('.'+edit).addClass("hidden");
	          			angular.element('.'+file).removeClass("hidden");
	          			shareDataFactory.prepForBroadcase(data,'editFile');
					})
				}
	

			element.bind('keydow keypress', function(event){
				if(event.which == 13){
					editFileName();
				}
			});

			element.bind('blur', function(event){
					editFileName();
			});
		}
	}
}]);


