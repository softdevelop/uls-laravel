var pageDraftModule = angular.module('viewDraft');

pageDraftModule.controller('ViewDraftController', ['$scope','$timeout','$q','ViewDraftService', function($scope, $timeout,$q,ViewDraftService) {
    
    $scope.contents = angular.copy(window.contents);

    $scope.preRevisions = function()
    {
         window.location = window.baseUrl + '/cms/pages/view-revision/'+$scope.contents['content']+'/'+$scope.contents['revisions'][$scope.contents['version']-1]['id'];
    }
    $scope.nextRevisions = function()
    {
         window.location = window.baseUrl + '/cms/pages/view-revision/'+$scope.contents['content']+'/'+$scope.contents['revisions'][$scope.contents['version']+1]['id'];
    }
    $scope.approve = function(ticketId) 
    {
        $('.btn-top').attr('disabled', 'true');
        var data = {id: ticketId};
        ViewDraftService.approve(data).then(function(data){
            if(data.status) {
                window.location = window.urlViewTask + '/support/show/'+ ticketId;
            } else {
                $('.btn-top').removeAttr('disabled');
            }
        });
    }
    $scope.requestReview = function(ticketId) 
    {
        $('.btn-top').attr('disabled', 'true');
        var data = {id: ticketId};
        ViewDraftService.requestReview(data).then(function(data){
            if(data.status) {
                window.location = window.urlViewTask + '/support/show/'+ ticketId;
            } else {
                $('.btn-top').removeAttr('disabled');
            }
        });
    }
    $scope.deny = function(ticketId) 
    {
        $('.btn-top').attr('disabled', 'true');
        var data = {id: ticketId};
        ViewDraftService.deny(data).then(function(data){
            if(data.status) {
                window.location = window.urlViewTask + '/support/show/'+ ticketId;
            } else {
                $('.btn-top').removeAttr('disabled');
            }
        });
    }
}]);
