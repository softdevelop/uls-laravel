var createPageApp = angular.module('pageApp');
createPageApp.controller('CreatePageController', ['$scope', '$modalInstance', '$modal', '$filter', 'ngTableParams', '$http', '$window', '$timeout', 'CreatePageService','content_id', function ($scope, $modalInstance, $modal, $filter, ngTableParams, $http, $window, $timeout, CreatePageService,content_id){
	$scope.page = angular.copy(window.page);

	$scope.minDate = new Date();

	/* Open calendar when create page*/
	$scope.open = function($event, type) {
    	$event.preventDefault();
    	$event.stopPropagation();
    	$scope.opened = {};
    	$scope.opened[type] = true;
  	};
  	$scope.languages_selected = {};
  	$scope.requiredLanguage=true;
  	$scope.requiredRegion=true;
  	$scope.regions_selected = {};
  	$scope.format = 'MM-dd-yyyy';
    $scope.checkName=false;
  	$scope.checkUrl=false;
  	$scope.validatedue_date=false;
	
	$scope.initRedactor = function() {
		$('#content').redactor({
			plugins: ['table','insertpage', 'insertlink',window.isAdvancedEditingFeatures == true ? 'source' : ''],
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
	$('#content').redactor('core.destroy');
	$scope.changeName = function(){
        $scope.checkName=false;
		$scope.checkUrl=false;
	}
	$scope.changeDate = function(){
		$scope.validatedue_date=false;
	}
	$scope.submit = function (validate) {
		$scope.submitted  = true;

        /* Validate content */
        $content = $('#content').redactor('code.get');

        if($content == '<div></div>' || $content == '' || $content == '<br>' || $content == '<div><strong></strong></div>'|| $content == '<div><em></em><strong></strong></div>'|| $content == '<div><em><del></del></em></div>'){
            $scope.requiredDescription = true;
        }else{
            $scope.requiredDescription = false;
        }
		/* if the user has not entered enough information then return */
		if(validate || $scope.requiredDescription) {
			$(".ng-invalid:eq(1)").focus();
			return;
		}
		if($scope.page.modal == 'request_translation'&& $scope.requiredLanguage) {
			$(".ng-invalid:eq(1)").focus();
			return;
		}
		if($scope.page.modal == 'request_region'&& $scope.requiredRegion) {
			$(".ng-invalid:eq(1)").focus();
			return;
		}
		var today = new Date();
        if(typeof $scope.page.due_date =="undefined"){
        	$scope.validatedue_date=true;
        } else{
        	var today = new Date();
        	if($scope.page.due_date<today){
        		if($filter('date')(today, 'MM-dd-yyyy')!=$filter('date')($scope.page.due_date, 'MM-dd-yyyy')){
        			$scope.validatedue_date=true;
        		}

        	}
        }

		if($scope.validatedue_date){
        	return;
        }

		files_id = [];
	    if(typeof $scope.filesUpload !== 'undefined'){
	      files_id = $scope.filesUpload['ids'];
	    }
	    $scope.page.files_id = files_id;

		$('#btnSubmit').attr('disabled', 'true');
		$scope.page.description = $('#content').redactor('code.get');
	/*	$scope.page.due_date = $filter('date')(new Date($scope.page.due_date), 'MM-dd-yyyy');*/
		
		if($scope.page._id && $scope.page.modal == 'request_translation') {
			$scope.page.languages = $scope.languages_selected;
		}

		if($scope.page._id && $scope.page.modal == 'request_region') {
			$scope.page.regions = $scope.regions_selected;
		}
		
		/* Call service to create new page */
		if(typeof $scope.page.parent_id =='undefined'){
			$scope.page.parent_id='0';
		}
		if(content_id!=null){
			$scope.page.content_id=content_id;
		}
		CreatePageService.createPageProvider($scope.page).then(function (data){

			if(typeof data['status'] && !data['status']){
				$('#btnSubmit').removeAttr('disabled');
                if(data['checkName']) {
				    $scope.checkName = true;
                }
                if(data['checkUrl']) {
                    $scope.checkUrl = true;
                }
				$(".name").focus();
			}
			else{
				$modalInstance.close(data.page);
			}
		});
	};

	$scope.cancel = function () {
	    $modalInstance.dismiss('cancel');
	};
}])
