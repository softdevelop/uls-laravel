
var confirmDirectiveModule = angular.module('confirmDirective', []);

confirmDirectiveModule.directive('confirm', ['$modal', '$parse','$log', function($modal, $parse, $log){
  return {
    scope: {
      option:'=',
      onConfirm: '&'
    },
    link: function(scope, el, attr){
      console.log(attr,'sfd');
      el.bind('click', function(){
        
        var instance = $modal.open({
          templateUrl: window.baseUrl+'/app/shared/confirm/view/modal.html',
          windowClass:'fix-modal-alert',

          resolve: {
                messageConfirm: function(){
                    return $parse(attr.confirm)(scope);
                },
                option: function() {
                  return scope.option;
                }
            },
          controller: ['$scope', '$modalInstance', 'messageConfirm', 'option', function(s, m, messageConfirm, option){
            s.messageConfirm = messageConfirm;
            s.option = option;
            s.ok = function(){
              m.close();
            };
            s.cancel = function(){
              m.dismiss();
            };
          }]
        });
        
        instance.result.then(function(){
          $parse(attr.onConfirm)(scope);
          scope.onConfirm();
          // console.log($parse(attr.onConfirm)(scope));
        }, 
        function(){
          // dimisss - do nothing
        });
      });
    }
  }
}])
