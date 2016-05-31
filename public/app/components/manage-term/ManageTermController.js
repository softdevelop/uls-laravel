manageTermApp.controller('ManageTermController', ['$scope', '$modal', '$filter', 'ngTableParams', 'ManageTermService', function ($scope, $modal, $filter, ngTableParams, ManageTermService) {
    
    $scope.isSearch = false;

    $scope.data = ManageTermService.setItems(window.items);
    $scope.fieldsName = window.fieldsName;
    $scope.termId = window.termId;
    for(i in $scope.data){
        for (j in  $scope.fieldsName) {
            if(angular.isArray($scope.data[i][$scope.fieldsName[j].name])){
                $scope.fieldsName[j]['isArray']=true;
            }   
        }
    }
    $scope.field = window.field;

    $scope.dataOptionMap = window.dataOptionMap;

    $scope.dataOptionMap = window.dataOptionMap;

    var getFileManagerTerm = function()
    {
        ManageTermService.getFileManagerTerm().then(function(data){

            $scope.filesAll = ManageTermService.getFileALl();

        })
    }

    getFileManagerTerm();

    $scope.templates = window.templates;

    $scope.getModalCreate = function (termId, id) {

        var teamplate = window.baseUrl + '/manage-term/create/' + termId;

        if (angular.isDefined(id)){

            teamplate = window.baseUrl + '/manage-term/edit/' + termId + '/' + id;
        }

        window.location = teamplate;
    };

    $scope.deleteItem = function (termId, id) {

        ManageTermService.deleteItem(termId, id).then(function (){
                
            $scope.data = ManageTermService.getItems();
        });
    }

    $scope.viewDetail = function(content) {
        console.log(content,'hh');
    }

}]);
manageTermApp.controller('ModalManageTermCtrl', ['$scope', 'ManageTermService', '$timeout', '$modal', function ($scope, ManageTermService, $timeout, $modal) {

    var termName = window.termName;

    $scope[termName] = {};

    $scope.dataModal = {};

    $scope.baseUrl = window.baseUrl;

    $scope.dataOptionMap = window.dataOptionMap;

    var getFileManagerTerm = function()
    {
        ManageTermService.getFileManagerTerm().then(function(data){

            $scope.filesAll = ManageTermService.getFileALl();
            // console.log($scope.filesAll);
        })
    }
    $scope.checkFile = function(type){
        return ManageTermService.checkFile(type);
    };
    getFileManagerTerm();
    
    $scope.showModal = function (term,index)
    {

        if(typeof $scope.dataModal[index] == 'undefined'){

            $scope.dataModal[index] = [];

            $scope[termName][term.term_name] = [];

        }

        var lenghtHtml = term.htmlField.htmlArr.length;
        
        var modalInstance = $modal.open({
            templateUrl: window.baseUrl+'/manage-term/create-modal/' + lenghtHtml + '?v=' + new Date().getTime(),
            controller: 'ModalView',
            size: undefined,
            resolve: {
                term: function () {
                    return term;
                }
            }
        });
        modalInstance.result.then(function (data) {

            getFileManagerTerm();

            $scope.dataModal[index].push(data);
            console.log('dataModal', $scope.dataModal[index]);

            $scope[termName][term.term_name].push(data);

            console.log('data', $scope[termName]);
            

        }, function () {

        });    
    }

   

    $scope.field = window.field;

    $scope.fileds = window.htmlOrverideFiled;

    $scope.termId = window.termId;

    $scope.tagHtml = window.tagHtml; 

    $scope.getData = function (){

        $scope[termName] = angular.copy(window.item);
    }
    // console.log( $scope.fileds);

    var loadWarrap = function(){
            var countTag =0;
            var countEnd =0;
            var countparent =0;
            var parent=$("." + $scope.fileds[0].value.alias).parent();
            // console.log(parent);
            for(var i = 0; i <  $scope.fileds.length; i++){
                    if($scope.fileds[i].value.endField){
                        if($scope.tagHtml[countTag].parent=='parent_'+countTag){
                            $("." + $scope.fileds[i].value.alias).after($scope.tagHtml[countTag].html);
                            var addClass='class_add_'+$scope.tagHtml[countTag].parent;
                             parent.find($('.content_Wrapper').last()).addClass(addClass);
                            $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countTag].parent);
                        }
                        else{
                             $('.class_add_'+$scope.tagHtml[$scope.tagHtml[countTag].parent].parent).append($scope.tagHtml[countTag].html);
                             var addClass='class_add_'+$scope.tagHtml[countTag].parent; 
                             parent.find($('.content_Wrapper').last()).addClass(addClass);
                            $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countTag].parent); 
                        }
                        countTag++;
                        countparent++;
                     
                    } else{
                        if($scope.fileds[i].value.postWrapperHtml){
                            if(countparent==1){
                                if(countTag<=countEnd){
                                    return;
                                }
                                $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countTag- countEnd-1].parent); 
                                countEnd=countEnd + $scope.fileds[i].value.postWrapperHtml.length;
                            } else{
                                if(countEnd<=countTag-2){
                                    countEnd=countEnd + $scope.fileds[i].value.postWrapperHtml.length;
                                    if($scope.fileds[i].value.postWrapperHtml.length>1){
                                        if($scope.fileds[i-1].value.postWrapperHtml){
                                            $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countEnd- $scope.fileds[i].value.postWrapperHtml.length].parent); 
                                        } else{
                                            $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countEnd- $scope.fileds[i].value.postWrapperHtml.length+1].parent); 
                                        }
                                    } else{
                                        if($scope.tagHtml[countEnd+1]){
                                            $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countEnd+1].parent); 
                                        } else{
                                            $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countEnd].parent);
                                        }
                                    }
                                } else{

                                    $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countEnd].parent); 
                                    countEnd=countEnd +$scope.fileds[i].value.postWrapperHtml.length;
                                }
                            }
                        } else{
                            if(countTag>countEnd){
                              $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countTag-1].parent); 
                            }
                        }
                    }
            }
    }

    $(window).load(function(){
        loadWarrap();
    });
    
    $scope.submit = function (form)
    {
        $scope.submitted = true;
        if(!form.$valid){

            angular.element("[name='" + form.$name + "']").find('.ng-invalid:visible:first').focus();

            return;
        }

        $scope[termName].termId = $scope.termId;

        ManageTermService.createProvider($scope[termName]).then(function (data){

        })
    };
    
}])
.controller('ModalView', ['$scope', '$modalInstance', 'term', function($scope, $modalInstance, term){

    $scope.term = term;

    $scope.cancel = function() {

        $modalInstance.dismiss('cancel');
    }

    $scope.submit = function(form){

        $scope.submitted = true;

        if(!form.$valid){

            angular.element("[name='" + form.$name + "']").find('.ng-invalid:visible:first').focus();

            return;
        }

        $modalInstance.close($scope[term.term_name]);
    }

}])
