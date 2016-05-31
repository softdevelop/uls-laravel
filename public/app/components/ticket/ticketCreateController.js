var userModule = angular.module('ticket');

userModule.controller('TicketController', ['$scope','$filter','TicketService', 'UserService','FileService', '$controller', 'Upload', function($scope,$filter, TicketService, UserService, FileService, $controller, Upload) {
  $controller('BaseController', { $scope: $scope });
  angular.element('.wrapper').removeClass('hidden');
  
  //init redactor editor
  $('#content').redactor({
    imageUpload: window.baseUrl+'/file-redactor/upload-file-redactor',
    plugins: ['table', window.isAdvancedEditingFeatures == true ? 'source' : ''],
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
            $content = $('#content').redactor('code.get');
            $scope.$apply(function(){
              if($content == '<div></div>' || $content == ''|| $content == '<br>' || $content == '<div><strong></strong></div>'|| $content == '<div><em></em><strong></strong></div>'|| $content == '<div><em><del></del></em></div>') {
                  $scope.isRequiredRedactor = false;
              } else {
                  $scope.isRequiredRedactor = true;
              }
            });
        }
    },
    linkSize: 1000
  });

  $scope.baseUrl = baseUrl;
  dataInternalOld = [];
  $scope.userId = window.userId;
  $scope.decisions = window.decisions;
  $scope.opened = {'create' : false};
  $scope.open = function ($event,type) {
    $event.preventDefault();
    $event.stopPropagation();

    $scope.opened[type] = true;    
  }
  if(angular.isUndefined($scope.ticket)) {
    $scope.ticket = {};
  }
  $scope.minDate = $scope.minDate ? null : new Date();
  

  $scope.callbackLoadUserFinish = function(){
  };
  $scope.$watch(function(){
     return window.innerWidth;
      }, function(value) {
      if(value > 1200){
          TicketService.query().then(function(data){
                  $scope.tickets = data;
          })
      }
  });

  //Get number of each group ticket
  TicketService.getNumberOfTickets().then(function(dataNumber){
    $scope.numberOfTickets = dataNumber;
  });

  $scope.isRequiredRedactor = false;

  //Create ticket
  $scope.create = function (validate) {
    $scope.submitted = true;
    $content = $('#content').redactor('code.get');
    if($content == '<div></div>' || $content == ''|| $content == '<br>' || $content == '<div><strong></strong></div>'|| $content == '<div><em></em><strong></strong></div>'|| $content == '<div><em><del></del></em></div>') {
      $scope.isRequiredRedactor = false;
    } else {      
      $scope.isRequiredRedactor = true;
    }

    if(validate || $scope.isRequiredRedactor==false) {
      return; 
    }

    files_id = [];
    if(typeof $scope.filesUpload !== 'undefined'){
      files_id = $scope.filesUpload['ids'];
    }
    $scope.ticket['files_id'] = files_id;
    angular.element(".bt-submit").attr("disabled", "true");
    $scope.ticket.description = $('#content').redactor('code.get');
    
    TicketService.create($scope.ticket).then(function(data) {
        if(data.status == 0){
          $scope.error = '';
          for(var key in data.error){
            $scope.error = data.error[key]+'<br/>';
          }
          angular.element(".bt-submit").attr("disabled", "false");
        }else{
          /* redirect to detail ticket*/
          window.location = baseUrl + "/support/show/" + data.item['id'];
        }
    })

  };
}])    